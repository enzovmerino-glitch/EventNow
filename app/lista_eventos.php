<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventNow | Meus Eventos</title>
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

        .table-card { background: #12121a; border: 1px solid #1a1a24; border-radius: 20px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 20px 24px; font-size: 12px; font-weight: 700; color: #9ca3af; border-bottom: 1px solid #1a1a24; text-transform: uppercase; }
        td { padding: 20px 24px; font-size: 14px; border-bottom: 1px solid #1a1a24; }
        tr:last-child td { border: none; }

        .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; margin-right: 8px; display: inline-block; }
        .btn-edit { background: rgba(197, 168, 105, 0.1); color: #c5a869; border: 1px solid #c5a869; }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">EVENTNOW</div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item">📊 Visão Geral</a>
            <a href="lista_eventos.php" class="nav-item active">🎟 Gerenciar Eventos</a>
            <a href="index.php" class="nav-item" style="margin-top: auto; color: #ef4444;">🚪 Sair</a>
        </nav>
    </aside>

    <main class="main-wrapper">
        <div class="page-header">
            <h1 style="font-size: 28px; font-weight: 800;">Lista de Eventos</h1>
            <a href="criar_evento.php" class="btn-create">+ Criar Evento</a>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Data</th>
                        <th>Local</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Workshop de Fotografia Digital</strong></td>
                        <td>15/10/2026 às 19:30</td>
                        <td>Auditório SP</td>
                        <td>
                            <a href="criar_evento.php" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-delete" onclick="confirm('Excluir evento?')">Excluir</a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Festival de Música Indie</strong></td>
                        <td>29/10/2026 às 21:00</td>
                        <td>Rio de Janeiro</td>
                        <td>
                            <a href="criar_evento.php" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-delete" onclick="confirm('Excluir evento?')">Excluir</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>