<?php 
session_start();

include "../../includes/conexao.php";
$categorias = include_once '../../db/getCategoria.php';
include "../../includes/funcoes.php";

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/common.css" />
  <link rel="stylesheet" href="../../public/css/admin_style.css" />
  <link rel="stylesheet" href="../../public/css/index_style.css" />
  <link rel="stylesheet" href="../../public/css/posts.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="blog-page">

  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Deseja mesmo excluir esse post?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btn-excluir-modal">Excluir</button>
        </div>
      </div>
    </div>
  </div>

  <!-- HEADER/NAV -->
  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="../dashboard.php"><span data-lang="pt">Dashboard</span></a></li>
      <li><a href="posts.php"><span data-lang="pt">Post</span></a></li>
      <li><a href="../logout.php"><span data-lang="pt">Logout</span></a></li>
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
    $stmt->execute();

    if($stmt->rowCount() > 0){
    ?>
    <div class="card div-content-post">
      <table class="table">
        <thead style="text-align: center;">
          <tr class="table-dark">
            <th>Titulo</th>
            <th>Descrição</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Data criação</th>
            <th></th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <?php foreach($stmt as $post){ ?>
          <tr id="<?php echo $post['id']?>">
            <td><?php echo htmlspecialchars($post['titulo']) ?></td>
            <td><?php echo htmlspecialchars($post['descricao']) ?></td>
            <td><?php echo htmlspecialchars($post['autor']) ?></td>
            <td><?php echo ucfirst(htmlspecialchars(getCategoriaNome($post['categoria'], $categorias))) ?></td>
            <td><?php echo (new DateTime(htmlspecialchars($post['data_criacao'])))->format('d/m/Y') ?></td>
            <td>
              <div style="display: flex; gap: 20px;">
                <a href="editar-post.php?id=<?php echo $post['id']?>" id="editar"><i
                    class="fas fa-solid fa-pencil"></i></a>
                <button class="btn-excluir" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                  data-id="<?php echo $post['id']?>"><i class="fa-solid fa-trash"></i></button>
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

  <script>
  let postId = null;

  // 1. REMOVA aquele bloco inteiro do $('#staticBackdrop').on('hidden.bs.modal'...)
  // O Bootstrap 5 já limpa o backdrop automaticamente se o modal for fechado do jeito certo.

  // 2. Captura o ID ao clicar na lixeira
  $(document).on('click', '.btn-excluir', function() {
    postId = $(this).data('id');
  });

  // 3. Ação do botão de excluir dentro do modal
  $('#btn-excluir-modal').on('click', function() {
    if (!postId) return;

    let formData = new FormData();
    formData.append('id', postId);

    $.ajax({
      url: '../../db/delete-post.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(data) {
        if (data.sucesso) {

          // Isso obriga o Bootstrap a rodar o ciclo natural dele e limpar a tela escura perfeitamente.
          $('#staticBackdrop .btn-close').click();

          // Isso evita que o navegador se perca nas animações.
          setTimeout(function() {
            $('#' + postId).fadeOut(400, function() {
              $(this).remove();
            });
            postId = null;
          }, 300);

        } else {
          alert('Erro: ' + data.mensagem);
        }
      },
      error: function() {
        console.log('Erro na requisição excluir post.');
      }
    });
  });
  </script>

</body>

</html>