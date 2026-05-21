<?php 
session_start();

include "../includes/conexao.php";

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$pdo = new Conexao();
$sql = $pdo->conectar();

$query = $sql->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$query->bindParam(':usuario', $usuario);
$query->execute();

if($query->rowCount() == 0){
  $_SESSION['msg_erro'] = "Usuário não encontrado";
  header("Location: index.php");
  exit();
  
} else {
  $dadosUsuario = $query->fetch(PDO::FETCH_ASSOC);

  if(password_verify($senha, $dadosUsuario['senha'])) {

    session_regenerate_id();

    $_SESSION['usuario_id']     = $dadosUsuario['id'];
    $_SESSION['usuario_nome']   = $dadosUsuario['usuario'];
    $_SESSION['logado']         = true;

    header("Location: dashboard.php");
    exit();

  } else {
    $_SESSION['msg_erro'] = "Senha incorreta!";
    header("Location: index.php");
    exit(); 

  }
}

?>