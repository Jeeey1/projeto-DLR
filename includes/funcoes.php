<?php
  function transformaAno($data){
    $dataFormatada = date('d/m/Y', $data);
    return $dataFormatada;
  }
?>