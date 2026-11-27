<?php
// Conexão PDO usando as variáveis de ambiente do compose.
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$base = getenv('DB_DATABASE') ?: 'eventnow_db';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: 'Senai123';

$pdo = null;
for ($i = 0; $i < 15 && !$pdo; $i++) {
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$base;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        sleep(2); // banco ainda iniciando
    }
}
if (!$pdo) {
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados.');
}
