<?php 
session_start();
include '../includes/conexao.php';

$pdo = (new Conexao())->conectar();

$id = $_POST['id'];

// Pega as categorias selecionadas ou um array vazio
$categorias = $_POST['categ'] ?? [];

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
  $nomeArquivo = uniqid('img_') . '.' . $extensao;

  $pastaDestino = __DIR__ . '/../src/img/posts/';
  $caminhoCompleto = $pastaDestino . $nomeArquivo;

  if(move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)){
    $imagemFinal = 'src/img/posts/' . $nomeArquivo;

    // Exclui a imagem antiga se existir
    if(!empty($imagemAntiga) && file_exists(__DIR__ . '/../' . $imagemAntiga)){
        unlink(__DIR__ . '/../' . $imagemAntiga);
    }
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao fazer upload da imagem']);
    exit;
  }
}

// CORREÇÃO 3: Removidos 'categoria' e 'usuario_id' do array de dados
// Adicionado o $id no final, que servirá para o WHERE da query
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