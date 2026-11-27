<?php
require 'init.php';
$id = (int)($_GET['id'] ?? 0);
$lista = buscaEventos($pdo, 'e.id = ?', [$id]);
if (!$lista) {
    http_response_code(404); $titulo = 'Evento não encontrado';
    include 'includes/topo.php';
    echo '<p class="vazio">Evento não encontrado. <a href="index.php">Voltar para o início</a>.</p>';
    include 'includes/rodape.php'; exit;
}
$ev = $lista[0];
[$cls, $rot, $livres, $pct] = vagas($ev);
$inscrito = false;
if (usuario()) {
    $st = $pdo->prepare('SELECT 1 FROM inscricoes WHERE evento_id = ? AND usuario_id = ?');
    $st->execute([$id, usuario()['id']]);
    $inscrito = (bool)$st->fetch();
}
$dias = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
$t = strtotime($ev['data_evento']);
$horario = date('H:i', $t) . ($ev['hora_fim'] ? ' - ' . substr($ev['hora_fim'], 0, 5) : '');
$titulo = $ev['titulo'];
include 'includes/topo.php';
?>
<article class="detalhe">
  <div class="capa-grande capa-<?= e($ev['categoria']) ?>" style="<?= capaEstilo($ev) ?>"></div>
  <div class="detalhe-corpo">
    <h1><?= e($ev['titulo']) ?></h1>
    <h2>Sobre o Evento</h2>
    <p class="sobre"><?= nl2br(e($ev['descricao'])) ?></p>

    <div class="caixa-info">
      <h2>Informações Principais</h2>
      <p><?= ic('calendario', 32) ?> Data: <?= $dias[(int)date('w', $t)] ?>, <?= e(dataBR($ev['data_evento'])) ?></p>
      <p><?= ic('relogio', 32) ?> Hora: <?= $horario ?></p>
      <p><?= ic('pin', 32) ?> Local: <?= e($ev['local_nome']) ?> - <?= e($ev['endereco']) ?>, <?= e($ev['cidade']) ?>, <?= e($ev['uf']) ?></p>
      <p><?= ic('ingresso', 32) ?> Ingresso: <?= $ev['preco'] > 0 ? dinheiro((float)$ev['preco']) : 'Gratuito' ?></p>
      <hr>
      <h2>Quem está Organizando</h2>
      <div class="organizador"><span class="foto-org"><?= ic('usuario', 44) ?></span><span><?= e($ev['organizador']) ?></span></div>
    </div>

    <div class="inscricao">
      <div class="botoes-inscricao">
        <?php if (!usuario()): ?>
          <a class="btn btn-azul btn-largo" href="login.php">Entrar para se inscrever</a>
        <?php else: ?>
          <form method="post" action="acoes.php">
            <?= csrfCampo() ?><input type="hidden" name="acao" value="inscrever"><input type="hidden" name="evento" value="<?= $id ?>">
            <button class="btn btn-azul btn-largo" <?= ($inscrito || $livres === 0) ? 'disabled' : '' ?>><?= $inscrito ? 'Você já está inscrito' : 'Inscrever-se' ?></button>
          </form>
          <form method="post" action="acoes.php">
            <?= csrfCampo() ?><input type="hidden" name="acao" value="cancelar"><input type="hidden" name="evento" value="<?= $id ?>">
            <button class="btn btn-vermelho btn-largo" <?= $inscrito ? '' : 'disabled' ?>>Cancelar Inscrição</button>
          </form>
        <?php endif; ?>
      </div>
      <div class="caixa-vagas">
        <h2>Vagas Disponíveis</h2>
        <div class="anel" style="--p:<?= $pct ?>"><span><?= $pct ?>%</span></div>
        <p class="restantes"><?= $livres ?> Vagas Restantes</p>
        <span class="selo selo-<?= $cls ?>"><?= $cls === 'lotado' ? ic('cadeado', 16) : ic('check', 16) ?> <?= mb_strtolower($rot) ?></span>
      </div>
    </div>
  </div>
</article>
<?php include 'includes/rodape.php'; ?>
