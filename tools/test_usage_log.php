<?php
// tools/test_usage_log.php
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
    // Insert a tool if none exists
    $stmt = $pdo->query("SELECT id FROM tools LIMIT 1");
    $tool = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tool) {
        $pdo->exec("INSERT INTO tools (name,description,created_at,updated_at) VALUES ('Test Tool','For smoke test',NOW(),NOW())");
        $toolId = $pdo->lastInsertId();
        echo "TOOL_CREATED: $toolId\n";
    } else {
        $toolId = $tool['id'];
        echo "TOOL_EXISTS: $toolId\n";
    }
    // Insert a usage log referencing user_id=1
    $pdo->exec("INSERT INTO usage_logs (user_id,tool_id,input_data,output_data,status,ip_address,user_agent,created_at,updated_at) VALUES (1, {$toolId}, JSON_ARRAY('x'), JSON_ARRAY('y'), 'success', '127.0.0.1', 'test-agent', NOW(), NOW())");
    echo "USAGE_INSERTED\n";
    $c = $pdo->query("SELECT COUNT(*) as c FROM usage_logs")->fetch(PDO::FETCH_ASSOC);
    echo "USAGE_COUNT: {$c['c']}\n";
} catch (Exception $e) {
    echo 'ERR: '.$e->getMessage()."\n";
    exit(1);
}
