<?php

/**
 * Rewrites DB_* lines in .env (removes old block, appends new).
 * Reads credentials from environment variables (no secrets in repo).
 *
 * Usage (SSH), from project root or anywhere:
 *   export DB_DATABASE=u123_dbname
 *   export DB_USERNAME=u123_user
 *   export DB_PASSWORD='your$pass+here'   # single quotes in shell help with $
 *   php scripts/patch-env-mysql.php
 *
 * DB_PASSWORD is written with single quotes in .env so characters like $ stay literal.
 *
 * Optional: DB_HOST (default localhost), DB_PORT (default 3306), DB_CONNECTION (default mysql)
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$envFile = $root . DIRECTORY_SEPARATOR . '.env';
$example = $root . DIRECTORY_SEPARATOR . '.env.example';

$db = getenv('DB_DATABASE') ?: '';
$user = getenv('DB_USERNAME') ?: '';
$pass = getenv('DB_PASSWORD');
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$connection = getenv('DB_CONNECTION') ?: 'mysql';

if ($db === '' || $user === '') {
    fwrite(STDERR, "Missing DB_DATABASE or DB_USERNAME.\n\n");
    fwrite(STDERR, "Example:\n");
    fwrite(STDERR, "  export DB_DATABASE=u123456_mydb\n");
    fwrite(STDERR, "  export DB_USERNAME=u123456_mydb\n");
    fwrite(STDERR, "  export DB_PASSWORD='...'\n");
    fwrite(STDERR, "  php scripts/patch-env-mysql.php\n");
    exit(1);
}

if ($pass === false) {
    fwrite(STDERR, "DB_PASSWORD not set. For empty password use: export DB_PASSWORD=\n");
    exit(1);
}

if (! is_file($envFile)) {
    if (! is_file($example)) {
        fwrite(STDERR, "No .env or .env.example at {$root}\n");
        exit(1);
    }
    copy($example, $envFile);
}

$keysToStrip = [
    'DB_CONNECTION',
    'DB_URL',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
];

$content = file_get_contents($envFile);
if ($content === false) {
    fwrite(STDERR, "Cannot read .env\n");
    exit(1);
}

$lines = preg_split("/\r\n|\n|\r/", $content);
$out = [];
foreach ($lines as $line) {
    $trim = ltrim($line);
    if ($trim === '' || str_starts_with($trim, '#')) {
        $out[] = $line;
        continue;
    }
    $eq = strpos($line, '=');
    if ($eq === false) {
        $out[] = $line;
        continue;
    }
    $key = trim(substr($line, 0, $eq));
    if (in_array($key, $keysToStrip, true)) {
        continue;
    }
    $out[] = $line;
}

while ($out !== [] && end($out) === '') {
    array_pop($out);
}

// Single-quoted .env value: $ and " are literal; escape \ and ' only.
$passForEnv = str_replace(['\\', "'"], ['\\\\', "\\'"], $pass);
$passLine = "DB_PASSWORD='".$passForEnv."'";

$block = [
    '',
    '# MySQL (patched by scripts/patch-env-mysql.php — '.gmdate('Y-m-d H:i:s').' UTC)',
    'DB_CONNECTION='.$connection,
    'DB_HOST='.$host,
    'DB_PORT='.$port,
    'DB_DATABASE='.$db,
    'DB_USERNAME='.$user,
    $passLine,
];

$final = implode("\n", array_merge($out, $block))."\n";

$backup = $envFile.'.bak.'.gmdate('YmdHis');
if (! copy($envFile, $backup)) {
    fwrite(STDERR, "Backup failed\n");
    exit(1);
}

if (file_put_contents($envFile, $final) === false) {
    fwrite(STDERR, "Write failed; restore from {$backup}\n");
    exit(1);
}

echo "OK: updated {$envFile}\n";
echo "Backup: {$backup}\n";
echo "Run: php artisan config:clear\n";
