<?php 
session_start();

include "../../includes/conexao.php";
include "../../includes/funcoes.php";

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
  <link rel="stylesheet" href="../../public/css/admin_style.css" />
  <link rel="stylesheet" href="../../public/css/index_style.css" />
  <link rel="stylesheet" href="../../public/css/posts.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="blog-page">

  <!-- HEADER/NAV -->
  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="../dashboard.php"><span data-lang="pt">Dashboard</span></a></li>
      <li><a href="posts.php"><span data-lang="pt">Post</span></a></li>
      <li><a href="#home"><span data-lang="pt">Logout</span></a></li>
      <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <span></span><span></span><span></span>
      </div>
  </nav>

  <section class="container-fluid mt-3 px-3 section-posts">
    <button class="btn btn-primary btn-criar"><a href="criar-post.php">Criar novo post</a></button>
    <?php 
    $pdo = new Conexao();
    $pdo = $pdo->conectar();
    $qry = "SELECT * FROM posts";
    $stmt = $pdo->prepare($qry);

    if($stmt->rowCount() > 0){
    ?>
    <div class="card div-content-post">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>Titulo</th>
            <th>Descrição</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Data criação</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php 
            foreach($stmt as $post){
            ?>
            <td><?php $post['titulo']?></td>
            <td><?php $post['corpo']?></td>
            <td><?php $post['autor']?></td>
            <td><?php $post['tag']?></td>
            <td><?php $post['data_criacao']?></td>
            <td>
              <div style="display: flex; gap: 20px;">
                <a href="#"><i class="fas fa-solid fa-pencil"></i></a>
                <a href="#"><i class="fa-solid fa-trash"></i></a>
              </div>
            </td>
          </tr>
          <?php 
            }
          ?>
        </tbody>
      </table>
      <?php 
    } else {
      echo "<h1>Nenhum post criado no momento!</h1>";
    }
    ?>
    </div>
  </section>

  <?php 
  include "../../includes/footer-admin.php";
?>

</body>

</html>