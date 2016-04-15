<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>

<img src="<?php echo "/index/thumb/".$film['id']."/400" ;?>" 
     style="width:200px;"/>

<h1><?php echo $film["title"]?></h1>

<p><?php echo $film["synopsis"]?></p>


<form enctype="multipart/form-data" method="POST" action="/index/upload">
  <label>Upload de fichier</label>
  <input type="hidden" name="film_id" value="<?php echo $film['id'];?>">
  <input type="file" name="poster_img" />
  <input type="submit" value="upload !">
</form>
  
</body>
</html>