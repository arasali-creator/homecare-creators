<?php
/**
 * Minimal SMTP mailer — no dependencies, pure PHP sockets.
 * Falls back to mail() if SMTP not configured.
 */
class HcMailer
{
    private $sock = null;

    private function connect(string $host, int $port, string $enc): bool
    {
        $ctx = stream_context_create([
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
        ]);

        if (strtolower($enc) === 'ssl') {
            $this->sock = @stream_socket_client(
                "ssl://{$host}:{$port}", $errno, $errstr, 15,
                STREAM_CLIENT_CONNECT, $ctx
            );
        } else {
            $this->sock = @fsockopen($host, $port, $errno, $errstr, 15);
        }

        return (bool)$this->sock;
    }

    private function read(): string
    {
        $out = '';
        stream_set_timeout($this->sock, 10);
        while ($line = fgets($this->sock, 512)) {
            $out .= $line;
            if (substr($line, 3, 1) === ' ') break;
        }
        return $out;
    }

    private function cmd(string $cmd): string
    {
        fwrite($this->sock, $cmd . "\r\n");
        return $this->read();
    }

    private function close(): void
    {
        if ($this->sock) { @fclose($this->sock); $this->sock = null; }
    }

    public $lastError = '';
    public $htmlBody  = '';

    public function sendSmtp(
        string $smtpHost,
        int    $smtpPort,
        string $smtpEnc,
        string $smtpUser,
        string $smtpPass,
        string $fromAddr,
        string $fromName,
        string $toAddr,
        string $replyTo,
        string $cc,
        string $subject,
        string $body
    ): bool {
        try {
            if (!$this->connect($smtpHost, $smtpPort, $smtpEnc)) {
                $this->lastError = "Cannot connect to {$smtpHost}:{$smtpPort} — check host/port and firewall.";
                return false;
            }

            $this->read(); // server greeting

            $this->cmd("EHLO homecarecreators.com");

            if (strtolower($smtpEnc) === 'tls') {
                $resp = $this->cmd("STARTTLS");
                if (substr($resp, 0, 3) !== '220') {
                    $this->lastError = "STARTTLS rejected: " . trim($resp);
                    $this->close(); return false;
                }
                $ctx = stream_context_create([
                    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
                ]);
                $method = STREAM_CRYPTO_METHOD_TLS_CLIENT
                    | (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT') ? STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT : 0)
                    | (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT') ? STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT : 0);
                if (!stream_socket_enable_crypto($this->sock, true, $method)) {
                    $this->lastError = "TLS handshake failed — PHP may need OpenSSL or the server requires a newer TLS version.";
                    $this->close(); return false;
                }
                $this->cmd("EHLO homecarecreators.com");
            }

            if ($smtpUser && $smtpPass) {
                $resp = $this->cmd("AUTH LOGIN");
                if (substr($resp, 0, 3) !== '334') {
                    $this->lastError = "AUTH LOGIN rejected: " . trim($resp);
                    $this->close(); return false;
                }
                $resp = $this->cmd(base64_encode($smtpUser));
                if (substr($resp, 0, 3) !== '334') {
                    $this->lastError = "Username rejected: " . trim($resp);
                    $this->close(); return false;
                }
                $resp = $this->cmd(base64_encode($smtpPass));
                if (substr($resp, 0, 3) !== '235') {
                    $this->lastError = "Authentication failed (wrong password?): " . trim($resp);
                    $this->close(); return false;
                }
            }

            // Zoho and many providers require MAIL FROM to match the authenticated user
            $envelopeFrom = $smtpUser ?: $fromAddr;

            $resp = $this->cmd("MAIL FROM:<{$envelopeFrom}>");
            if (substr($resp, 0, 3) !== '250') {
                $this->lastError = "MAIL FROM rejected: " . trim($resp);
                $this->close(); return false;
            }
            $resp = $this->cmd("RCPT TO:<{$toAddr}>");
            if (substr($resp, 0, 3) !== '250' && substr($resp, 0, 3) !== '251') {
                $this->lastError = "RCPT TO rejected: " . trim($resp);
                $this->close(); return false;
            }
            if ($cc) $this->cmd("RCPT TO:<{$cc}>");

            $resp = $this->cmd("DATA");
            if (substr($resp, 0, 3) !== '354') {
                $this->lastError = "DATA command rejected: " . trim($resp);
                $this->close(); return false;
            }

            $date    = date('r');
            $msgId   = '<' . time() . '.hc@homecarecreators.com>';
            $encSubj = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $encFrom = '=?UTF-8?B?' . base64_encode($fromName) . '?=';
            $boundary = 'hcbnd_' . md5(uniqid());

            $msg  = "Date: {$date}\r\n";
            $msg .= "Message-ID: {$msgId}\r\n";
            $msg .= "From: {$encFrom} <{$envelopeFrom}>\r\n";
            $msg .= "To: {$toAddr}\r\n";
            if ($cc) $msg .= "Cc: {$cc}\r\n";
            if ($replyTo) $msg .= "Reply-To: {$replyTo}\r\n";
            $msg .= "Subject: {$encSubj}\r\n";
            $msg .= "MIME-Version: 1.0\r\n";

            if (!empty($this->htmlBody)) {
                $msg .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
                $msg .= "\r\n";
                $msg .= "--{$boundary}\r\n";
                $msg .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $msg .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $msg .= chunk_split(base64_encode($body)) . "\r\n";
                $msg .= "--{$boundary}\r\n";
                $msg .= "Content-Type: text/html; charset=UTF-8\r\n";
                $msg .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $msg .= chunk_split(base64_encode($this->htmlBody)) . "\r\n";
                $msg .= "--{$boundary}--";
            } else {
                $msg .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $msg .= "Content-Transfer-Encoding: base64\r\n";
                $msg .= "\r\n";
                $msg .= chunk_split(base64_encode($body));
            }

            $msg .= "\r\n.";

            $resp = $this->cmd($msg);
            $this->cmd("QUIT");
            $this->close();

            if (substr($resp, 0, 3) !== '250') {
                $this->lastError = "Message rejected by server: " . trim($resp);
                return false;
            }
            return true;
        } catch (Exception $e) {
            $this->lastError = "Exception: " . $e->getMessage();
            $this->close();
            return false;
        }
    }

    /**
     * Main entry point. Uses SMTP if configured, falls back to mail().
     * $html: optional HTML version of the body (sends multipart/alternative if provided).
     */
    public static function send(
        string $to,
        string $subject,
        string $body,
        string $replyTo = '',
        string $cc      = '',
        string $html    = ''
    ): bool {
        $fromAddr = hc_setting('reply_to_email', 'noreply@homecarecreators.com');
        $fromName = hc_setting('site_name', 'Homecare Creators');
        $smtpHost = hc_setting('smtp_host', '');
        $smtpPort = (int)hc_setting('smtp_port', '587');
        $smtpEnc  = hc_setting('smtp_enc', 'tls');
        $smtpUser = hc_setting('smtp_user', '');
        $smtpPass = hc_setting('smtp_pass', '');

        if ($smtpHost && $smtpUser) {
            $mailer = new self();
            $mailer->htmlBody = $html;
            $ok = $mailer->sendSmtp(
                $smtpHost, $smtpPort, $smtpEnc,
                $smtpUser, $smtpPass,
                $fromAddr, $fromName,
                $to, $replyTo, $cc,
                $subject, $body
            );
            if (!$ok) {
                $GLOBALS['_hc_mailer_last_error'] = $mailer->lastError;
            }
            return $ok;
        }

        // Fallback: PHP mail()
        $boundary = 'hcbnd_' . md5(uniqid());
        if ($html) {
            $headers  = "From: {$fromAddr}\r\n";
            if ($replyTo) $headers .= "Reply-To: {$replyTo}\r\n";
            if ($cc)      $headers .= "Cc: {$cc}\r\n";
            $headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
            $mbody  = "--{$boundary}\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n{$body}\r\n";
            $mbody .= "--{$boundary}\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n{$html}\r\n";
            $mbody .= "--{$boundary}--";
            return mail($to, $subject, $mbody, $headers);
        }
        $headers  = "From: {$fromAddr}\r\n";
        if ($replyTo) $headers .= "Reply-To: {$replyTo}\r\n";
        if ($cc)      $headers .= "Cc: {$cc}\r\n";
        $headers .= "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        return mail($to, $subject, $body, $headers);
    }
}
