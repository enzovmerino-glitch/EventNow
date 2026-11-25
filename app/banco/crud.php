<?php
require_once 'database.php';

function listarEventos() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM eventos ORDER BY data_hora ASC LIMIT 4");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>