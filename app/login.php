<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventNow | Entrar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #08080a; color: #fff; min-height: 100vh; display: grid; place-items: center; position: relative; }
        body::before { content: ''; position: absolute; width: 300px; height: 300px; background: rgba(197, 168, 105, 0.15); filter: blur(120px); border-radius: 50%; top: 20%; left: 30%; }

        .auth-card { background: #12121a; border: 1px solid #262636; border-radius: 24px; padding: 40px; width: 100%; max-width: 420px; z-index: 10; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .auth-header { text-align: center; margin-bottom: 32px; }
        .auth-header h1 { font-size: 24px; font-weight: 700; margin-bottom: 8px; }
        .auth-header p { font-size: 14px; color: #9ca3af; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 14px 16px; background: #08080a; border: 1px solid #262636; border-radius: 12px; color: #fff; font-size: 14px; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #c5a869; }

        .btn-submit { width: 100%; padding: 14px; background: #c5a869; color: #000; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; transition: 0.2s; margin-top: 10px; }
        .btn-submit:hover { background: #d8ba7b; }
        .back-link { display: block; text-align: center; margin-top: 24px; font-size: 14px; color: #9ca3af; text-decoration: none; }
        .back-link:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <h1>Acessar Conta</h1>
            <p>Entre para gerenciar seus ingressos e eventos</p>
        </div>
        <form action="dashboard.php" method="GET">
            <div class="form-group">
                <label>E-mail ou CPF</label>
                <input type="text" class="form-control" placeholder="seuemail@dominio.com" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-submit">Entrar na Plataforma</button>
        </form>
        <a href="index.php" class="back-link">← Voltar para a página inicial</a>
    </div>
</body>
</html>