<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventNow | Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #08080a; color: #fff; display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        .sidebar { width: 260px; background: #0e0e14; border-right: 1px solid #1a1a24; padding: 32px 24px; display: flex; flex-direction: column; }
        .sidebar-brand { font-size: 16px; font-weight: 800; color: #c5a869; letter-spacing: 2px; margin-bottom: 40px; }
        
        .nav-menu { display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .nav-item { padding: 12px 16px; border-radius: 12px; font-size: 14px; font-weight: 600; color: #9ca3af; transition: 0.2s; }
        .nav-item:hover, .nav-item.active { background: #1a1a24; color: #fff; }

        .main-wrapper { flex: 1; padding: 40px 48px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .btn-create { background: #c5a869; color: #000; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .stat-card { background: #12121a; border: 1px solid #1a1a24; padding: 24px; border-radius: 20px; }
        .stat-label { font-size: 13px; font-weight: 600; color: #9ca3af; margin-bottom: 12px; }
        .stat-value { font-size: 32px; font-weight: 800; color: #fff; }
        .stat-trend { font-size: 12px; color: #10b981; margin-top: 8px; font-weight: 600; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">EVENTNOW</div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item active">📊 Visão Geral</a>
            <a href="lista_eventos.php" class="nav-item">🎟 Gerenciar Eventos</a>
            <a href="index.php" class="nav-item" style="margin-top: auto; color: #ef4444;">🚪 Sair</a>
        </nav>
    </aside>

    <main class="main-wrapper">
        <div class="page-header">
            <h1 style="font-size: 28px; font-weight: 800;">Painel de Controle</h1>
            <a href="criar_evento.php" class="btn-create">+ Criar Evento</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Ingressos Vendidos</div>
                <div class="stat-value">482</div>
                <div class="stat-trend">↑ 12% essa semana</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Vagas Restantes</div>
                <div class="stat-value">318</div>
                <div class="stat-trend" style="color: #9ca3af;">De 800 disponíveis</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Receita Acumulada</div>
                <div class="stat-value">R$ 12.200</div>
                <div class="stat-trend">↑ 18% este mês</div>
            </div>
        </div>
    </main>

</body>
</html>