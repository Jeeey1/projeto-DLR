<?php

$pdo = (new Conexao())->conectar();
$stmt = $pdo->prepare("SELECT * FROM categorias");
$stmt->execute();
$categoriasDados = $stmt->fetchAll(PDO::FETCH_ASSOC);
$categorias = [];

foreach($categoriasDados as $categoria) {
  $categorias[] = [
    'id' => $categoria['id'],
    'nome' => $categoria['nome']
  ];
}

return $categorias;
?>