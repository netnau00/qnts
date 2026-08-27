<?php
/**
 * antibot.php
 *
 * Lightweight bot/crawler filter shared by the front-end PHP pages.
 * Blocks requests coming from known bot/crawler user agents and logs
 * blocked attempts to bot_attempts.log (matching the existing log format).
 */

$botUserAgentSignatures = [
    'bot',
    'spider',
    'crawl',
    'slurp',
    'facebookexternalhit',
    'telegrambot',
    'curl',
    'wget',
    'python-requests',
    'scrapy',
    'headless',
    'phantomjs',
    'ahrefsbot',
    'semrushbot',
    'mj12bot',
];

$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

foreach ($botUserAgentSignatures as $signature) {
    if ($userAgent !== '' && stripos($userAgent, $signature) !== false) {
        $logLine = date('Y-m-d H:i:s') . " - BOT BLOCKED - IP: {$ip} - UA: {$userAgent}" . PHP_EOL;
        @file_put_contents(__DIR__ . '/bot_attempts.log', $logLine, FILE_APPEND);

        http_response_code(403);
        exit('Access denied.');
    }
}
