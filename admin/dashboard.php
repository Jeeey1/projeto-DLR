<?php 
session_start();

// Ajuste os caminhos dos includes caso sua estrutura de pastas exija
include "../includes/conexao.php";
include "../includes/funcoes.php";

if($_SESSION['logado'] != true){
  header("Location: index.php");
  exit();
}

// Conexão com o banco para puxar as estatísticas do Dashboard
$pdo = (new Conexao())->conectar();

// 1. Total de Posts
$stmtTotal = $pdo->query("SELECT COUNT(*) as total FROM posts");
$totalPosts = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

// 2. Últimos 5 Posts para a Tabela
$stmtUltimos = $pdo->query("SELECT id, titulo, data_criacao FROM posts ORDER BY id DESC LIMIT 5");
$ultimosPosts = $stmtUltimos->fetchAll(PDO::FETCH_ASSOC);

// 3. Posts por Categoria para a Lista
$qryCategorias = "SELECT c.nome, COUNT(p.id) as qtd_posts 
                  FROM categorias c 
                  LEFT JOIN posts p ON c.id = p.categoria 
                  GROUP BY c.id 
                  ORDER BY qtd_posts DESC 
                  LIMIT 5";
$stmtCat = $pdo->query($qryCategorias);
$postsPorCategoria = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// 4. Últimos 4 posts para a Vitrine (Grid)
$qryVitrine = "SELECT p.id, p.titulo, p.imagem, c.nome as nome_categoria 
               FROM posts p 
               LEFT JOIN categorias c ON p.categoria = c.id 
               ORDER BY p.id DESC 
               LIMIT 4";
$stmtVitrine = $pdo->query($qryVitrine);
$postsVitrine = $stmtVitrine->fetchAll(PDO::FETCH_ASSOC);

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
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600&display=swap"
    rel="stylesheet" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/common.css" />
  <link rel="stylesheet" href="../public/css/admin_style.css" />
  <link rel="stylesheet" href="../public/css/index_style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <style>
  body {
    background-color: #f8f9fa;
  }

  .card {
    border-radius: 12px;
  }
  </style>
</head>

<body class="blog-page">

  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="./blog/posts.php"><span data-lang="pt">Posts</span></a></li>
      <li><a href="logout.php"><span data-lang="pt">Logout</span></a></li>
      <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <span></span><span></span><span></span>
      </div>
    </ul>
  </nav>

  <section class="container mt-4 mb-5 admin-section">

    <?php 
    $nomeUsuario = !empty($_SESSION['usuario_nome']) ? ucfirst($_SESSION['usuario_nome']) : '';
    echo "<h2 class='mb-4' style='font-family: \"Cormorant Garamond\", serif;'>Seja bem-vindo(a), " . htmlspecialchars($nomeUsuario) . "! 👋</h2>";
    ?>

    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm" style="background-color: #c9a84c;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h6 class="card-title text-uppercase mb-0 text-black-50"><strong>Posts Publicados</strong></h6>
              <h2 class="display-5 mb-0"><?php echo $totalPosts; ?></h2>
            </div>
            <i class="fa-solid fa-file-lines fa-3x opacity-50"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
            <h5 class="card-title">Tem um novo assunto?</h5>
            <a href="./blog/criar-post.php" class="btn btn-primary mt-2">
              <i class="fa-solid fa-plus me-2"></i> Criar Novo Post
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-7 mb-4">
        <div class="card shadow-sm h-100 border-0">
          <div class="card-header bg-white d-flex justify-content-between align-items-center"
            style="border-bottom: 2px solid #f1f5f9;">
            <h5 class="mb-0" style="font-weight: 600;">Últimos Posts</h5>
            <a href="./blog/posts.php" class="btn btn-sm btn-outline-secondary">Ver todos</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle">
                <tbody>
                  <?php if(count($ultimosPosts) > 0): ?>
                  <?php foreach($ultimosPosts as $p): ?>
                  <tr>
                    <td class="ps-4 py-3" style="font-weight: 500;"><?php echo htmlspecialchars($p['titulo']); ?></td>
                    <td class="text-muted text-end">
                      <?php echo (new DateTime($p['data_criacao']))->format('d/m/Y'); ?>
                    </td>
                    <td class="text-end pe-3">
                      <a href="./blog/editar-post.php?id=<?php echo $p['id']; ?>" class="text-primary" title="Editar">
                        <i class="fa-solid fa-pencil" style="color: black;"></i>
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="3" class="text-center p-4 text-muted">Nenhum post publicado ainda.</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5 mb-4">
        <div class="card shadow-sm h-100 border-0">
          <div class="card-header bg-white" style="border-bottom: 2px solid #f1f5f9;">
            <h5 class="mb-0" style="font-weight: 600;">Assuntos Mais Abordados</h5>
          </div>
          <ul class="list-group list-group-flush">
            <?php if(count($postsPorCategoria) > 0): ?>
            <?php foreach($postsPorCategoria as $cat): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
              <?php echo ucfirst(htmlspecialchars($cat['nome'])); ?>
              <span class="badge text-bg-secondary rounded-pill">
                <?php echo $cat['qtd_posts']; ?> posts
              </span>
            </li>
            <?php endforeach; ?>
            <?php else: ?>
            <li class="list-group-item text-muted text-center py-4">Sem dados no momento.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="row mt-4 mb-5 pb-5">
      <div class="col-12 mb-4">
        <h4 class="text-secondary" style="font-family: 'DM Sans', sans-serif; font-weight: 600;">
          Vitrine Visual
        </h4>
        <hr class="text-muted opacity-25">
      </div>

      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php 
        for ($i = 0; $i < 4; $i++) {
            if (isset($postsVitrine[$i])) {
                $p = $postsVitrine[$i];
                $caminhoImagem = !empty($p['imagem']) ? '../' . $p['imagem'] : ''; 
                $imgStyle = !empty($caminhoImagem) ? "background-image: url('{$caminhoImagem}');" : "background-color: #e2e8f0;";
                $nomeCategoria = !empty($p['nome_categoria']) ? ucfirst($p['nome_categoria']) : 'Sem categoria';
                
                echo '
                <div class="col">
                  <div class="card h-100 shadow-sm border-0 overflow-hidden" style="border-radius: 12px; transition: transform 0.2s;">
                    <div class="position-relative w-100" style="height: 180px; background-size: cover; background-position: center; ' . $imgStyle . '">
                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 shadow" style="font-weight: 500; letter-spacing: 1px;">
                            ' . htmlspecialchars($nomeCategoria) . '
                        </span>
                    </div>
                    <div class="card-body bg-white d-flex flex-column">
                        <h6 class="card-title mb-3" style="font-family: \'Cormorant Garamond\', serif; font-size: 1.25rem; font-weight: 700; color: #1e293b; line-height: 1.3;">
                            ' . htmlspecialchars($p['titulo']) . '
                        </h6>
                        <div class="mt-auto">
                            <a href="./blog/editar-post.php?id=' . $p['id'] . '" class="btn btn-sm btn-outline-secondary w-100" style="border-radius: 6px;">
                                Editar post
                            </a>
                        </div>
                    </div>
                  </div>
                </div>';
            } else {
                echo '
                <div class="col">
                  <div class="card h-100 bg-light border-0" style="border: 2px dashed #cbd5e1 !important; border-radius: 12px;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted" style="min-height: 280px; opacity: 0.6;">
                        <i class="fa-regular fa-image fa-3x mb-3"></i>
                        <p class="mb-0" style="font-size: 0.9rem; font-weight: 500;">Espaço disponível</p>
                        <small style="font-size: 0.75rem;">Aguardando nova publicação</small>
                    </div>
                  </div>
                </div>';
            }
        }
        ?>
      </div>
    </div>
  </section>

  <div style="width: 100%; max-width: 900px; margin: 0 auto;">
    <a id="zl-url" class="zl-url" href="https://www.doctoralia.com.br/daniel-lataro-de-robbio/psicologo/ribeirao-preto"
      rel="nofollow" data-zlw-doctor="daniel-lataro-de-robbio" data-zlw-type="big_with_calendar"
      data-zlw-opinion="false" data-zlw-hide-branding="true" data-zlw-saas-only="true"
      data-zlw-a11y-title="Widget de marcação de consultas médicas">Marque uma consulta</a>
  </div>

  <script>
  ! function($_x, _s, id) {
    var js, fjs = $_x.getElementsByTagName(_s)[0];
    if (!$_x.getElementById(id)) {
      js = $_x.createElement(_s);
      js.id = id;
      js.src = "//platform.docplanner.com/js/widget.js";
      fjs.parentNode.insertBefore(js, fjs);
    }
  }(document, "script", "zl-widget-s");
  </script>


  <script>
  ! function($_x, _s, id) {
    var js, fjs = $_x.getElementsByTagName(_s)[0];
    if (!$_x.getElementById(id)) {
      js = $_x.createElement(_s);
      js.id = id;
      js.src = "//platform.docplanner.com/js/widget.js";
      fjs.parentNode.insertBefore(js, fjs);
    }
  }(document, "script", "zl-widget-s");
  </script>
  <script>
  ! function($_x, _s, id) {
    var js, fjs = $_x.getElementsByTagName(_s)[0];
    if (!$_x.getElementById(id)) {
      js = $_x.createElement(_s);
      js.id = id;
      js.src = "//platform.docplanner.com/js/widget.js";
      fjs.parentNode.insertBefore(js, fjs);
    }
  }(document, "script", "zl-widget-s");
  </script>

  <footer class="footer-admin">
    <div>
      <div class="footer-brand">Dr. <span>Daniel</span></div>
      <div class="lgpd-note">
        <span data-lang="pt">© 2026 · Todos os direitos reservados · LGPD</span>
        <span data-lang="en">© 2026 · All rights reserved · LGPD</span>
      </div>
    </div>
    <div class="footer-copy">CRP 06/130646</div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>