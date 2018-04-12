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
                <h1  style=font-size:50px>
<?php
require ( './lib/lib_sqlitedb.php' );
require ( './lib/AES.php' );
$movie_id = $_GET['movie_id'];
$db = new sqlitedb(false);
$movie = $db->getSingleMovie($movie_id);
echo($movie['title']);
?>
                </h1>
		        <div class="social">
		        </div>
            </div>
	    </div>
        <br>
        <br>
        <br>
        <div id="main">
            <div id="content">
<?php
                echo ('<br><br><br>');
    	        echo ('<div class="box">');
			        echo ('<div class="head">');
	    			    echo ('<p class="text-right">');
    	    				echo ('<span> </span>');
	    			    echo ('</p>');
		    	    echo ('</div>');//End head
                echo ('</div>');//End box
                echo ('<div class="box">');
                    echo ('<div class="movie">');
                        echo ('<div class="movie-image">');
    	                    echo ('<img src="' .$movie[cover] .'" alt="movie" /></a>');
	                    echo ('</div>');
                        echo ('<span class="name">&nbsp;</span>');
                    echo ('</div>');
                
                echo ('<div class="cl">&nbsp;</div>');
                echo ('</div>');
?>
            </div>
            <div id="footer">
            </div>
        </div>
    </body>
</html>
