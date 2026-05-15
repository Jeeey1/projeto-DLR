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
  <link rel="stylesheet" href="../public/css/criar_style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../public/css/index_style.css" /> -->
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


  <section class="content-criar content">
    <h3>Criar novo post</h3>
    <form class="row m-5">
      <div class="mb-3 col-6">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control">
      </div>
      <div class="mb-3 col-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control">
      </div>
      <div class="mb-3 col-3">
        <label for="data" class="form-label">Data criação</label>
        <input type="date" name="data" class="form-control">
      </div>
      <div class="mb-3 col-12">
        <div id="editor"></div>
      </div>
      <div class="mb-3 col-6">
        <label for="foto" class="form-label">Ilustração</label>
        <input type="file" name="foto" class="form-control">
      </div>
      <div class="mb-3 col-6">
        <label for="servicos-select">Categoria</label>
        <select id="servicos-select" class="form-input">
          <option value="">Carregando opções...</option>
        </select>
      </div>
    </form>

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
  </script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script>
  var quill = new Quill('#editor', {
    theme: 'snow' // Carrega a barra de ferramentas padrão
  });
  </script>
  <script defer>
  $(document).ready(function() {
    //ENUMS
    const categorias = [
      "Neuropsicologia",
      "Saúde Mental",
      "Autismo",
      "Neurodivergente",
      "Psicanalise",
    ];
    const selectElement = document.getElementById('servicos-select');
    // Função para renderizar as opções
    function renderizarOpcoes() {
      // Limpa o "Carregando..." e deixa apenas a opção padrão
      selectElement.innerHTML = '<option value="">Selecione uma opção</option>';

      // O Loop
      categorias.forEach(servico => {
        // Cria o elemento option
        const option = document.createElement('option');

        // Define as propriedades
        option.value = servico.slug; // Ou servico.id, dependendo da sua lógica
        option.textContent = servico.nome;

        // Adiciona ao select
        selectElement.appendChild(option);
      });
    }

    // Executa a função ao carregar a página
    document.addEventListener('DOMContentLoaded', renderizarOpcoes);
  })
  </script>
</body>

</html>