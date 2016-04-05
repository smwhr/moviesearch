<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MovieSearch</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

</head>
<body>
<div class="row">
  <div class="col-md-12">
    <div class="well">
      <form class="form-horizontal" id="movieSearchForm" method="POST" action="/index/search">
        <div class="form-group">
          <label for="titleInput" class="col-sm-2 control-label">Titre</label>
          <div class="col-sm-10">
            <input name="title" type="text" class="form-control" id="titleInput" placeholder="Titre du film">
          </div>
        </div>
        <div class="form-group">
          <label for="durationInput" class="col-sm-2 control-label">Durée</label>
          <div class="col-sm-10">
            <select name="duration" class="form-control" id="titleInput">
              <option value="">Tous</option>
              <option value="0-3600">Moins d'une heure</option>
              <option value="3600-5400">Entre 1h et 1h30</option>
              <option value="5400-9000">Entre 1h30 et 2h30</option>
              <option value="9000">Plus de 2h30</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Année</label>
          <div class="col-sm-1">
            Entre
          </div>
          <div class="col-sm-4">
            <input name="year_start" type="text" class="form-control" id="titleInput" placeholder="début">
          </div>
          <div class="col-sm-1">
            Et
          </div>
          <div class="col-sm-4">
            <input name="year_end" type="text" class="form-control" id="titleInput" placeholder="fin">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Genre du réalisateur</label>
          <div class="col-sm-10">
            <select name="genre" class="form-control" id="titleInput">
              <option value="">Tous</option>
              <option value="M">Masculin</option>
              <option value="F">Féminin</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chercher</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

function displayResult(data){ 
  console.log(data);

   $("#searchResults").empty(); 
  for(film_id in data.films){
    var film = data.films[film_id];
    var minutes = Math.floor(film.duration/60);
    var d_min = (minutes%60);
    if(d_min < 10){
      d_min = '0'+d_min;
    }
    var duration = Math.floor(minutes/60)+":"+d_min;

    var elt = "<tr>"+
                "<td>"+film.title+"</td>"+
                "<td>"+film.year+"</td>"+
                "<td>"+film.first_name+" "+ film.last_name +"</td>"+
                "<td>"+film.synopsis+"</td>"+
                "<td>"+duration+"</td>"+
              "</tr>";

    $("#searchResults").append(elt);
  }
}

function displayError(data){
  console.log(data) 
  $("#searchResults").empty(); 
  $("#searchResults").html("<div class='alert alert-danger'>"+data.responseJSON.error+"</div>");
}

$(document).on("submit", "#movieSearchForm", function(){
    var form = $(this);
    var action = form.attr("action");
    var method = form.attr("method");
    var data = form.serialize();

    $("#searchResults").empty(); 
    $("#searchResults").html("Recherche en cours...");

    $.ajax({
      type: method,
      url: action,
      data: data,
      dataType: "JSON",
      success:  displayResult,
      error: displayError
    });
    return false;
});

</script>

<div class="results">
  <table class="table table-hover">
    <thead>
    <tr>
      <th>
        Titre
      </th>
      <th>
        Année
      </th>
      <th>
        Réalisateur
      </th>
      <th>
        Synopsis
      </th>
      <th>
        Durée
      </th>
    </tr>
    </thead>

    <tbody id="searchResults">
    <tr>
      <td>
        Matrix
      </td>
      <td>
        1999
      </td>
      <td>
        Programmeur anonyme dans un service administratif le jour, Thomas Anderson devient Neo la nuit venue. Sous ce pseudonyme, il est l'un des pirates les plus recherchés du cyber-espace. A cheval entre deux mondes, Neo est assailli par d'étranges songes et des messages cryptés provenant d'un certain Morpheus. Celui-ci l'exhorte à aller au-delà des apparences et à trouver la réponse à la question qui hante constamment ses pensées : qu'est-ce que la 
      </td>
      <td>
        2h15
      </td>
    </tr>
    </tbody>
  </table>
</div>
  
</body>
</html>