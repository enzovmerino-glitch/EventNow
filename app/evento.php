<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventNow | Detalhes do Evento</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #08080a; color: #fff; }
        a { text-decoration: none; color: inherit; }

        .top-nav { padding: 24px 48px; display: flex; justify-content: space-between; align-items: center; position: absolute; top: 0; width: 100%; z-index: 10; }
        .cover-banner { height: 400px; background: linear-gradient(to bottom, rgba(8,8,10,0.3), #08080a), url('https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=1920') center/cover; }

        .main-container { max-width: 1100px; margin: -100px auto 80px; padding: 0 24px; position: relative; z-index: 20; }
        .page-layout { display: grid; grid-template-columns: 1fr 360px; gap: 40px; }

        .event-header h1 { font-size: 40px; font-weight: 800; margin-bottom: 16px; line-height: 1.2; }
        .event-description { color: #9ca3af; font-size: 16px; line-height: 1.6; margin-bottom: 32px; }

        .info-card { background: #12121a; border: 1px solid #262636; border-radius: 20px; padding: 32px; }
        .info-item { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; font-size: 15px; color: #d1d5db; }
        .info-item:last-child { margin-bottom: 0; }

        .ticket-card { background: #12121a; border: 1px solid #262636; border-radius: 20px; padding: 32px; text-align: center; height: fit-content; sticky: top; top: 40px; }
        .gauge { width: 140px; height: 140px; border-radius: 50%; background: conic-gradient(#c5a869 65%, #262636 0); display: grid; place-items: center; margin: 0 auto 24px; }
        .gauge-inner { width: 116px; height: 116px; border-radius: 50%; background: #12121a; display: grid; place-items: center; font-size: 24px; font-weight: 800; color: #c5a869; }

        .btn-action { width: 100%; padding: 14px; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; border: none; transition: 0.2s; margin-bottom: 12px; }
        .btn-primary { background: #c5a869; color: #000; }
        .btn-primary:hover { background: #d8ba7b; }
        .btn-secondary { background: transparent; border: 1px solid #262636; color: #9ca3af; }
        .btn-secondary:hover { border-color: #ef4444; color: #ef4444; }
    </style>
</head>
<body>

    <nav class="top-nav">
        <a href="index.php" style="font-weight: 800; color: #c5a869; letter-spacing: 2px;">EVENTNOW</a>
        <a href="index.php" style="color: #9ca3af; font-size: 14px; font-weight: 600;">← Voltar para explorar</a>
    </nav>

    <div class="cover-banner"></div>

    <div class="main-container">
        <div class="page-layout">
            <div>
                <div class="event-header">
                    <h1>Workshop de Fotografia Digital</h1>
                    <p class="event-description">
                        Aprenda a dominar sua câmera do zero. Este workshop abordará fundamentos de exposição, composição artística e técnicas avançadas de edição para elevar o nível das suas capturas.
                    </p>
                </div>

                <div class="info-card">
                    <h3 style="font-size: 18px; margin-bottom: 24px;">Informações do Evento</h3>
                    <div class="info-item">📅 <strong>Data:</strong> Quarta-feira, 15 de Outubro de 2026</div>
                    <div class="info-item">⏰ <strong>Horário:</strong> 19:30 às 21:30</div>
                    <div class="info-item">📍 <strong>Endereço:</strong> Auditório SP - Av. Paulista, 1000</div>
                </div>
            </div>

            <aside class="ticket-card">
                <h3 style="font-size: 16px; margin-bottom: 20px; color: #9ca3af;">Ocupação do Evento</h3>
                <div class="gauge">
                    <div class="gauge-inner">65%</div>
                </div>
                <p style="font-size: 14px; color: #9ca3af; margin-bottom: 24px;">35 de 100 vagas disponíveis</p>
                
                <button class="btn-action btn-primary" onclick="alert('Inscrição confirmada com sucesso!')">Garantir Inscrição</button>
                <button class="btn-action btn-secondary" onclick="alert('Inscrição cancelada.')">Cancelar Inscrição</button>
            </aside>
        </div>
    </div>

</body>
</html>