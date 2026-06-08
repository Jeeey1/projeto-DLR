<?php 
session_start();

include "../../includes/conexao.php";
include "../../includes/funcoes.php";
$categorias = include '../../db/getCategoria.php';

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="../../public/css/common.css" />
  <link rel="stylesheet" href="../../public/css/criar_style.css" />
  <link rel="stylesheet" href="../../public/css/header_admin.css" />
  <link rel="stylesheet" href="../../public/css/footer_admin.css" />

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

  <div class="alerta-sucesso-criar-post" style="display: none;">
    <p></p>
  </div>

  <?php include "../../includes/header-admin.php"; ?>


  <section class="content-criar content container-fluid mt-3 px-3">
    <h1 class="py-2">Criar novo post</h1>
    <hr>

    <form class="row" action="../../db/create-post.php" id="form-criar">

      <div class="mb-3 col-md-12 d-flex justify-content-end">
        <a class="btn btn-primary btn-voltar">Voltar</a>
      </div>

      <div class="mb-3 col-6">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" id="titulo" maxlength="100">
      </div>
      <div class="mb-3 col-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control" id="autor" disabled
          value="<?php echo ucfirst($_SESSION['usuario_nome'])?>">
      </div>
      <div class="mb-3 col-3">
        <label for="data" class="form-label">Data criação</label>
        <input type="date" name="data" class="form-control" id="data">
      </div>
      <div class="mb-3 col">
        <label for="descricao" class="form-label">Descrição curta</label>
        <input type="text" class="form-control" name="descricao" id="descricao" maxlength="150">
      </div>
      <div class="pb-5 col-12">
        <div id="editor"></div>
      </div>
      <div class="mb-3 col-6">
        <label for="foto" class="form-label">Ilustração</label>
        <input type="file" name="foto" class="form-control" id="img">
        <p id="message"></p>
      </div>
      <div class="mb-3 col-6">
        <label for="servicos-select" class="form-label">Categoria</label>
        <select id="servicos-select" class="form-control">
          <option value="">Selecione...</option>
          <?php 
            foreach($categorias as $categoria) {
              echo "<option value='" . $categoria['id'] . "'>" . ucfirst($categoria['nome']) . "</option>";
            }
          ?>
        </select>
      </div>

      <div class="mb-3 col-md-12 d-flex justify-content-end">
        <input type="submit" class="btn btn-primary" value="Criar post" id="btn-submit">
      </div>

    </form>

  </section>

  <!-- FOOTER -->
  <?php 
  include "../../includes/footer-admin.php";
  ?>

  <script>
  $(document).ready(function() {

    var quill = new Quill('#editor', {
      theme: 'snow' // Carrega a barra de ferramentas padrão
    });

    let titulo = $('#titulo');
    let autor = $('#autor');
    let dataCriacao = $('#data');
    let corpoTexto = $('#editor');
    let img = $('#img');
    let categoria = $('#servicos-select');
    let btnSubmit = $('#btn-submit');
    const form = $('#form-criar');
    let descricao = $('#descricao')

    // Pega data atual e preenche no campo data
    const hoje = new Date().toISOString().split('T')[0];
    dataCriacao.val(hoje);
    dataCriacao.prop('disabled', 'true');

    btnSubmit.click(function(e) {
      e.preventDefault();
      let bool = true;

      if (titulo.val() == '') {
        titulo.addClass('erro-input');
        bool = false;
      } else {
        if (titulo.hasClass('erro-input')) {
          titulo.removeClass('erro-input');
        }
      }

      if (autor.val() == '') {
        autor.addClass('erro-input');
        bool = false;
      } else {
        if (autor.hasClass('erro-input')) {
          autor.removeClass('erro-input');
        }
      }

      if (quill.getText().trim() == '') {
        corpoTexto.addClass('erro-input');
        bool = false;
      } else {
        if (corpoTexto.hasClass('erro-input')) {
          corpoTexto.removeClass('erro-input');
        }
      }

      if (categoria.val() == '') {
        categoria.addClass('erro-input');
        bool = false;
      } else {
        if (categoria.hasClass('erro-input')) {
          categoria.removeClass('erro-input');
        }
      }

      if (descricao.val() == '') {
        descricao.addClass('erro-input');
        bool = false;
      } else {
        if (descricao.hasClass('erro-input')) {
          descricao.removeClass('erro-input');
        }
      }

      if (bool) {
        const formData = new FormData();
        formData.append('titulo', titulo.val());
        formData.append('descricao', descricao.val());
        formData.append('corpoTexto', quill.root.innerHTML);
        formData.append('autor', autor.val());
        formData.append('data', dataCriacao.val());
        formData.append('categ', categoria.val());

        if (img[0].files[0]) {
          formData.append('img', img[0].files[0]);
        }

        let divAlerta = $('.alerta-sucesso-criar-post');
        let textoAlerta = $('.alerta-sucesso-criar-post p');

        $.ajax({
          url: '../../db/create-post.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            const res = JSON.parse(response);

            if (res.status === 'success') {
              textoAlerta.text(res.message)

              divAlerta.fadeIn(1000);

              setTimeout(function() {
                divAlerta.fadeOut(1000);
              }, 3000)

              setTimeout(function() {
                window.location.replace('posts.php');
              }, 2800);
            } else {
              alert(res.message);
            }
          },
          error: function(err) {
            console.log(err);
          }
        })
      }
    });

    verificaErroFile();

    function verificaErroFile() {
      const message = $('#message');

      img.on('change', function() {
        const file = this.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB em bytes
        const tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];

        if (file && !tiposPermitidos.includes(file.type)) {
          message.text('Apenas imagens são permitidas (JPG, PNG, WEBP, GIF)');
          message.css('color', 'red');
          img.addClass('erro-input');
          img.val('');
          return;
        }

        if (file && file.size > maxSize) {
          message.text('O arquivo é muito grande! Máximo de 2MB.');
          message.css('color', 'red');
          img.addClass('erro-input');
          img.val('');
        } else {
          if (img.hasClass('erro-input')) {
            img.removeClass('erro-input');
            message.text('');
          }
        }
      });
    }

    $('.btn-voltar').on('click', function(e) {
      e.preventDefault();
      window.history.back();
    })
  });
  </script>
</body>

</html>