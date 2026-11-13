<?php
require 'init.php';
$titulo = 'Início';
$q = trim($_GET['q'] ?? '');
$cat = $_GET['cat'] ?? '';
$where = ['e.data_evento >= NOW()']; $p = [];
if ($q !== '') { $where[] = '(e.titulo LIKE ? OR e.cidade LIKE ?)'; $p[] = "%$q%"; $p[] = "%$q%"; }
if ($cat !== '') { $where[] = 'e.categoria = ?'; $p[] = $cat; }
$eventos = buscaEventos($pdo, implode(' AND ', $where), $p);
$cats = ['' => 'todos', 'tecnologia' => 'tecnologia', 'design' => 'design', 'música' => 'música'];
include 'includes/topo.php';
?>
<section class="hero">
  <h1>EventNow</h1>
  <p>Conectando pessoas a grandes experiências.</p>
  <form class="busca" action="index.php#eventos" method="get">
    <?php if ($cat !== ''): ?><input type="hidden" name="cat" value="<?= e($cat) ?>"><?php endif; ?>
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Buscar eventos por nome ou cidade..." aria-label="Buscar eventos por nome ou cidade">
  </form>
</section>

<section class="secao" id="eventos">
  <div class="secao-cab">
    <div><h2>Eventos em destaque</h2><p>Confira as experiências mais populares com inscrições abertas</p></div>
    <div class="chips">
      <?php foreach ($cats as $valor => $rotulo): ?>
        <a class="chip <?= $cat === $valor ? 'ativo' : '' ?>" href="?<?= http_build_query(array_filter(['q' => $q, 'cat' => $valor])) ?>#eventos"><?= e($rotulo) ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if (!$eventos): ?>
    <p class="vazio">Nenhum evento encontrado. Tente outro nome ou cidade, ou <a href="index.php#eventos">veja todos os eventos</a>.</p>
  <?php endif; ?>

  <div class="grade-cards">
    <?php foreach ($eventos as $ev): ?>
      <a class="card-evento" href="evento.php?id=<?= $ev['id'] ?>">
        <div class="capa capa-<?= e($ev['categoria']) ?>" style="<?= capaEstilo($ev) ?>"></div>
        <div class="card-corpo">
          <div class="linha-info">
            <span><?= ic('calendario', 34) ?> <?= e(dataBR($ev['data_evento'])) ?></span>
            <span><?= ic('pin', 30, 'cheio') ?> <?= e($ev['cidade']) ?>-<?= e($ev['uf']) ?></span>
          </div>
          <h3><?= e($ev['titulo']) ?></h3>
          <p><?= e($ev['descricao']) ?></p>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="secao vantagens">
  <span class="pilula">vantagens</span>
  <h2>Por que escolher a EventNow?</h2>
  <p class="sub">Desenvolvido para oferecer controle total aos organizadores e facilidade máxima aos participantes</p>
  <div class="grade-vantagens">
    <div class="vantagem"><span class="icone"><?= ic('raio', 38) ?></span><div><h3>Inscrição instantânea</h3><p>Garanta a sua participação sem cadastro demorado ou complicações. Receba os ingressos direto do seu e-mail.</p></div></div>
    <div class="vantagem"><span class="icone"><?= ic('usuario', 38) ?></span><div><h3>Controle de Vagas e vendas</h3><p>Acompanhe métricas em tempo real. Gerencie ingressos, lotação e faturamento em um painel simples e completo.</p></div></div>
    <div class="vantagem"><span class="icone"><?= ic('usuario', 38) ?></span><div><h3>Check-in prático</h3><p>Credenciamento ágil com QR code diretamente pelo celular dos participantes na entrada dos eventos.</p></div></div>
  </div>
</section>
<?php include 'includes/rodape.php'; ?>
