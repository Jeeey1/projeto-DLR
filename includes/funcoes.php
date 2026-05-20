<?php
  function transformaAno($data){
    $dataFormatada = date('d/m/Y', $data);
    return $dataFormatada;
  }

  function getCategoriaNome($id, $categorias) {
    foreach($categorias as $categoria) {
      if ($categoria['id'] == $id) {
        return $categoria['nome'];
      }
    }
    return "Sem categoria";
  }
?>