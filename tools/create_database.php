<?php
// tools/create_database.php
// Reads .env in project root and creates the database if it doesn't exist.
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    echo "ERROR: .env not found\n";
    exit(1);
}
// Parse simple KEY=VALUE pairs
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (!strpos($line, '=')) continue;
    list($k, $v) = explode('=', $line, 2);
    $k = trim($k);
    $v = trim($v);
    $v = trim($v, "\"'");
    $env[$k] = $v;
}
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$dbname = $env['DB_DATABASE'] ?? 'moho';
$user = $env['DB_USERNAME'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';
$dsn = "mysql:host={$host};port={$port}";
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "DB_OK: Database '{$dbname}' is present or created.\n";
    exit(0);
} catch (PDOException $e) {
    echo "DB_ERR: " . $e->getMessage() . "\n";
    exit(2);
}
