<?php 
session_start();
include '../includes/conexao.php';

$pdo = (new Conexao())->conectar();

$id = $_POST['id'];

$arquivo = $_FILES['img'] ?? null;
$temArquivo = $arquivo && $arquivo['erro'] === UPLOAD_ERR_OK;

if($temArquivo){
  // Faz upload da nova imagem
  $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
  $nomeArquivo = uniqid('img') . '.' . $extensao;
  $pastaDestino = __DIR__ . '/../../src/img/posts';
  move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $nomeArquivo);
  $imagemFinal = 'src/img/posts/' . $nomeArquivo;

  // Apaga a imagem antiga
  $qry = "SELECT imagem FROM posts WHERE id = ?";
  $stmtImg = $pdo->prepare($qry);
  $stmtImg->execute([$id]);
  $antiga = $stmtImg->fetch(PDO::FETCH_ASSOC);
  
  if(!empty($antiga['imagem']) && file_exists(__DIR__ . '/../../' . $antiga['imagem'])){
    unlink(__DIR__ . '/../../' . $antiga['imagem']);
  }
} else {
  $qry = "SELECT imagem FROM posts WHERE id = ?";
  $stmtImg = $pdo->prepare($qry);
  $stmtImg->execute([$id]);
  $antiga = $stmtImg->fetch(PDO::FETCH_ASSOC);
  $imagemFinal = $antiga['imagem'];
}

$data = [
  $_POST['titulo'],
  $_POST['descricao'],
  $_POST['corpoTexto'],
  $imagemFinal,
  $_POST['categ'],
  $_POST['autor'],
  $_POST['data'],
  $_POST['usuario_id'],
];

$qry = "UPDATE posts SET titulo=?, descricao=?, corpo=?, imagem=?,categoria=?, autor=?, data_criacao=?, usuario_id=?";
$stmt = $pdo->prepare($qry);


?>