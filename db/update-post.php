<?php 
session_start();
include '../includes/conexao.php';

$pdo = (new Conexao())->conectar();

$id = $_POST['id'];

// Pega as categorias selecionadas ou um array vazio
$categorias = $_POST['categoria'] ?? [];

$arquivo = $_FILES['img'] ?? null;
$temArquivo = $arquivo && $arquivo['error'] === UPLOAD_ERR_OK;

$qry = "SELECT imagem FROM posts WHERE id = ?";
$stmtImg = $pdo->prepare($qry);
$stmtImg->execute([$id]);
$postAntigo = $stmtImg->fetch(PDO::FETCH_ASSOC);
$imagemAntiga = $postAntigo['imagem'] ?? null;

$imagemFinal = $imagemAntiga; // Valor padrão é a imagem antiga

if($temArquivo){
  $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
  
  // Valida extensão
  $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  if (!in_array(strtolower($extensao), $extensoesPermitidas)){
    echo json_encode(['status' => 'error', 'message' => 'Extensão de arquivo não permitida']);
    exit;
  }
  
  $nomeArquivo = uniqid('img_') . '.' . $extensao;

  $pastaDestino = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR;
  
  // Garante que a pasta existe
  if (!is_dir($pastaDestino)){
    if (!mkdir($pastaDestino, 0755, true)){
      echo json_encode(['status' => 'error', 'message' => 'Erro ao criar diretório de upload']);
      exit;
    }
  }
  
  $caminhoCompleto = $pastaDestino . $nomeArquivo;

  if(move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)){
    $imagemFinal = 'src/img/posts/' . $nomeArquivo;

    // Exclui a imagem antiga se existir
    if(!empty($imagemAntiga)){
        $caminhoImagemAntiga = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $imagemAntiga);
        if(file_exists($caminhoImagemAntiga)){
            unlink($caminhoImagemAntiga);
        }
    }
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao fazer upload da imagem. Verifique permissões de pasta.']);
    exit;
  }
}

$data = [
  $_POST['titulo'],
  $_POST['descricao'],
  $_POST['corpoTexto'],
  $imagemFinal,
  $_POST['categoria'],
  $_POST['autor'],
  $_POST['data'],
  $id
];

$qry = "UPDATE posts SET titulo=?, descricao=?, corpo=?, imagem=?, categoria=?, autor=?, data_criacao=? WHERE id=?";
$stmt = $pdo->prepare($qry);
$stmt->execute($data);

// Retorna sucesso para o Javascript
echo json_encode(['status' => 'success', 'message' => 'Post atualizado com sucesso!']);
?>