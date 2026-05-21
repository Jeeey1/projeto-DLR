<?php
// template_post.php
include "includes/conexao.php";
include "includes/funcoes.php";
// Buscamos as categorias para exibir o nome em vez do ID
$categorias = include_once 'db/getCategoria.php'; 

if (!isset($_GET['id'])) { header("Location: index.php"); exit(); }
$id = $_GET['id'];

$pdo = (new Conexao())->conectar();
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) { header("Location: index.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $post['titulo']; ?> | Dr. Daniel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;700&display=swap"
    rel="stylesheet">

  <style>
  :root {
    --primary-color: #0d9488;
    /* Tom de verde/azul clínico */
    --dark-overlay: rgba(0, 0, 0, 0.65);
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background-color: #fff;
    margin: 0;
  }

  /* BANNER FULL WIDTH */
  .post-hero {
    width: 100%;
    height: 70vh;
    /* Ocupa 70% da altura da tela */
    min-height: 450px;
    position: relative;
    background-image: url('/projeto-DLR/<?php echo $post['imagem']; ?>');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    /* Alinha o conteúdo na parte de baixo do banner */
    color: #fff;
  }

  /* OVERLAY ESCURO */
  .post-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, var(--dark-overlay) 20%, transparent 100%);
    z-index: 1;
  }

  .hero-content {
    position: relative;
    z-index: 2;
    padding-bottom: 60px;
    width: 100%;
  }

  .category-tag {
    background-color: var(--primary-color);
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: inline-block;
    margin-bottom: 15px;
  }

  .post-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    /* Fonte fluida conforme a tela */
    font-weight: 700;
    line-height: 1.1;
    max-width: 900px;
  }

  .post-meta {
    font-size: 1rem;
    opacity: 0.9;
    margin-top: 15px;
  }

  /* CORPO DO TEXTO */
  .article-body {
    max-width: 850px;
    margin: 60px auto;
    padding: 0 25px;
    font-size: 1.2rem;
    line-height: 1.8;
    color: #334155;
  }

  .article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
  }

  /* Botão Voltar */
  .btn-back {
    display: block;
    margin: 40px auto;
    width: fit-content;
    text-decoration: none;
    color: #64748b;
    font-weight: 500;
    transition: color 0.3s;
  }

  .btn-back:hover {
    color: var(--primary-color);
  }
  </style>
</head>

<body>

  <header class="post-hero">
    <div class="container hero-content">
      <div class="row">
        <div class="col-12">
          <span class="category-tag">
            <?php echo getCategoriaNome($post['categoria'], $categorias); ?>
          </span>
          <h1 class="post-title"><?php echo htmlspecialchars($post['titulo']); ?></h1>
          <div class="post-meta">
            Por Dr. <?php echo ucfirst($post['autor']); ?> •
            <?php echo (new DateTime($post['data_criacao']))->format('d/m/Y'); ?>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="container article-body">
    <article>
      <?php echo $post['corpo']; ?>
    </article>

    <a href="index.php#blog" class="btn-back">&larr; Voltar para a página inicial</a>
  </main>

</body>

</html>