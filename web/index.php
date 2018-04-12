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
    <!-- Shell -->
    <div id="shell">
    <div id="header">
    	<h1  style=font-size:100px>24 FPS</h1>
		<div class="social">
			<!-- <span>FOLLOW US ON:</span>
			<ul>
			    <li><a class="twitter" href="#">twitter</a></li>
			    <li><a class="facebook" href="#">facebook</a></li>
			    <li><a class="vimeo" href="#">vimeo</a></li>
			    <li><a class="rss" href="#">rss</a></li>
			</ul> -->
		</div>
		
		<!-- Navigation -->
		<!-- <div id="navigation">
			<ul>
			    <li><a class="active" href="#">HOME</a></li>
			    <li><a href="#">NEWS</a></li>
			    <li><a href="#">IN THEATERS</a></li>
			    <li><a href="#">COMING SOON</a></li>
			    <li><a href="#">CONTACT</a></li>
			    <li><a href="#">ADVERTISE</a></li>
			</ul> 
		</div>
        -->
		<!-- end Navigation -->
		
		<!-- Sub-menu -->
		<!--<div id="sub-navigation">
			<ul>
			    <li><a href="#">Android Phone</a></li>
			    <li><a href="#">Android Box</a></li>
			    
			</ul>
			<div id="search">
				<form action="home_submit" method="get" accept-charset="utf-8" display="none">
					<label for="search-field">SEARCH</label>					
					<input type="text" name="search field" value="Enter search here" id="search-field" title="Enter search here" class="blink search-field"  />
					<input type="submit" value="GO!" class="search-button" />
				</form>
			</div>
		</div>
        -->
		<!-- end Sub-Menu -->
	</div>
    <!-- end Header -->
<?php
require ( './lib/lib_sqlitedb.php' );
require ( './lib/AES.php' );
function insertMovies($movies){
    $count = sizeof($movies);
    $index = 0;
    foreach($movies as $movie){
        echo ('<!-- Movie -->');
        if($index == $count - 1)
        echo ('<div class="movie last">');
        else 
        echo ('<div class="movie">');
    
        $key = 'An061285Ph140784';
        $aes = new AES($movie['extra'], $key, 128, null);
        $plain = $aes->decrypt();
        //echo($plain);
        $plain =preg_replace('/[\x00-\x1f]/', '', $plain);
        $extra = json_decode($plain);
        //echo('<br>');
        //echo($extra->yt_trailer_code);
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
    			    echo ('<div class="stars-in" style="width:' .$width .'px">');
			        echo ('</div>');
		        echo ('</div>');
		        echo ('<span></span>');
	        echo ('</div>');
        echo ('</div>');
        echo ('<!-- end Movie -->');
        $index ++;
    }
}

echo ('<div id="main">');
    echo ('<div id="content">');

$db = new sqlitedb(false);
$limit = 6;
$filters = "movie_id IN ('tt2283362','tt2527336','tt5580390','tt1389072','tt3501632','tt3411444','tt0974015','tt4765284','tt5580036','tt2543472','tt5027774','tt6684714','tt3402236','tt4555426','tt5657846','tt4465564','tt2380307','tt5052448','tt5001754','tt2404435','tt3348730','tt1396484','tt3829920','tt5013056','tt4649466','tt1034385','tt6977356','tt4686844','tt5783956','tt5721088','tt3874544','tt3890160','tt7315526','tt4630562','tt1615160','tt1431045','tt3521164','tt5886440','tt5390066','tt3896198','tt2406566','tt2345759','tt4425200','tt1790809','tt3315342','tt0451279','tt3371366','tt3606752','tt2322441','tt1959563')";
$movies = $db -> getMovieList ( $filters , $limit);
		echo ('<div class="box">');
			echo ('<div class="head">');
				echo ('<h1>MOST POPULAR</h1>');
				echo ('<p class="text-right">');
					echo ('<span> </span>');
				echo ('</p>');
			echo ('</div>');//End head
            
            insertMovies($movies);
            echo ('<div class="cl">&nbsp;</div>');
        echo ('</div>');//End box

$genres = ['action','adventure','animation','biography','comedy','crime','documentary','drama','family','fantasy','history','horror','musical','mystery','news','romance','sci-fi','sport','thriller','war','western'];
foreach($genres as $genre){
    $filters = "genres like '%" .$genre ."%'";
    $movies = $db -> getMovieList ( $filters , $limit);
        echo ('<div class="box">');
    		echo ('<div class="head">');
				echo ('<h1>' .strtoupper($genre) .'</h1>');
				echo ('<p class="text-right">');
					echo ('<a href="/genre.php?genre=' .$genre .'">See all</a>');
				echo ('</p>');
			echo ('</div>');//End head
            
            insertMovies($movies);
            echo ('<div class="cl">&nbsp;</div>');
        echo ('</div>');//End box
}
        echo ('<div class="cl">&nbsp;</div>');
    echo ('</div>');//End content
    
    echo ('<div class="cl">&nbsp;</div>');
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
