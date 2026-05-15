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
  <link rel="stylesheet" href="../../public/css/criar_style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body class="blog-page">

  <!-- HEADER/NAV -->
  <nav id="navbar">
    <div class="nav-logo">Dr. <span>Daniel</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="posts.php"><span data-lang="pt">Post</span></a></li>
      <li><a href="#home"><span data-lang="pt">Logout</span></a></li>
      <div class="hamburger" id="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <span></span><span></span><span></span>
      </div>
  </nav>


  <section class="content-criar content">
    <form class="row m-5" action="../db/insert-post.php" id="form-criar">

      <div class="mb-3 col">
        <button class="btn btn-primary btn-voltar"><a href="posts.php">Voltar</a></button>
      </div>

      <h3>Criar novo post</h3>

      <div class="mb-3 col-6">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" id="titulo">
      </div>
      <div class="mb-3 col-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control" id="autor">
      </div>
      <div class="mb-3 col-3">
        <label for="data" class="form-label">Data criação</label>
        <input type="date" name="data" class="form-control" id="data">
      </div>
      <div class="mb-3 col-12">
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
          <option value="">Carregando opções...</option>
        </select>
      </div>

      <div class="mb-3 col">
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

    //ENUMS
    const categorias = [
      "Neuropsicologia",
      "Saúde Mental",
      "Autismo",
      "Neurodivergente",
      "Psicanalise",
    ];

    const selectElement = document.getElementById('servicos-select');

    function renderizarOpcoes() {
      // Limpa o "Carregando..." e deixa apenas a opção padrão
      selectElement.innerHTML = '<option value="0">Selecione uma opção</option>';

      // O Loop
      categorias.forEach(servico => {
        // Cria o elemento option
        const option = document.createElement('option');

        // Define as propriedades // Ou servico.id, dependendo da sua lógica
        option.textContent = servico;

        // Adiciona ao select
        selectElement.appendChild(option);
      });
    }

    // Executa a função ao carregar a página
    renderizarOpcoes();

    let titulo = $('#titulo');
    let autor = $('#autor');
    let dataCriacao = $('#data');
    let corpoTexto = $('#editor');
    let img = $('#img');
    let categoria = $('#servicos-select');
    let btnSubmit = $('#btn-submit');
    const form = $('#form-criar');

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
      } else {
        if (corpoTexto.hasClass('erro-input')) {
          corpoTexto.removeClass('erro-input');
        }
      }

      if (categoria.val() == 0) {
        categoria.addClass('erro-input');
        bool = false;
      } else {
        if (categoria.hasClass('erro-input')) {
          categoria.removeClass('erro-input');
        }
      }

      if (bool) {
        const formData = new FormData();
        formData.append('titulo', titulo.val());
        formData.append('autor', autor.val());
        formData.append('data', dataCriacao.val());
        formData.append('corpoTexto', quill.root.innerHTML);
        formData.append('categ', categoria.val());
        formData.append('img', img[0].files[0]);

        $.ajax({
          url: '../../db/insert-post.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
              alert(res.message);
              window.location.replace('posts.php');
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
  });
  </script>
</body>

</html>