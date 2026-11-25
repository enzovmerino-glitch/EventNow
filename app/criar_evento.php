<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventNow | Novo Evento</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #08080a; color: #fff; min-height: 100vh; padding: 40px 24px; }
        
        .form-card { max-width: 600px; margin: 0 auto; background: #12121a; border: 1px solid #262636; border-radius: 24px; padding: 40px; }
        .form-title { font-size: 24px; font-weight: 800; margin-bottom: 24px; color: #c5a869; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 14px; background: #08080a; border: 1px solid #262636; border-radius: 12px; color: #fff; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #c5a869; }

        .btn-save { width: 100%; padding: 14px; background: #c5a869; color: #000; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 10px; }
        .btn-save:hover { background: #d8ba7b; }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 14px; color: #9ca3af; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-card">
        <h1 class="form-title">Cadastrar Novo Evento</h1>
        <form action="lista_eventos.php" method="GET" onsubmit="alert('Evento salvo!')">
            <div class="form-group">
                <label>Título do Evento</label>
                <input type="text" class="form-control" placeholder="Ex: Masterclass de IA" required>
            </div>
            <div class="form-group">
                <label>Data e Hora</label>
                <input type="datetime-local" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Localização</label>
                <input type="text" class="form-control" placeholder="Ex: Auditório Central, SP" required>
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <textarea class="form-control" rows="4" placeholder="Detalhes do evento..." required></textarea>
            </div>
            <button type="submit" class="btn-save">Publicar Evento</button>
        </form>
        <a href="lista_eventos.php" class="back-link">Cancelar e Voltar</a>
    </div>

</body>
</html>