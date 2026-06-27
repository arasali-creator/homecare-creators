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
            if (!$this->connect($smtpHost, $smtpPort, $smtpEnc)) return false;

            $this->read(); // server greeting

            $this->cmd("EHLO homecarecreators.com");

            if (strtolower($smtpEnc) === 'tls') {
                $resp = $this->cmd("STARTTLS");
                if (substr($resp, 0, 3) !== '220') { $this->close(); return false; }
                $ctx = stream_context_create([
                    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
                ]);
                if (!stream_socket_enable_crypto($this->sock, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    $this->close(); return false;
                }
                $this->cmd("EHLO homecarecreators.com");
            }

            if ($smtpUser && $smtpPass) {
                $resp = $this->cmd("AUTH LOGIN");
                if (substr($resp, 0, 3) !== '334') { $this->close(); return false; }
                $this->cmd(base64_encode($smtpUser));
                $resp = $this->cmd(base64_encode($smtpPass));
                if (substr($resp, 0, 3) !== '235') { $this->close(); return false; }
            }

            $this->cmd("MAIL FROM:<{$fromAddr}>");
            $this->cmd("RCPT TO:<{$toAddr}>");
            if ($cc) $this->cmd("RCPT TO:<{$cc}>");
            $this->cmd("DATA");

            $date    = date('r');
            $msgId   = '<' . time() . '.hc@homecarecreators.com>';
            $encSubj = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $encFrom = '=?UTF-8?B?' . base64_encode($fromName) . '?=';

            $msg  = "Date: {$date}\r\n";
            $msg .= "Message-ID: {$msgId}\r\n";
            $msg .= "From: {$encFrom} <{$fromAddr}>\r\n";
            $msg .= "To: {$toAddr}\r\n";
            if ($cc) $msg .= "Cc: {$cc}\r\n";
            if ($replyTo) $msg .= "Reply-To: {$replyTo}\r\n";
            $msg .= "Subject: {$encSubj}\r\n";
            $msg .= "MIME-Version: 1.0\r\n";
            $msg .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $msg .= "Content-Transfer-Encoding: base64\r\n";
            $msg .= "\r\n";
            $msg .= chunk_split(base64_encode($body));
            $msg .= "\r\n.";

            $resp = $this->cmd($msg);
            $this->cmd("QUIT");
            $this->close();

            return substr($resp, 0, 3) === '250';
        } catch (Exception $e) {
            $this->close();
            return false;
        }
    }

    /**
     * Main entry point. Uses SMTP if configured, falls back to mail().
     */
    public static function send(
        string $to,
        string $subject,
        string $body,
        string $replyTo = '',
        string $cc      = ''
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
            return $mailer->sendSmtp(
                $smtpHost, $smtpPort, $smtpEnc,
                $smtpUser, $smtpPass,
                $fromAddr, $fromName,
                $to, $replyTo, $cc,
                $subject, $body
            );
        }

        // Fallback: PHP mail()
        $headers  = "From: {$fromAddr}\r\n";
        if ($replyTo) $headers .= "Reply-To: {$replyTo}\r\n";
        if ($cc)      $headers .= "Cc: {$cc}\r\n";
        $headers .= "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        return mail($to, $subject, $body, $headers);
    }
}
