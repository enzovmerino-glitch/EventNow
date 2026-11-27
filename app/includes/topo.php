<?php
// Entradas: $titulo (opcional) e $painel (true = sem o cabeçalho do site)
$u = usuario();
$msg = flash();
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titulo ?? 'EventNow') ?> | EventNow</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (empty($painel)): ?>
<header class="topo">
  <a href="index.php" class="logo-img">
    <img src="assets/img/logo.png" alt="EventNow" style="height:60px;width:auto;display:block">
  </a>
  <nav class="menu">
    <a href="index.php"><?= ic('casa') ?> Início</a>
    <a href="index.php#eventos"><?= ic('festa') ?> Eventos</a>
    <a href="dashboard.php"><?= ic('grade') ?> Dashboard</a>
  </nav>
  <div class="topo-acoes">
    <?php if ($u): ?>
      <span class="ola">Olá, <?= e(explode(' ', $u['nome'])[0]) ?></span>
      <a href="logout.php">Sair</a>
    <?php else: ?>
      <a href="login.php">Entrar</a>
    <?php endif; ?>
    <a class="btn btn-ouro" href="evento_form.php"><?= ic('mais', 20) ?> Criar Evento</a>
  </div>
</header>
<?php endif; ?>
<?php if ($msg): ?><div class="aviso" role="status"><?= e($msg) ?></div><?php endif; ?>