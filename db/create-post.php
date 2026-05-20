<?php 
include '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $pastaDestino = __DIR__ . '../../src/img/posts/';

  // Garante que a pasta existe
  if (!is_dir($pastaDestino)){
    mkdir($pastaDestino, 0755, true);
  }

  $arquivo = $_FILES['img'] ?? null;
  $temArquivo = $arquivo && $arquivo['error'] === UPLOAD_ERR_OK;

  $pdo = (new Conexao())->conectar();

  if($arquivo){
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);

    //Gera nome único
    $nomeArquivo = uniqid('img_') . '.' . $extensao;
    $caminhoCompleto = $pastaDestino . $nomeArquivo;

    if(move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
      
      $caminhoBanco = 'src/img/posts/' . $nomeArquivo;

      //Dados para o insert
      $data = [
      $_POST['titulo'],
      $_POST['descricao'],
      $_POST['corpoTexto'],
      $caminhoBanco,
      $_POST['categ'],
      $_POST['autor'],
      $_POST['data'],
      1
      ];

      $qry = "INSERT INTO posts (titulo, descricao, corpo, imagem, categoria, autor, data_criacao, usuario_id) values (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($qry);
      $stmt->execute($data);

      if ($stmt->rowCount() > 0){
        echo json_encode(['status' => 'success', 'message' => 'Post criado com sucesso!']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao criar o post.']);
      }

    } else {
      die('Erro ao fazer upload da imagem');
    }
  } else {
    //Dados para o insert
      $data = [
      $_POST['titulo'],
      $_POST['descricao'],
      $_POST['corpoTexto'],
      $_POST['categ'],
      $_POST['autor'],
      $_POST['data'],
      1
      ];

      $pdo = new Conexao();
      $pdo = $pdo->conectar();
      $qry = "INSERT INTO posts (titulo, descricao, corpo, categoria, autor, data_criacao, usuario_id) values (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($qry);
      $stmt->execute($data);

      if ($stmt->rowCount() > 0){
        echo json_encode(['status' => 'success', 'message' => 'Post criado com sucesso!']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao criar o post.']);
      }
  }

}

?>