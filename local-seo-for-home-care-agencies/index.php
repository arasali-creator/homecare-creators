<?php
// Retired — this is the URL Google actually has indexed (per the old
// canonical tag + sitemap), even though it never resolved correctly in
// production. Redirect it properly instead of leaving it a dead 404.
header('Location: https://homecarecreators.com/seo/home-care-seo/', true, 301);
exit;
