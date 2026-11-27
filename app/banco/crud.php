<?php
// Funções genéricas de CRUD. $tabela e as chaves de $dados vêm sempre do código, nunca do usuário.
function create(PDO $pdo, string $tabela, array $dados): int {
    $cols = implode(',', array_keys($dados));
    $ph = implode(',', array_fill(0, count($dados), '?'));
    $pdo->prepare("INSERT INTO $tabela ($cols) VALUES ($ph)")->execute(array_values($dados));
    return (int)$pdo->lastInsertId();
}

function readAll(PDO $pdo, string $tabela, array $filtro = [], string $ordem = 'id'): array {
    $where = $filtro ? 'WHERE ' . implode(' AND ', array_map(fn($c) => "$c = ?", array_keys($filtro))) : '';
    $st = $pdo->prepare("SELECT * FROM $tabela $where ORDER BY $ordem");
    $st->execute(array_values($filtro));
    return $st->fetchAll();
}

function read(PDO $pdo, string $tabela, int $id): ?array {
    $st = $pdo->prepare("SELECT * FROM $tabela WHERE id = ?");
    $st->execute([$id]);
    return $st->fetch() ?: null;
}

function update(PDO $pdo, string $tabela, int $id, array $dados): bool {
    $set = implode(',', array_map(fn($c) => "$c = ?", array_keys($dados)));
    return $pdo->prepare("UPDATE $tabela SET $set WHERE id = ?")->execute([...array_values($dados), $id]);
}

function delete(PDO $pdo, string $tabela, int $id): bool {
    return $pdo->prepare("DELETE FROM $tabela WHERE id = ?")->execute([$id]);
}
