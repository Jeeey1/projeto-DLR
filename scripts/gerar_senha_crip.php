<?php 
$senha = ''; // Colocar senha que quer criptografar aqui

echo password_hash($senha, PASSWORD_DEFAULT);
?>