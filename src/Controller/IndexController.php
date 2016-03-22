<?php
namespace Controller;

use Doctrine\DBAL\Query\QueryBuilder;

class IndexController{
  public function indexAction(){
      //include view
  }

  public function searchAction(){
    //se connecter à la bdd
    header('Content-Type: application/json');
    
    $config = new \Doctrine\DBAL\Configuration();
    $connectionParams = array(
      'url' => 'mysql://supinternet:supinternet21@127.0.0.1/supinternet_moviesearch',
    );
    $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    //creer la requete adéquate
    $sql = "SELECT * FROM film WHERE 1";
    
    //envoyer la requête à la BDD
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //renvoyer les films qu'on a trouvés
    $films = $stmt->fetchAll();
    return json_encode(["films" => $films]);
  }
}