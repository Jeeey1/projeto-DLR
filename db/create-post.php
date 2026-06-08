<?php 
include '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  // Calcula o caminho correto - db está em /db, precisa subir 2 níveis para raiz
  $pastaDestino = __DIR__ . '/../src/img/posts/';
  
  // Garante caminho absoluto correto
  $pastaDestino = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR;

  // Garante que a pasta existe
  if (!is_dir($pastaDestino)){
    if (!mkdir($pastaDestino, 0755, true)){
      echo json_encode(['status' => 'error', 'message' => 'Erro ao criar diretório de upload']);
      exit;
    }
  }

  $arquivo = $_FILES['img'] ?? null;
  $temArquivo = $arquivo && $arquivo['error'] === UPLOAD_ERR_OK;

  $pdo = (new Conexao())->conectar();

  if($arquivo){
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    
    // Valida extensão
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array(strtolower($extensao), $extensoesPermitidas)){
      echo json_encode(['status' => 'error', 'message' => 'Extensão de arquivo não permitida']);
      exit;
    }

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
      echo json_encode(['status' => 'error', 'message' => 'Erro ao fazer upload da imagem. Verifique permissões de pasta.']);
    }
  } else {
    if ($arquivo && $arquivo['error'] !== UPLOAD_ERR_NO_FILE) {
      echo json_encode(['status' => 'error', 'message' => 'Erro no upload: ' . $arquivo['error']]);
      exit;
    }
    
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