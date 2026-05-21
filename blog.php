<?php 
// 1. Conexão com o banco de dados
include_once "./includes/conexao.php";
$pdo = (new Conexao())->conectar();

// 2. Busca TODOS os posts
$qry = "SELECT p.id, p.titulo, p.descricao, p.imagem, p.data_criacao, c.nome as nome_categoria 
        FROM posts p 
        LEFT JOIN categorias c ON p.categoria = c.id 
        ORDER BY p.id DESC";
$stmt = $pdo->query($qry);
$todosPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Extrai apenas as categorias que possuem posts (para criar os filtros dinâmicos)
$categoriasAtivas = [];
foreach ($todosPosts as $post) {
    $nomeCat = !empty($post['nome_categoria']) ? ucfirst($post['nome_categoria']) : 'Sem categoria';
    // Cria um 'slug' simples para o filtro (ex: "Saúde Mental" vira "saude-mental")
    $slugCat = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $nomeCat)));
    
    if (!isset($categoriasAtivas[$slugCat])) {
        $categoriasAtivas[$slugCat] = $nomeCat;
    }
}

// 4. Separa o post mais recente para ser o "Destaque" e o resto para o "Grid"
$postDestaque = null;
if (count($todosPosts) > 0) {
    // Tira o primeiro post do array e joga na variável destaque
    $postDestaque = array_shift($todosPosts); 
}

// Helper para formatar a data em português (ex: 06 Mai 2026)
$meses = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
function formataDataPT($dataStr, $mesesArray) {
    $data = new DateTime($dataStr);
    return $data->format('d') . ' ' . $mesesArray[(int)$data->format('m')] . ' ' . $data->format('Y');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog — Dr. Daniel | Artigos sobre Psicologia e Neuropsicologia</title>
  <meta name="description"
    content="Reflexões e estudos sobre saúde mental, neuropsicologia e bem-estar emocional escritos por Dr. Daniel." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="/projeto-DLR/public/css/common.css">
  <link rel="stylesheet" href="/projeto-DLR/public/css/index_style.css">
  <link rel="stylesheet" href="/projeto-DLR/public/css/blog_style.css">

  <style>
  /* Estilo extra para o link não quebrar o layout do texto */
  .link-post {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .link-post:hover .bp-featured-title,
  .link-post:hover .bp-card-title {
    color: rgba(201, 168, 76, 1);
    transition: color 0.3s;
  }
  </style>
</head>

<body>

  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php#home"><span data-lang="pt">Início</span><span data-lang="en">Home</span></a></li>
      <li><a href="index.php#sobre"><span data-lang="pt">Sobre</span><span data-lang="en">About</span></a></li>
      <li><a href="index.php#servicos"><span data-lang="pt">Serviços</span><span data-lang="en">Services</span></a></li>
      <li><a href="index.php#contato"><span data-lang="pt">Contato</span><span data-lang="en">Contact</span></a></li>
      <li><a class="nav-cta" href="https://www.doctoralia.com.br" target="_blank"><span data-lang="pt">Agendar
            Consulta</span><span data-lang="en">Book Now</span></a></li>
    </ul>
    <button class="lang-btn" id="langToggle">EN</button>
    <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
      <span></span><span></span><span></span>
    </div>
  </nav>

  <header class="bp-header">
    <span class="bp-eyebrow">Blog</span>
    <h1 class="bp-title">Artigos & <em>Publicações</em></h1>
    <p class="bp-subtitle">Reflexões cuidadosas sobre saúde mental, neuropsicologia e os caminhos do bem-estar
      emocional.</p>
  </header>

  <div class="bp-filters">
    <button class="bp-chip bp-chip-active" data-filter="todos">Todos</button>
    <?php foreach ($categoriasAtivas as $slug => $nome): ?>
    <button class="bp-chip" data-filter="<?= $slug ?>"><?= htmlspecialchars($nome) ?></button>
    <?php endforeach; ?>
  </div>

  <?php if ($postDestaque): 
    $catNomeDest = !empty($postDestaque['nome_categoria']) ? ucfirst($postDestaque['nome_categoria']) : 'Sem categoria';
    $slugDest = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $catNomeDest)));
    $imgDest = !empty($postDestaque['imagem']) ? $postDestaque['imagem'] : '';
    $styleDest = $imgDest ? "background-image: url('".$imgDest."'); background-size: cover; background-position: center;" : "";
?>
  <article class="bp-featured item-filtrable" data-category="<?= $slugDest ?>">
    <div class="bp-featured-thumb" style="<?= $styleDest ?>">
      <?php if(!$imgDest) echo '<div class="bp-thumb-inner">✦</div>'; ?>
    </div>
    <div>
      <div class="bp-tag"><?= htmlspecialchars($catNomeDest) ?></div>

      <a href="template_post.php?id=<?= $postDestaque['id'] ?>" class="link-post">
        <h2 class="bp-featured-title"><?= htmlspecialchars($postDestaque['titulo']) ?></h2>
        <p class="bp-featured-excerpt">
          <?= !empty($postDestaque['descricao']) ? htmlspecialchars($postDestaque['descricao']) : 'Clique para ler o artigo completo.' ?>
        </p>
      </a>

      <div class="bp-meta">
        <span><?= formataDataPT($postDestaque['data_criacao'], $meses) ?></span>
      </div>
      <a href="template_post.php?id=<?= $postDestaque['id'] ?>" class="bp-read-more" style="text-decoration:none;">Ler
        artigo →</a>
    </div>
  </article>
  <?php endif; ?>

  <section class="bp-grid">
    <?php foreach ($todosPosts as $p): 
      $catNome = !empty($p['nome_categoria']) ? ucfirst($p['nome_categoria']) : 'Sem categoria';
      $slug = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $catNome)));
      $img = !empty($p['imagem']) ? $p['imagem'] : '';
      $styleImg = $img ? "background-image: url('".$img."'); background-size: cover; background-position: center;" : "";
  ?>
    <article class="bp-card item-filtrable" data-category="<?= $slug ?>">
      <div class="bp-thumb" style="<?= $styleImg ?>">
        <?php if(!$img) echo '<div class="bp-thumb-inner">✦</div>'; ?>
      </div>
      <div class="bp-tag"><?= htmlspecialchars($catNome) ?></div>

      <a href="template_post.php?id=<?= $p['id'] ?>" class="link-post">
        <h3 class="bp-card-title"><?= htmlspecialchars($p['titulo']) ?></h3>
        <p class="bp-card-excerpt">
          <?= !empty($p['descricao']) ? htmlspecialchars($p['descricao']) : 'Ler artigo completo...' ?></p>
      </a>

      <div class="bp-meta"><span><?= formataDataPT($p['data_criacao'], $meses) ?></span></div>
    </article>
    <?php endforeach; ?>

    <?php if(empty($postDestaque) && empty($todosPosts)): ?>
    <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #6b5444;">
      <p>Ainda não há artigos publicados.</p>
    </div>
    <?php endif; ?>
  </section>

  <section class="bp-newsletter">
    <div class="bp-news-inner">
      <span class="bp-eyebrow bp-eyebrow-light">Newsletter</span>
      <h2 class="bp-news-title">Receba reflexões <em>mensais</em></h2>
      <p class="bp-news-sub">Conteúdo cuidadoso, sem spam. Cancele quando quiser.</p>
      <form class="bp-news-form"
        onsubmit="event.preventDefault(); this.querySelector('input').value=''; this.querySelector('button').textContent='Inscrito ✓';">
        <input type="email" placeholder="seu@email.com" required />
        <button type="submit">Inscrever</button>
      </form>
    </div>
  </section>

  <footer class="bp-footer">
    <div>
      <div class="bp-footer-brand">Dr. <span>Daniel</span></div>
      <div class="bp-lgpd">© 2026 — Todos os direitos reservados • LGPD</div>
    </div>
    <div class="bp-footer-links">
      <a href="#">Política de Privacidade</a>
      <a href="#">Termos</a>
      <a href="#">Contato</a>
    </div>
    <div class="bp-crp">CRP 06/130646</div>
  </footer>

  <a href="https://wa.me/5516999999999" class="bp-whatsapp" aria-label="WhatsApp" target="_blank" rel="noopener">
    <svg viewBox="0 0 24 24">
      <path
        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12.005 2C6.486 2 2 6.486 2 12.005c0 1.768.462 3.508 1.34 5.038L2 22l5.142-1.318a9.949 9.949 0 0 0 4.863 1.244h.004C17.524 21.926 22 17.44 22 11.92c0-2.659-1.034-5.16-2.91-7.043A9.901 9.901 0 0 0 12.005 2z" />
    </svg>
  </a>

  <script>
  // Script Melhorado: Filtra Destaque e Grid!
  document.querySelectorAll('.bp-chip').forEach(chip => {
    chip.addEventListener('click', () => {
      // Remove classe ativa de todos e adiciona no clicado
      document.querySelectorAll('.bp-chip').forEach(c => c.classList.remove('bp-chip-active'));
      chip.classList.add('bp-chip-active');

      const filtro = chip.dataset.filter;

      // Busca TODOS os elementos com a classe .item-filtrable (Destaque e Cards do Grid)
      document.querySelectorAll('.item-filtrable').forEach(item => {
        const categoria = item.dataset.category;

        if (filtro === 'todos' || categoria === filtro) {
          item.style.display = ''; // Mostra
        } else {
          item.style.display = 'none'; // Esconde
        }
      });
    });
  });
  </script>

</body>

</html>