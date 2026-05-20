<?php 
session_start();

include "../includes/conexao.php";
include "../includes/funcoes.php";

if($_SESSION['logado'] != true){
  header("Location: index.php");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
  <link rel="stylesheet" href="../public/css/common.css" />
  <link rel="stylesheet" href="../public/css/admin_style.css" />
  <link rel="stylesheet" href="../public/css/index_style.css" />
</head>

<body class="blog-page">

  <!-- HEADER/NAV -->
  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="./blog/posts.php"><span data-lang="pt">Post</span></a></li>
      <li><a href="logout.php"><span data-lang="pt">Logout</span></a></li>
      <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <span></span><span></span><span></span>
      </div>
  </nav>


  <section class="container mt-4 admin-section">
    <?php 
    // Mensagem de boas-vindas
    $nomeUsuario = $_SESSION['usuario_nome'] ? ucfirst($_SESSION['usuario_nome']) : '';
    echo "<h2 class='mb-4'>Seja bem-vindo(a), " . $nomeUsuario . "! 👋</h2>";

    // --- LÓGICA DO BANCO DE DADOS ---
    $pdo = (new Conexao())->conectar();

    // 1. Total de Posts
    $stmtTotal = $pdo->query("SELECT COUNT(*) as total FROM posts");
    $totalPosts = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    // 2. Últimos 5 Posts
    $stmtUltimos = $pdo->query("SELECT id, titulo, data_criacao FROM posts ORDER BY id DESC LIMIT 5");
    $ultimosPosts = $stmtUltimos->fetchAll(PDO::FETCH_ASSOC);

    // 3. Posts por Categoria (Para ele saber que tipo de assunto mais escreve)
    $qryCategorias = "SELECT c.nome, COUNT(p.id) as qtd_posts 
                      FROM categorias c 
                      LEFT JOIN posts p ON c.id = p.categoria 
                      GROUP BY c.id 
                      ORDER BY qtd_posts DESC 
                      LIMIT 5";
    $stmtCat = $pdo->query($qryCategorias);
    $postsPorCategoria = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card text-bg-primary h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h6 class="card-title text-uppercase mb-0 text-white-50">Posts Publicados</h6>
              <h2 class="display-5 mb-0"><?php echo $totalPosts; ?></h2>
            </div>
            <i class="fa-solid fa-file-lines fa-3x opacity-50"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm border-primary">
          <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
            <h5 class="card-title text-primary">Tem um novo assunto?</h5>
            <a href="./blog/criar-post.php" class="btn btn-primary mt-2">
              <i class="fa-solid fa-plus me-2"></i> Criar Novo Post
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-7 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Últimos Posts</h5>
            <a href="./blog/posts.php" class="btn btn-sm btn-outline-secondary">Ver todos</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <tbody>
                  <?php if(count($ultimosPosts) > 0): ?>
                  <?php foreach($ultimosPosts as $p): ?>
                  <tr>
                    <td class="ps-3"><?php echo htmlspecialchars($p['titulo']); ?></td>
                    <td class="text-muted text-end">
                      <?php echo (new DateTime($p['data_criacao']))->format('d/m/Y'); ?>
                    </td>
                    <td class="text-end pe-3">
                      <a href="./blog/editar-post.php?id=<?php echo $p['id']; ?>" class="text-primary" title="Editar">
                        <i class="fa-solid fa-pencil"></i>
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="3" class="text-center p-3 text-muted">Nenhum post publicado ainda.</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white">
            <h5 class="mb-0">Seus Assuntos Mais Abordados</h5>
          </div>
          <ul class="list-group list-group-flush">
            <?php if(count($postsPorCategoria) > 0): ?>
            <?php foreach($postsPorCategoria as $cat): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?php echo ucfirst(htmlspecialchars($cat['nome'])); ?>
              <span class="badge text-bg-secondary rounded-pill">
                <?php echo $cat['qtd_posts']; ?> posts
              </span>
            </li>
            <?php endforeach; ?>
            <?php else: ?>
            <li class="list-group-item text-muted text-center">Sem dados no momento.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>

  </section>

  <?php 
  include '../includes/footer-admin.php';
  ?>

</body>

</html>