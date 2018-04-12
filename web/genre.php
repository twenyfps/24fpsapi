<!DOCTYPE html>
<html>
  <head>
    <title>24 FPS</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/grt-youtube-popup.css">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" />
	<![endif]-->
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-func.js"></script>
    </head>
    <body>
    <div id="shell">
    <div id="header">
<?php
        $genre = $_GET['genre'];
    	echo('<h1  style=font-size:50px><a href="./index.php">' .strtoupper($genre) .'</a></h1>');
?>
    	<div class="social">
		</div>
	</div>
    
<?php

require ( './lib/lib_sqlitedb.php' );
require ( './lib/AES.php' );

function insertMovies($movies){
    $count = sizeof($movies);
    $index = 1;
        echo ('<div class="box">');//Start Box
    foreach($movies as $movie){
        if($index % 6 == 0){
            echo ('<div class="movie last">');//Start Movie Last
        }else {
            echo ('<div class="movie">');//Start Movie
        }
        $key = 'An061285Ph140784';
        $aes = new AES($movie['extra'], $key, 128, null);
        $plain = $aes->decrypt();
        $plain =preg_replace('/[\x00-\x1f]/', '', $plain);
        $extra = json_decode($plain);
                echo ('<div class="movie-image">');
		            echo ('<a class="youtube-link" youtubeid="' .$extra->yt_trailer_code .'" href="#"><span class="play"></span><img src="' .$movie['cover'] .'" alt="movie" /></a>');
	            echo ('</div>');
                echo ('<span class="name">&nbsp;</span>');
                echo ('<a href="/movie.php?movie_id='.$movie['movie_id'] .'">' .$movie['title'] .'</a>');
	            echo ('<div class="rating">');
                    $rating = $movie['rating'];
                    $rating = $rating / 10;
                    $width = $rating * 60;
		            echo ('<div class="stars">');
    			        echo ('<div class="stars-in" style="width:' .$width .'px"></div>');
    		        echo ('</div>');
	            echo ('</div>');//End Rating
            echo ('</div>');//End Movie
        if($index % 6 == 0 || $index === $count){
            echo ('<div class="cl">&nbsp;</div>');
        echo ('</div>');//End Box
        if($index < $count)
        echo ('<div class="box">');//Start Box
        }
        $index ++;
    }
}

echo ('<div id="main">');
    echo ('<div id="content">');


$db = new sqlitedb(false);
$limit = 120;
$filters = "genres like '%" .$genre ."%'";
$movies = $db -> getMovieList ( $filters , $limit);
        echo ('<br><br><br>');
		/*echo ('<div class="box">');
			echo ('<div class="head">');
				echo ('<p class="text-right">');
					echo ('<span> </span>');
				echo ('</p>');
			echo ('</div>');//End head
        echo ('</div>');//End box*/
        
        insertMovies($movies);
            //echo ('<div class="cl">&nbsp;</div>');
        //echo ('</div>');//End box
        //echo ('<div class="cl">&nbsp;</div>');
    echo ('</div>');//End content
echo ('</div>');//End Main

echo ('<div id="footer">');
echo ('</div>');//End footer
echo ('</div>');
echo ('<!-- end Shell -->');
?>
<!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<!-- GRT Youtube Popup -->
	<script src="js/grt-youtube-popup.js"></script>
    <script>
    		// Demo video 1
			$(".youtube-link").grtyoutube({
				autoPlay:true,
				theme: "dark"
			});
		</script>
</body>
</html>
