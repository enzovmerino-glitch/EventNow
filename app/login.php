<?php
require 'init.php';
$aba = ($_GET['aba'] ?? '') === 'cadastro' ? 'cadastro' : 'entrar';
$erro = ''; $info = '';
if (isset($_GET['social']) && in_array($_GET['social'], ['Google', 'Facebook', 'Apple'], true))
    $info = 'O login com ' . $_GET['social'] . ' ainda não está disponível. Use e-mail ou CPF.';
if (isset($_GET['esqueceu'])) $info = 'A recuperação de senha ainda não está disponível. Fale com o administrador do evento.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = $_POST['senha'] ?? '';
    if (($_POST['acao'] ?? '') === 'cadastro') {
        $aba = 'cadastro';
        $nome = trim($_POST['nome'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
        if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $erro = 'Informe seu nome e um e-mail válido.';
        elseif ($cpf !== '' && strlen($cpf) !== 11) $erro = 'O CPF precisa ter 11 números.';
        elseif (strlen($senha) < 6) $erro = 'A senha precisa ter pelo menos 6 caracteres.';
        elseif ($senha !== ($_POST['confirma'] ?? '')) $erro = 'As senhas não são iguais.';
        elseif (readAll($pdo, 'usuarios', ['email' => $email])) $erro = 'Este e-mail já tem cadastro. Use a aba Entrar.';
        elseif ($cpf !== '' && readAll($pdo, 'usuarios', ['cpf' => $cpf])) $erro = 'Este CPF já tem cadastro. Use a aba Entrar.';
        else {
            $id = create($pdo, 'usuarios', ['nome' => $nome, 'email' => $email, 'cpf' => $cpf ?: null, 'senha' => password_hash($senha, PASSWORD_DEFAULT)]);
            $_SESSION['usuario'] = ['id' => $id, 'nome' => $nome, 'email' => $email];
            redireciona('index.php');
        }
    } else {
        $login = trim($_POST['login'] ?? '');
        $campo = str_contains($login, '@') ? 'email' : 'cpf';
        $valor = $campo === 'email' ? strtolower($login) : preg_replace('/\D/', '', $login);
        $r = $valor === '' ? [] : readAll($pdo, 'usuarios', [$campo => $valor]);
        if ($r && password_verify($senha, $r[0]['senha'])) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = ['id' => $r[0]['id'], 'nome' => $r[0]['nome'], 'email' => $r[0]['email']];
            if (!empty($_POST['lembrar'])) {
                setcookie(session_name(), session_id(), ['expires' => time() + 2592000, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
            }
            redireciona('index.php');
        }
        $erro = 'E-mail, CPF ou senha incorretos.';
    }
}
$titulo = 'Entrar';
include 'includes/topo.php';
?>
<section class="login-fundo">
  <div class="login-caixa">
    <div class="abas">
      <a class="<?= $aba === 'entrar' ? 'ativa' : '' ?>" href="login.php"><?= ic('entrar', 34) ?> Entrar</a>
      <a class="<?= $aba === 'cadastro' ? 'ativa' : '' ?>" href="login.php?aba=cadastro"><?= ic('novo_usuario', 34) ?> Criar Conta</a>
    </div>
    <?php if ($erro): ?><p class="erro" role="alert"><?= e($erro) ?></p><?php endif; ?>
    <?php if ($info): ?><p class="info" role="status"><?= e($info) ?></p><?php endif; ?>

    <?php if ($aba === 'entrar'): ?>
      <h1>Bem-vindo de volta!</h1>
      <div class="sociais">
        <a href="login.php?social=Google"><b class="g">G</b> Google</a>
        <a href="login.php?social=Facebook"><b class="f">f</b> Facebook</a>
        <a href="login.php?social=Apple"><b>A</b> Apple</a>
      </div>
      <p class="divisor"><span>ou com e-mail</span></p>
      <form method="post" class="form">
        <input type="hidden" name="acao" value="entrar">
        <label>E-mail ou CPF<input name="login" placeholder="seu@email.com ou 000.000.000-00" required value="<?= e($_POST['login'] ?? '') ?>" autocomplete="username"></label>
        <label><span class="linha-senha">Senha <a href="login.php?esqueceu=1">Esqueceu a senha?</a></span>
          <span class="campo-senha"><input type="password" name="senha" id="senha" required autocomplete="current-password">
          <button type="button" class="olho" id="olho" aria-label="Mostrar ou ocultar senha"><?= ic('olho', 22) ?></button></span></label>
        <label class="check"><input type="checkbox" name="lembrar" value="1"> Lembrar deste dispositivo</label>
        <button class="btn btn-ouro btn-largo">Entrar na EventNow</button>
      </form>
      <script>document.getElementById('olho').onclick=function(){var s=document.getElementById('senha');s.type=s.type==='password'?'text':'password';};</script>
    <?php else: ?>
      <h1>Crie sua conta</h1>
      <form method="post" class="form">
        <input type="hidden" name="acao" value="cadastro">
        <label>Nome<input name="nome" required value="<?= e($_POST['nome'] ?? '') ?>"></label>
        <label>E-mail<input type="email" name="email" placeholder="seu@email.com" required value="<?= e($_POST['email'] ?? '') ?>"></label>
        <label>CPF (opcional)<input name="cpf" placeholder="000.000.000-00" value="<?= e($_POST['cpf'] ?? '') ?>"></label>
        <label>Senha<input type="password" name="senha" minlength="6" required></label>
        <label>Confirmar senha<input type="password" name="confirma" minlength="6" required></label>
        <button class="btn btn-ouro btn-largo">Criar conta</button>
      </form>
    <?php endif; ?>
  </div>
</section>
<?php include 'includes/rodape.php'; ?>
