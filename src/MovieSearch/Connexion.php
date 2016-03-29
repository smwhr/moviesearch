<?php
namespace MovieSearch;

class Connexion{

  private static $_instance = null;
  private $conn;

  private function __construct(){
    $config = new \Doctrine\DBAL\Configuration();
    $connectionParams = array(
      'url' => 'mysql://supinternet:supinternet21@127.0.0.1/supinternet_moviesearch?charset=utf8mb4',

    );
    $this->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
  }

  public static function getInstance(){
    if(is_null(self::$_instance) ){
      self::$_instance = new Connexion();  
    }
    return self::$_instance->conn;
  }

}