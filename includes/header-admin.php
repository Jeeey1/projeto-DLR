<?php 
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>

<nav id="navbar">
  <div class="nav-content">
    <div class="nav-logo"><a href="<?php 
    if($paginaAtual === 'criar-post.php' || $paginaAtual === 'editar-post.php' || $paginaAtual === 'posts.php') {
      echo '../dashboard.php';
    } else {
      echo 'dashboard.php';
    }
    ?>">Dr. <span>Daniel</span></a></div>

    <ul class="nav-links" id="navLinks">
      <?php 
        if($paginaAtual !== 'dashboard.php'){
          echo '<li><a href="../dashboard.php">Dashboard</a></li>';
        }
      ?>
      </li>
      <?php 
      if($paginaAtual !== 'posts.php' && $paginaAtual !== 'dashboard.php'){
        echo '<li><a href="posts.php">Posts</a></li>';
      }

      if($paginaAtual === 'dashboard.php') {
        echo '<li><a href="blog/posts.php">Posts</a></li>';
      }
      ?>
      <?php 
      if($paginaAtual === 'dashboard.php'){
        echo '<li><a href="logout.php">Logout</a></li>';
      } else {
        echo '<li><a href="../logout.php">Logout</a></li>';
      }
      ?>
    </ul>
    <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
      <span></span><span></span><span></span>
    </div>
  </div>
</nav>