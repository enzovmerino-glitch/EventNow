<?php
require 'init.php';
exigeLogin();
$id = (int)($_GET['id'] ?? 0);
$ev = [];
if ($id) {
    $lista = buscaEventos($pdo, 'e.id = ? AND e.organizador_id = ?', [$id, usuario()['id']]);
    if (!$lista) { flash('Evento não encontrado.'); redireciona('dashboard.php'); }
    $ev = $lista[0];
}
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => trim($_POST['titulo'] ?? ''),
        'descricao' => trim($_POST['descricao'] ?? ''),
        'categoria' => in_array($_POST['categoria'] ?? '', ['tecnologia', 'design', 'música'], true) ? $_POST['categoria'] : 'outros',
        'data_evento' => str_replace('T', ' ', $_POST['data_evento'] ?? ''),
        'hora_fim' => ($_POST['hora_fim'] ?? '') ?: null,
        'local_nome' => trim($_POST['local_nome'] ?? ''),
        'endereco' => trim($_POST['endereco'] ?? ''),
        'cidade' => trim($_POST['cidade'] ?? ''),
        'uf' => strtoupper(trim($_POST['uf'] ?? '')),
        'capacidade' => (int)($_POST['capacidade'] ?? 0),
        'preco' => (float)str_replace(',', '.', $_POST['preco'] ?? '0'),
        'imagem' => trim($_POST['imagem'] ?? '') ?: null,
    ];
    $ev = array_merge($ev, $dados);
    foreach (['titulo', 'descricao', 'data_evento', 'local_nome', 'endereco', 'cidade'] as $c)
        if ($dados[$c] === '') $erro = 'Preencha todos os campos obrigatórios.';
    if (!$erro && strlen($dados['uf']) !== 2) $erro = 'Informe a UF com 2 letras (ex.: SP).';
    if (!$erro && $dados['capacidade'] < 1) $erro = 'A capacidade precisa ser de pelo menos 1 vaga.';
    if (!$erro && $id && $dados['capacidade'] < (int)($lista[0]['inscritos'])) $erro = 'A capacidade não pode ser menor que o número de inscritos.';
    if (!$erro && $dados['preco'] < 0) $erro = 'O preço não pode ser negativo.';
    if (!$erro) {
        if ($id) { update($pdo, 'eventos', $id, $dados); flash('Evento atualizado.'); }
        else { $dados['organizador_id'] = usuario()['id']; create($pdo, 'eventos', $dados); flash('Evento criado.'); }
        redireciona('dashboard.php');
    }
}
$v = fn($k, $d = '') => e($ev[$k] ?? $d);
$titulo = $id ? 'Editar evento' : 'Criar evento';
include 'includes/topo.php';
?>
<section class="secao form-evento">
  <h1 class="titulo-lista"><?= $titulo ?></h1>
  <?php if ($erro): ?><p class="erro" role="alert"><?= e($erro) ?></p><?php endif; ?>
  <form method="post" class="form">
    <label>Nome do evento<input name="titulo" required value="<?= $v('titulo') ?>"></label>
    <label>Descrição<textarea name="descricao" rows="4" required><?= $v('descricao') ?></textarea></label>
    <div class="duas-cols">
      <label>Categoria<select name="categoria">
        <?php foreach (['tecnologia', 'design', 'música', 'outros'] as $c): ?>
          <option value="<?= $c ?>" <?= ($ev['categoria'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
        <?php endforeach; ?></select></label>
      <label>Data e hora de início<input type="datetime-local" name="data_evento" required value="<?= !empty($ev['data_evento']) ? e(date('Y-m-d\TH:i', strtotime($ev['data_evento']))) : '' ?>"></label>
      <label>Hora de término<input type="time" name="hora_fim" value="<?= !empty($ev['hora_fim']) ? e(substr($ev['hora_fim'], 0, 5)) : '' ?>"></label>
      <label>Nome do local<input name="local_nome" required value="<?= $v('local_nome') ?>"></label>
      <label>Endereço<input name="endereco" required value="<?= $v('endereco') ?>"></label>
      <label>Cidade<input name="cidade" required value="<?= $v('cidade') ?>"></label>
      <label>UF<input name="uf" maxlength="2" required value="<?= $v('uf') ?>"></label>
      <label>Capacidade (vagas)<input type="number" name="capacidade" min="1" required value="<?= $v('capacidade') ?>"></label>
      <label>Preço do ingresso em R$ (0 = gratuito)<input name="preco" value="<?= $v('preco', '0') ?>"></label>
      <label>Imagem (ex.: assets/img/evento.jpg)<input name="imagem" value="<?= $v('imagem') ?>"></label>
    </div>
    <div class="linha-botoes">
      <button class="btn btn-ouro"><?= $id ? 'Salvar alterações' : 'Criar evento' ?></button>
      <a class="btn btn-contorno" href="dashboard.php">Cancelar</a>
    </div>
  </form>
</section>
<?php include 'includes/rodape.php'; ?>
