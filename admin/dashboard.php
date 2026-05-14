<?php 
session_start();

if($_SESSION['logado'] != true){
  header("Location: login.php");
  exit();
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Blog Dr. Daniel</title>
  <meta name="description" content="Painel administrativo para gerenciar artigos do blog." />
  <meta name="robots" content="noindex, nofollow" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="../public/css/style.css" />
  <link rel="stylesheet" href="../public/css/style.css" />
</head>

<body class="blog-page">

  <!-- NAV -->
  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="#home"><span data-lang="pt">Blog</span></a></li>
      <li><a href="#home"><span data-lang="pt">Logout</span></a></li>
      <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <span></span><span></span><span></span>
      </div>
  </nav>


  <section style="margin-top: 200px; max-width: 1650px; margin-left: auto; margin-right: auto;">
    <?php if($_SESSION['usuario_nome']){
      echo "<h1>Seja bem-vindo(a) ao sistema " . ucfirst($_SESSION['usuario_nome']) . "!";
    } else {
      echo "<h1>Seja bem-vindo(a) ao sistema!";
    }
    ?>

    <div style="background-color: red; margin-top: 100px">
      <h2>Ola</h2>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div>
      <div class="footer-brand">Dr. <span>Daniel</span></div>
      <div class="lgpd-note"><span data-lang="pt">© 2026 · Todos os direitos reservados · LGPD</span><span
          data-lang="en">© 2026 · All rights reserved · LGPD</span></div>
    </div>
    <div class="footer-copy">CRP 06/130646</div>
  </footer>

  <script>
  const STORAGE_KEY = 'blog_posts_v1';
  const DEFAULTS = [{
      id: '1',
      tag: 'Neuropsicologia',
      glyph: 'Ψ',
      title: 'O que é avaliação neuropsicológica e quando realizá-la?',
      excerpt: 'Entenda como a avaliação neuropsicológica pode auxiliar no diagnóstico de transtornos cognitivos, déficits de atenção e demências.',
      date: '12 Mar 2026',
      read: '5 min de leitura',
      featured: true
    },
    {
      id: '2',
      tag: 'Saúde Mental',
      glyph: '◎',
      title: 'Ansiedade e estresse: como diferenciar e tratar',
      excerpt: 'Embora frequentemente confundidos, ansiedade e estresse possuem origens e abordagens terapêuticas distintas.',
      date: '28 Fev 2026',
      read: '7 min de leitura'
    },
    {
      id: '3',
      tag: 'Psicoterapia',
      glyph: '◈',
      title: 'Benefícios da psicoterapia baseada em evidências',
      excerpt: 'Conheça as principais abordagens com comprovação científica e como elas podem transformar sua vida emocional.',
      date: '15 Fev 2026',
      read: '6 min de leitura'
    },
    {
      id: '4',
      tag: 'Neuropsicologia',
      glyph: '❖',
      title: 'TDAH em adultos: sinais que costumam passar despercebidos',
      excerpt: 'Procrastinação crônica, hiperfoco e desorganização podem indicar um diagnóstico tardio de TDAH.',
      date: '02 Fev 2026',
      read: '8 min de leitura'
    },
    {
      id: '5',
      tag: 'Bem-estar',
      glyph: '✦',
      title: 'Higiene do sono e saúde cognitiva',
      excerpt: 'A qualidade do sono impacta diretamente memória, humor e desempenho cognitivo.',
      date: '20 Jan 2026',
      read: '5 min de leitura'
    }
  ];

  const read = () => {
    try {
      const r = localStorage.getItem(STORAGE_KEY);
      const p = r ? JSON.parse(r) : null;
      return Array.isArray(p) && p.length ? p : DEFAULTS;
    } catch {
      return DEFAULTS;
    }
  };
  const write = (posts) => localStorage.setItem(STORAGE_KEY, JSON.stringify(posts));

  const esc = (s) => String(s).replace(/[&<>"']/g, c => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;'
  } [c]));

  function render() {
    const posts = read();
    document.getElementById('admin-count').textContent = `Artigos publicados (${posts.length})`;
    const list = document.getElementById('admin-items');
    list.innerHTML = posts.map(p => `
        <li class="admin-item">
          <div class="admin-item-glyph">${esc(p.glyph)}</div>
          <div class="admin-item-body">
            <div class="bp-tag">${esc(p.tag)}${p.featured ? ' · Destaque' : ''}</div>
            <h3>${esc(p.title)}</h3>
            <p>${esc(p.excerpt)}</p>
            <div class="bp-meta"><span>${esc(p.date)}</span> <span class="bp-dot">·</span> <span>${esc(p.read)}</span></div>
          </div>
          <button type="button" class="admin-delete" data-id="${p.id}" aria-label="Remover">×</button>
        </li>
      `).join('');
    list.querySelectorAll('.admin-delete').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const p = read().find(x => x.id === id);
        if (p && confirm(`Remover "${p.title}"?`)) {
          write(read().filter(x => x.id !== id));
          render();
        }
      });
    });
  }

  function todayBR() {
    const m = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    const d = new Date();
    return `${String(d.getDate()).padStart(2,'0')} ${m[d.getMonth()]} ${d.getFullYear()}`;
  }
  document.getElementById('f-date').value = todayBR();

  document.getElementById('admin-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const post = {
      id: (crypto.randomUUID && crypto.randomUUID()) || String(Date.now()),
      title: document.getElementById('f-title').value.trim(),
      excerpt: document.getElementById('f-excerpt').value.trim(),
      tag: document.getElementById('f-tag').value,
      glyph: document.getElementById('f-glyph').value,
      date: document.getElementById('f-date').value || todayBR(),
      read: document.getElementById('f-read').value || '5 min de leitura',
      featured: document.getElementById('f-featured').checked
    };
    if (!post.title || !post.excerpt) return;
    write([post, ...read()]);
    e.target.reset();
    document.getElementById('f-date').value = todayBR();
    document.getElementById('f-read').value = '5 min de leitura';
    const msg = document.getElementById('admin-msg');
    msg.textContent = 'Artigo publicado com sucesso!';
    msg.hidden = false;
    setTimeout(() => msg.hidden = true, 3000);
    render();
  });

  document.getElementById('admin-reset').addEventListener('click', () => {
    if (confirm('Restaurar artigos padrão? Suas adições serão perdidas.')) {
      write(DEFAULTS);
      render();
    }
  });

  render();
  </script>
</body>

</html>