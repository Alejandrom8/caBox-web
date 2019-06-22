<?php

class Connection {

  private $user;
  private $host;
  private $password;
  private $dataBase;
  private $charset;

  public function __construct(){
    $this->user = constant("USER");
    $this->host = constant("HOST");
    $this->password = constant("PASSWORD");
    $this->dataBase = constant("DB");
    $this->charset = constant("CHARSET");
  }

  public function connect(){
    try{

      $connection = "mysql:host=" . $this->host . ";dbname=" . $this->dataBase . ";charset=" . $this->charset;
      $options = [
          PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_EMULATE_PREPARES    => false,
          PDO::ATTR_ORACLE_NULLS        => PDO::NULL_TO_STRING
      ];

      $pdo = new PDO($connection, $this->user, $this->password, $options);

      return $pdo;
    }catch(PDOException $error){
      print_r("Error de conexion: " . $error->getMessage() . "</br>");
    }
  }

}

?>
