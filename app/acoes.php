<?php
require 'init.php';
exigeLogin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfOk()) { flash('Requisição inválida.'); redireciona('index.php'); }
$acao = $_POST['acao'] ?? '';
$idEvento = (int)($_POST['evento'] ?? 0);
$uid = usuario()['id'];
$lista = buscaEventos($pdo, 'e.id = ?', [$idEvento]);
if (!$lista) { flash('Evento não encontrado.'); redireciona('index.php'); }
$ev = $lista[0];

if ($acao === 'inscrever') {
    if (vagas($ev)[2] === 0) {
        flash('Este evento está lotado.');
    } else {
        try { create($pdo, 'inscricoes', ['evento_id' => $idEvento, 'usuario_id' => $uid]); flash('Inscrição confirmada!'); }
        catch (PDOException $e) { flash('Você já está inscrito neste evento.'); }
    }
    redireciona("evento.php?id=$idEvento");
}
if ($acao === 'cancelar') {
    $pdo->prepare('DELETE FROM inscricoes WHERE evento_id = ? AND usuario_id = ?')->execute([$idEvento, $uid]);
    flash('Inscrição cancelada.');
    redireciona("evento.php?id=$idEvento");
}
if ($acao === 'excluir') {
    if ((int)$ev['organizador_id'] !== (int)$uid) { flash('Você só pode excluir os seus próprios eventos.'); redireciona('dashboard.php'); }
    delete($pdo, 'eventos', $idEvento);
    flash('Evento excluído.');
    redireciona('dashboard.php');
}
redireciona('index.php');
