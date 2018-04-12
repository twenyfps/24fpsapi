<?php
include('IMDbapi.php');
$imdb = new IMDbapi('VvIoFYfN6yMDN1UEIn0SVmYsQzxmVV');
$id = $_GET['movie_id'];
$data = $imdb->get($id,'json');
echo($data);
?>
