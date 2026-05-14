<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dr. Daniel | Psicólogo & Neuropsicólogo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
  <nav id="navbar-login">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
  </nav>

  <!-- LOGIN -->
  <section class="section-login">
    <?php if(isset($_SESSION['msg_erro'])){
      echo '<p style="color: red; font-weigth: bold;">' . $_SESSION['msg_erro'] . '</p>';
      unset($_SESSION['msg_erro']);
    } ?>
    <div class="container">
      <form class="form-login" action="validar.php" method="POST">
        <h2 style="text-align: center;">Admin</h2>
        <div class="form-group">
          <label for="usuario">Nome de usuário</label>
          <input type="text" class="form-control" name="usuario">
        </div>
        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" class="form-control" name="senha">
        </div>
        <input type="submit" class="btn btn-primary" style="margin-left: auto; margin-right: auto;">
      </form>
    </div>
  </section>

  <?php 
  include "../includes/footer.php";
  ?>

  <script src="../public/js/script.js" defer></script>
</body>

</html>