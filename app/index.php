<?php require_once 'init.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventNow | Experiências Exclusivas</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #08080a; color: #f3f4f6; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }

        .header { display: flex; justify-content: space-between; align-items: center; padding: 20px 48px; background: rgba(8, 8, 10, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid #1a1a24; sticky: top; top: 0; z-index: 50; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-mark { width: 36px; height: 36px; background: #c5a869; color: #000; font-weight: 800; border-radius: 8px; display: grid; place-items: center; font-size: 18px; }
        .brand-name { font-size: 14px; font-weight: 800; letter-spacing: 2px; color: #fff; }
        
        .nav-items { display: flex; gap: 32px; }
        .nav-link { font-size: 14px; font-weight: 600; color: #9ca3af; transition: 0.2s; }
        .nav-link:hover, .nav-link.active { color: #c5a869; }

        .auth-actions { display: flex; align-items: center; gap: 20px; }
        .btn-login { font-size: 14px; font-weight: 600; color: #d1d5db; }
        .btn-cta { background: #c5a869; color: #000; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; transition: 0.2s; }
        .btn-cta:hover { background: #d8ba7b; }

        .hero-section { padding: 90px 24px 60px; text-align: center; max-width: 900px; margin: 0 auto; }
        .hero-title { font-size: 56px; font-weight: 800; letter-spacing: -1.5px; line-height: 1.1; margin-bottom: 20px; }
        .hero-subtitle { font-size: 18px; color: #9ca3af; margin-bottom: 40px; font-weight: 400; }

        .search-box { position: relative; max-width: 600px; margin: 0 auto; }
        .search-input { width: 100%; padding: 18px 24px; background: #12121a; border: 1px solid #262636; border-radius: 16px; color: #fff; font-size: 15px; outline: none; transition: 0.2s; }
        .search-input:focus { border-color: #c5a869; box-shadow: 0 0 0 4px rgba(197, 168, 105, 0.1); }

        .catalog-section { max-width: 1200px; margin: 0 auto; padding: 40px 24px 100px; }
        .catalog-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .filter-pills { display: flex; gap: 8px; }
        .pill { padding: 8px 16px; background: #12121a; border: 1px solid #262636; border-radius: 20px; font-size: 13px; font-weight: 600; color: #9ca3af; cursor: pointer; transition: 0.2s; }
        .pill.active, .pill:hover { background: #c5a869; color: #000; border-color: #c5a869; }

        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px; }
        .event-card { background: #12121a; border: 1px solid #1a1a24; border-radius: 20px; overflow: hidden; transition: 0.25s ease; display: flex; flex-direction: column; }
        .event-card:hover { transform: translateY(-4px); border-color: #33334d; }
        .card-cover { height: 200px; background-size: cover; background-position: center; }
        .card-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .card-tag { font-size: 12px; font-weight: 700; color: #c5a869; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
        .card-title { font-size: 20px; font-weight: 700; margin-bottom: 10px; line-height: 1.3; }
        .card-desc { font-size: 14px; color: #9ca3af; margin-bottom: 24px; line-height: 1.5; }
        .card-meta { margin-top: auto; padding-top: 16px; border-top: 1px solid #1a1a24; display: flex; justify-content: space-between; font-size: 13px; color: #6b7280; font-weight: 500; }
    </style>
</head>
<body>

    <header class="header">
        <a href="index.php" class="brand">
            <div class="brand-mark">E</div>
            <span class="brand-name">EVENTNOW</span>
        </a>
        <nav class="nav-items">
            <a href="index.php" class="nav-link active">Explorar</a>
            <a href="lista_eventos.php" class="nav-link">Gerenciar</a>
            <a href="dashboard.php" class="nav-link">Painel</a>
        </nav>
        <div class="auth-actions">
            <a href="login.php" class="btn-login">Entrar</a>
            <a href="criar_evento.php" class="btn-cta">+ Criar Evento</a>
        </div>
    </header>

    <section class="hero-section">
        <h1 class="hero-title">Viva momentos extraordinários.</h1>
        <p class="hero-subtitle">Descubra os melhores workshops, shows e palestras pertinho de você.</p>
        <div class="search-box">
            <input type="text" id="searchInput" class="search-input" placeholder="Pesquise por nome, tema ou cidade...">
        </div>
    </section>

    <main class="catalog-section">
        <div class="catalog-header">
            <h2 style="font-size: 22px; font-weight: 700;">Em destaque</h2>
            <div class="filter-pills">
                <button class="pill active" onclick="filterCategory('all', this)">Todos</button>
                <button class="pill" onclick="filterCategory('tech', this)">Tecnologia</button>
                <button class="pill" onclick="filterCategory('music', this)">Música</button>
            </div>
        </div>

        <div class="events-grid" id="eventsGrid">
            <a href="evento.php?id=1" class="event-card" data-cat="tech" data-name="workshop de fotografia digital">
                <div class="card-cover" style="background-image: url('https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=800');"></div>
                <div class="card-body">
                    <span class="card-tag">Workshop</span>
                    <h3 class="card-title">Workshop de Fotografia Digital</h3>
                    <p class="card-desc">Domine técnicas de enquadramento, iluminação e pós-produção na prática.</p>
                    <div class="card-meta">
                        <span>📅 15 Out 2026</span>
                        <span>📍 Auditório SP</span>
                    </div>
                </div>
            </a>

            <a href="evento.php?id=2" class="event-card" data-cat="music" data-name="festival de musica indie">
                <div class="card-cover" style="background-image: url('https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&w=800');"></div>
                <div class="card-body">
                    <span class="card-tag">Show ao vivo</span>
                    <h3 class="card-title">Festival de Música Indie</h3>
                    <p class="card-desc">Uma noite inesquecível com os maiores nomes da cena independente nacional.</p>
                    <div class="card-meta">
                        <span>📅 29 Out 2026</span>
                        <span>📍 Rio de Janeiro</span>
                    </div>
                </div>
            </a>
        </div>
    </main>

    <script>
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.event-card').forEach(card => {
                const name = card.getAttribute('data-name');
                card.style.display = name.includes(query) ? 'flex' : 'none';
            });
        });

        function filterCategory(cat, btn) {
            document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.event-card').forEach(card => {
                if (cat === 'all' || card.getAttribute('data-cat') === cat) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>