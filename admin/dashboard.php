<?php 
session_start();

include "../includes/conexao.php";
include "../includes/funcoes.php";

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
  <link rel="stylesheet" href="../public/css/admin_style.css" />
  <link rel="stylesheet" href="../public/css/index_style.css" />
</head>

<body class="blog-page">

  <!-- HEADER/NAV -->
  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="#home"><span data-lang="pt">Blog</span></a></li>
      <li><a href="#home"><span data-lang="pt">Logout</span></a></li>
      <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <span></span><span></span><span></span>
      </div>
  </nav>


  <section>
    <?php if($_SESSION['usuario_nome']){
      echo "<h1>Seja bem-vindo(a) ao sistema " . ucfirst($_SESSION['usuario_nome']) . "!";
    } else {
      echo "<h1>Seja bem-vindo(a) ao sistema!";
    }
    ?>
    <div class="div-btn-criar">
      <a href="criar-post.php"><button class="btn-criar-post btn btn-primary">Criar novo post</button></a>
    </div>
    <div class="post-content">
      <?php 
        $pdo = new Conexao();
        $query = $pdo->conectar();
        $query = $query->prepare("SELECT * FROM posts");
        $query->execute();

        if($query->rowCount() > 0){
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
            ?>
      <div class="preview-posts">
        <img src=<?php echo $row['imagem'] ?> alt="Imagem ilustrativa do blog">
        <div>
          <h3><?php echo  $row['titulo'] ?></h3>
          <p><?php echo $row['corpo'] ?></p>
          <div class="footer-preview-posts">
            <p><?php if(!empty($row['autor'])){
              echo $row['autor'];
            }else{
              echo "Desconhecido";
            }  ?></p>
            <p><?php echo transformaAno(strtotime($row['data_criacao']))?></p>
          </div>
        </div>
      </div>
    </div>
    <?php 
          }
        } 
    ?>

  </section>

  <!-- FOOTER -->
  <footer class="footer-admin">
    <div>
      <div class="footer-brand">Dr. <span>Daniel</span></div>
      <div class="lgpd-note"><span data-lang="pt">© 2026 · Todos os direitos reservados · LGPD</span><span
          data-lang="en">© 2026 · All rights reserved · LGPD</span></div>
    </div>
    <div class="footer-copy">CRP 06/130646</div>
  </footer>

</body>

</html>