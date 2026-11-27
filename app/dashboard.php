<?php
require 'init.php';
exigeLogin();
$uid = usuario()['id'];
$secao = in_array($_GET['secao'] ?? '', ['vendas', 'relatorios'], true) ? $_GET['secao'] : 'eventos';
$eventos = buscaEventos($pdo, 'e.organizador_id = ?', [$uid]);
$vendidos = array_sum(array_column($eventos, 'inscritos'));
$total = array_sum(array_column($eventos, 'capacidade'));
$receita = 0.0;
foreach ($eventos as $ev) $receita += $ev['inscritos'] * $ev['preco'];

// Vendas por mês (para comparar com o mês anterior)
$st = $pdo->prepare("SELECT DATE_FORMAT(i.criado_em, '%Y-%m') AS ym, COUNT(*) AS n, SUM(e.preco) AS r
    FROM inscricoes i JOIN eventos e ON e.id = i.evento_id WHERE e.organizador_id = ? GROUP BY ym");
$st->execute([$uid]);
$mes = array_column($st->fetchAll(), null, 'ym');
$atual = date('Y-m'); $anterior = date('Y-m', strtotime('first day of last month'));
$varIngressos = variacao((float)($mes[$atual]['n'] ?? 0), (float)($mes[$anterior]['n'] ?? 0));
$varReceita = variacao((float)($mes[$atual]['r'] ?? 0), (float)($mes[$anterior]['r'] ?? 0));
function seloVar(?float $v): string {
    if ($v === null) return '';
    $cls = $v >= 0 ? 'sobe' : 'desce';
    return '<span class="cresc ' . $cls . '">' . ic('seta', 30) . ' ' . round(abs($v)) . '%</span><small>Em relação ao mês anterior</small>';
}

$titulo = 'Dashboard';
$painel = true;
include 'includes/topo.php';
?>
<div class="painel">
  <aside class="lateral">
    <a class="logo" href="index.php"><span class="logo-e">E</span><span class="logo-nome">EVENTNOW<small>DESDE 2026</small></span></a>
    <nav>
      <a class="<?= $secao === 'eventos' ? 'ativo' : '' ?>" href="dashboard.php"><?= ic('casa', 34) ?> Meus Eventos</a>
      <a class="<?= $secao === 'vendas' ? 'ativo' : '' ?>" href="dashboard.php?secao=vendas"><?= ic('carrinho', 34) ?> Vendas</a>
      <a class="<?= $secao === 'relatorios' ? 'ativo' : '' ?>" href="dashboard.php?secao=relatorios"><?= ic('grafico', 34) ?> Relatórios</a>
    </nav>
    <a class="sair" href="logout.php"><?= ic('sair', 34) ?> Sair</a>
  </aside>

  <main class="painel-corpo">
    <div class="painel-topo">
      <h1>Olá, <?= e(usuario()['nome']) ?></h1>
      <div class="painel-acoes">
        <a class="btn btn-ouro" href="evento_form.php"><?= ic('mais', 20) ?> Criar Evento</a>
        <span class="avatar-topo" title="<?= e(usuario()['email']) ?>"><?= ic('usuario', 44) ?></span>
      </div>
    </div>

    <div class="metricas">
      <div class="metrica"><h3><?= ic('ingresso', 34, 'amarelo') ?> Ingressos vendidos</h3><strong><?= $vendidos ?></strong><b>de <?= $total ?> no total</b><?= seloVar($varIngressos) ?></div>
      <div class="metrica"><h3><?= ic('prancheta', 34, 'amarelo') ?> Vagas restantes</h3><strong><?= max(0, $total - $vendidos) ?></strong><b>de <?= $total ?> no total</b></div>
      <div class="metrica"><h3><span class="moeda">$</span> Receita arrecadada</h3><strong><?= dinheiro($receita) ?></strong><b>Total de vendas</b><?= seloVar($varReceita) ?></div>
    </div>

    <?php if ($secao === 'eventos'): ?>
      <h2 class="titulo-lista">Lista de Eventos</h2>
      <?php if (!$eventos): ?>
        <p class="vazio">Você ainda não criou nenhum evento. <a href="evento_form.php">Criar o primeiro evento</a>.</p>
      <?php else: ?>
      <div class="tabela-rolagem"><table class="tabela">
        <thead><tr><th>Evento</th><th>Data e Hora</th><th>Local</th><th>Lotação</th><th>Ações</th></tr></thead>
        <tbody>
        <?php foreach ($eventos as $ev): [$cls, $rot] = vagas($ev); ?>
          <tr>
            <td><div class="evento-cel"><span class="miniatura capa-<?= e($ev['categoria']) ?>" style="<?= capaEstilo($ev) ?>"></span><a href="evento.php?id=<?= $ev['id'] ?>"><?= e($ev['titulo']) ?></a></div></td>
            <td><div class="icone-cel"><?= ic('calendario', 18) ?><span><?= e(date('d/m/Y', strtotime($ev['data_evento']))) ?><br><?= date('H:i', strtotime($ev['data_evento'])) ?></span></div></td>
            <td><div class="icone-cel"><?= ic('pin', 18) ?><span><?= e($ev['local_nome']) ?></span></div></td>
            <td><div class="icone-cel"><?= ic('usuarios', 18) ?><span><?= $ev['inscritos'] ?>/<?= $ev['capacidade'] ?></span>
              <span class="selo selo-<?= $cls ?>"><?= $cls === 'lotado' ? ic('cadeado', 14) : ($cls === 'quase' ? ic('alerta', 14) : ic('check', 14)) ?> <?= $rot ?></span></div></td>
            <td><div class="acoes">
              <a class="btn btn-azul btn-peq" href="evento_form.php?id=<?= $ev['id'] ?>"><?= ic('lapis', 16) ?> Editar</a>
              <form method="post" action="acoes.php" onsubmit="return confirm('Excluir este evento e todas as inscrições?')">
                <?= csrfCampo() ?><input type="hidden" name="acao" value="excluir"><input type="hidden" name="evento" value="<?= $ev['id'] ?>">
                <button class="btn btn-vermelho btn-peq"><?= ic('lixeira', 16) ?> Excluir</button>
              </form></div></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>

    <?php elseif ($secao === 'vendas'):
      $st = $pdo->prepare('SELECT i.criado_em, u.nome, u.email, e.titulo, e.preco FROM inscricoes i JOIN usuarios u ON u.id = i.usuario_id JOIN eventos e ON e.id = i.evento_id WHERE e.organizador_id = ? ORDER BY i.criado_em DESC LIMIT 100');
      $st->execute([$uid]); $vendas = $st->fetchAll(); ?>
      <h2 class="titulo-lista">Vendas</h2>
      <?php if (!$vendas): ?><p class="vazio">Nenhuma inscrição até agora.</p><?php else: ?>
      <div class="tabela-rolagem"><table class="tabela">
        <thead><tr><th>Participante</th><th>E-mail</th><th>Evento</th><th>Valor</th><th>Data</th></tr></thead>
        <tbody><?php foreach ($vendas as $v): ?>
          <tr><td><?= e($v['nome']) ?></td><td><?= e($v['email']) ?></td><td><?= e($v['titulo']) ?></td><td><?= dinheiro((float)$v['preco']) ?></td><td><?= e(dataBR($v['criado_em'])) ?></td></tr>
        <?php endforeach; ?></tbody>
      </table></div><?php endif; ?>

    <?php else: ?>
      <h2 class="titulo-lista">Relatórios</h2>
      <div class="tabela-rolagem"><table class="tabela">
        <thead><tr><th>Evento</th><th>Inscritos</th><th>Capacidade</th><th>Ocupação</th><th>Receita</th></tr></thead>
        <tbody><?php foreach ($eventos as $ev): ?>
          <tr><td><?= e($ev['titulo']) ?></td><td><?= $ev['inscritos'] ?></td><td><?= $ev['capacidade'] ?></td><td><?= round($ev['inscritos'] / max(1, $ev['capacidade']) * 100) ?>%</td><td><?= dinheiro($ev['inscritos'] * $ev['preco']) ?></td></tr>
        <?php endforeach; ?></tbody>
      </table></div>
    <?php endif; ?>
  </main>
</div>
</body>
</html>
