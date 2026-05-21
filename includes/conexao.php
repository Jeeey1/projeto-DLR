<?php 
Class Conexao{
  private $host = "127.0.0.1";
  private $dbname = "super_ego";
  private $user = "root";
  private $pass = "";
  private $dbh;

  function conectar(){
    $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->pass);
    return $this->dbh;
  }
}
?>