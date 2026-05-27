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
  <link rel="stylesheet" href="../public/css/header_admin.css" />
  <link rel="stylesheet" href="../public/css/footer_admin.css" />
  <link rel="stylesheet" href="../public/css/profile.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


<body>
  <header>
    <?php 
    include "../includes/header-admin.php";
    ?>
  </header>

  <main>
    <section class="content card content-profile">
      <div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae culpa consectetur tenetur sequi a ipsum modi
          unde magnam eveniet, repellat iste fugit quo fuga, beatae necessitatibus, non autem odio suscipit!Lorem ipsum
          dolor sit amet consectetur adipisicing elit. Vitae culpa consectetur tenetur sequi a ipsum modi unde magnam
          eveniet, repellat iste fugit quo fuga, beatae necessitatibus, non autem odio suscipit!</p>
      </div>
      <div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae culpa consectetur tenetur sequi a ipsum modi
          unde magnam eveniet, repellat iste fugit quo fuga, beatae necessitatibus, non autem odio suscipit!</p>
      </div>
    </section>
  </main>

  <footer>
    <?php 
    include "../includes/footer-admin.php";
    ?>
  </footer>
</body>