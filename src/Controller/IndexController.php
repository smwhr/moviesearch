<?php
namespace Controller;

use Doctrine\DBAL\Query\QueryBuilder;

class IndexController{
  public function indexAction(){
      include("search.php");
  }

  public function searchAction(){
    //se connecter à la bdd
    header('Content-Type: application/json');

    $conn = \MovieSearch\Connexion::getInstance();

    //creer la requete adéquate
    $sql = "SELECT * FROM film 
            LEFT JOIN film_director as fd ON fd.film_id = film.id
            LEFT JOIN artist ON artist.id = fd.artist_id
            WHERE 1 ";

    $parameters = [];

    if(isset($_POST[ 'title'])){
      if(!empty($_POST[ 'title'])){
        $sql .= " AND film.title LIKE :film_title ";
        $parameters["film_title"] = "%".$_POST[ 'title']."%";
      }
    }
    if(isset($_POST[ 'year_start'])){
      if(!empty($_POST[ 'year_start'])){
        $sql .= " AND film.year >= :film_year_start ";
        $parameters["film_year_start"] = $_POST[ 'year_start'];
      }
    }
    if(isset($_POST[ 'year_end'])){
      if(!empty($_POST[ 'year_end'])){
        $sql .= " AND film.year <= :film_year_end ";
        $parameters["film_year_end"] = $_POST[ 'year_end'];
      }
    }

    if(isset($_POST[ 'duration'])){
      if(!empty($_POST[ 'duration'])){
        @list($start_duration, $end_duration) = explode("-",$_POST[ 'duration']);
        $sql .= " AND film.duration >= :film_duration_start ";
        $parameters["film_duration_start"] = (int)$start_duration;

        if(!is_null($end_duration)){
          $sql .= " AND film.duration <= :film_duration_end ";
          $parameters["film_duration_end"] = (int)$end_duration;
        }
      }
    }

    if(isset($_POST[ 'genre'])){
      if(!empty($_POST[ 'genre'])){
        $sql .= " AND artist.gender LIKE :film_genre ";
        $parameters["film_genre"] = "%".$_POST[ 'genre']."%";
      }
    }
    
    //envoyer la requête à la BDD
    $stmt = $conn->prepare($sql);

    foreach($parameters as $key => &$value){
        $stmt->bindParam($key,$value);
    }

    $stmt->execute();
    //renvoyer les films qu'on a trouvés
    $films = $stmt->fetchAll();
    $count = $stmt->rowCount();
    
    if($count == 0){
      http_response_code(404);
      return json_encode(["error" => "No film found", "query" => $sql, "parameters" => $parameters]);
    }

    return json_encode(["films" => $films, "query" => $sql, "parameters" => $parameters]);
  }
}