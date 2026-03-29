<?php
header("Content-Security-Policy: " .
    "default-src 'self'; " .
    "script-src 'self' https://cdn.jsdelivr.net https://code.jquery.com; " .  // ← Bootstrap + jQuery
    "style-src 'self' https://cdn.jsdelivr.net 'unsafe-inline'; " .          // ← Bootstrap CSS
    "font-src 'self' https://cdn.jsdelivr.net; " .                           // ← Bootstrap Icons
    "img-src 'self' https: data:; " .
    "connect-src 'self' https:; " .
    "frame-ancestors 'none'; " .
    "base-uri 'self'; " .
    "form-action 'self';"
);
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("X-Content-Type-Options: nosniff");
?>