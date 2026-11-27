<?php
ini_set('session.gc_maxlifetime', '2592000'); // permite "lembrar deste dispositivo" por 30 dias
session_start();
require __DIR__ . '/banco/database.php';
require __DIR__ . '/banco/crud.php';

function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function usuario(): ?array { return $_SESSION['usuario'] ?? null; }
function flash(?string $msg = null): ?string {
    if ($msg !== null) { $_SESSION['flash'] = $msg; return null; }
    $m = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $m;
}
function exigeLogin(): void {
    if (!usuario()) { flash('Faça login para continuar.'); header('Location: login.php'); exit; }
}
function redireciona(string $url): void { header("Location: $url"); exit; }
function csrfCampo(): string {
    $_SESSION['csrf'] = $_SESSION['csrf'] ?? bin2hex(random_bytes(16));
    return '<input type="hidden" name="csrf" value="' . $_SESSION['csrf'] . '">';
}
function csrfOk(): bool {
    return isset($_SESSION['csrf'], $_POST['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

const MESES = ['', 'janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
function dataBR(string $dt, bool $hora = false): string {
    $t = strtotime($dt);
    $s = date('j', $t) . ' de ' . MESES[(int)date('n', $t)] . ' de ' . date('Y', $t);
    return $hora ? $s . ' às ' . date('H:i', $t) : $s;
}
function dinheiro(float $v): string { return 'R$' . number_format($v, 2, ',', '.'); }

// Eventos com total de inscritos e nome do organizador.
function buscaEventos(PDO $pdo, string $where = '1=1', array $params = []): array {
    $st = $pdo->prepare("SELECT e.*, u.nome AS organizador,
        (SELECT COUNT(*) FROM inscricoes i WHERE i.evento_id = e.id) AS inscritos
        FROM eventos e JOIN usuarios u ON u.id = e.organizador_id
        WHERE $where ORDER BY e.data_evento");
    $st->execute($params);
    return $st->fetchAll();
}

// [classe, rótulo, vagas restantes, % de vagas livres]
function vagas(array $ev): array {
    $cap = max(1, (int)$ev['capacidade']);
    $livres = max(0, $cap - (int)$ev['inscritos']);
    $pct = (int)round($livres / $cap * 100);
    if ($livres === 0) return ['lotado', 'Lotado', 0, 0];
    if ($livres / $cap <= 0.2) return ['quase', 'Quase lotado', $livres, $pct];
    return ['ok', 'Disponível', $livres, $pct];
}
function capaEstilo(array $ev): string {
    return empty($ev['imagem']) ? '' : "background-image:url('" . e($ev['imagem']) . "')";
}
function variacao(float $atual, float $anterior): ?float {
    return $anterior > 0 ? ($atual - $anterior) / $anterior * 100 : null;
}

// Ícones de traço (SVG inline)
function ic(string $n, int $s = 24, string $cls = ''): string {
    static $d = [
        'casa' => '<path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>',
        'festa' => '<path d="m3 21 5-14 9 9z"/><path d="M14 3v2M19 8h2M17 4l1 1M20 13l1-1"/>',
        'grade' => '<rect x="3" y="3" width="8" height="10" rx="2"/><rect x="13" y="3" width="8" height="6" rx="2"/><rect x="13" y="11" width="8" height="10" rx="2"/><rect x="3" y="15" width="8" height="6" rx="2"/>',
        'calendario' => '<rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18M8 14h2M12 14h2M16 14h2M8 18h2M12 18h2"/>',
        'pin' => '<path d="M12 22s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/>',
        'relogio' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'raio' => '<path d="M13 2 4 14h7l-1 8 9-12h-7z"/>',
        'usuario' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>',
        'usuarios' => '<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-6 7-6s7 2.5 7 6M16 4.5a3.5 3.5 0 0 1 0 7M18 14c2.5.6 4 2.5 4 6"/>',
        'carrinho' => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.7 12.4a1 1 0 0 0 1 .8h8.8a1 1 0 0 0 1-.8L20 7H6"/>',
        'grafico' => '<path d="M3 21h18M6 17v-5M11 17V8M16 17v-9M21 17V4"/>',
        'sair' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-7M21 12H9"/>',
        'ingresso' => '<path d="M3 9V6h18v3a3 3 0 0 0 0 6v3H3v-3a3 3 0 0 0 0-6z"/><path d="M14 6v12" stroke-dasharray="2 2"/>',
        'prancheta' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 13l2 2 4-4"/>',
        'olho' => '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
        'check' => '<path d="m5 12 5 5 9-10"/>',
        'cadeado' => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>',
        'alerta' => '<path d="M12 3 2 20h20z"/><path d="M12 10v4M12 17.5v.01"/>',
        'lapis' => '<path d="M4 20h4L19 9l-4-4L4 16z"/>',
        'lixeira' => '<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/>',
        'seta' => '<path d="M3 17l6-6 4 4 8-8M15 7h6v6"/>',
        'baixo' => '<path d="m6 9 6 6 6-6"/>',
        'mais' => '<circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>',
        'entrar' => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>',
        'novo_usuario' => '<circle cx="10" cy="8" r="4"/><path d="M2 21c0-4 3.6-7 8-7M18 14v6M15 17h6"/>',
    ];
    return '<svg class="ic ' . $cls . '" width="' . $s . '" height="' . $s . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d[$n] . '</svg>';
}
