<?php 
session_start();
include "../includes/conexao.php";

// Verifica se usuário que está excluindo está logado no sistema antes de realizar a ação
if ($_SESSION['logado'] != true){
  echo json_encode(['sucesso' => false, 'mensagem' => 'Não autorizado']);
  exit();
}

// $dados = json_decode(file_get_contents('php://input'), true);
$id = intval($_POST['id']);

// Verifica se o ID passado via parâmetro é válido
if($id <= 0){
  echo json_encode(['sucesso' => false, 'mensagem' => 'ID inválido!']);
  exit();
}

try {
  $pdo = (new Conexao())->conectar();

  $qryImg = "SELECT imagem FROM posts WHERE id = ?";
  $stmt = $pdo->prepare($qryImg);
  $stmt->execute([$id]);
  $post = $stmt->fetch(PDO::FETCH_ASSOC);

  if(!$post) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Post não encontrado']);
    exit();
  }

  $caminhoImagem = __DIR__ . '../../' . $post['imagem'];

  // Verifica se arquivo existe tanto no banco (url) quanto na pasta do projeto
  if(!empty($post['imagem']) && file_exists($caminhoImagem)){
    // Apaga imagem do projeto no diretório passado
    unlink($caminhoImagem);
  }

  $qry = "DELETE FROM posts WHERE id = ?";
  $stmt = $pdo->prepare($qry);
  $stmt->execute([$id]);

  header('Content-Type: application/json');
  echo json_encode(['sucesso' => true]);
  exit();
} catch (Exception $e){
  echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no banco de dados']);
}

?>