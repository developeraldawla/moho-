<?php
$envPath = __DIR__ . '/../.env';
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (!strpos($line, '=')) continue;
    list($k, $v) = explode('=', $line, 2);
    $env[trim($k)] = trim(trim($v), "\"'");
}
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$dbname = $env['DB_DATABASE'] ?? 'moho';
$user = $env['DB_USERNAME'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';
$dsn = "mysql:host={$host};port={$port};dbname={$dbname}";
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT COUNT(*) as c FROM usage_logs");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "USAGE_COUNT: {$row['c']}\n";
} catch (Exception $e) {
    echo 'ERR: '.$e->getMessage()."\n";
    exit(1);
}
