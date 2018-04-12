<?php
require_once('_includes/download.php');
require_once('_includes/main.php');
$db = new MDB();
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
echo '<html lang="en">';
echo '<head>';
echo '    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >';
echo '</head>';
echo '<body>';
$limit = 50;
$page = 3;
$genre = "all";
$sort_by = "year";
$order_by = "desc";
$curl_post_data = array(
    "limit"=>$limit,
    "page"=>$page,
    "quality"=>"720p",
    "minimum_rating"=>0,
    "query_term"=>0,
    "genre"=>$genre,
    "sort_by"=>$sort_by,
    "order_by"=>$order_by,
    "with_rt_ratings"=>"false"
);
$service_url = 'https://yts.ag/api/v2/list_movies.json';
$service_url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
curl_close($curl);
$result = json_decode($curl_response);
//print_r($result);
$status = $result->status;
$data = $result->data;
$movies = $data->movies;
foreach ($movies as $movie) :

$imdb=$movie->imdb_code;
$cover='./_images/' .$imdb .'.jpg';

$title=$movie->title_long;
$language=$movie->language;
$genres=implode (",", $movie->genres);;
$year=$movie->year;
$runtime=$movie->runtime;
$rating=$movie->rating;
$trailer='https://www.youtube.com/watch?v=' .$movie->yt_trailer_code;

$torrent720p = null;
foreach ($movie->torrents as $torrent) :
    $torrent720p = $torrent;
    if($torrent->quality == '720p'){
        break;
    }
endforeach;
$torrent_id= 'magnet%3A%3Fxt%3Durn%3Abtih%3A' .$torrent720p->hash .'%26dn%3D' .urlencode($title) .'%26tr%3Dudp%253A%252F%252F9.rarbg.com%253A2710%252Fannounce%26tr%3Dudp%253A%252F%252Fp4p.arenabg.com%253A1337%26tr%3Dudp%253A%252F%252Ftracker.coppersurfer.tk%253A6969%252Fannounce%26tr%3Dudp%253A%252F%252Ftracker.internetwarriors.net%253A1337%26tr%3Dudp%253A%252F%252Ftracker.leechers-paradise.org%253A6969%26tr%3Dudp%253A%252F%252Ftracker.opentrackr.org%253A1337%252Fannounce%26tr%3Dwss%253A%252F%252Ftracker.btorrent.xyz%26tr%3Dwss%253A%252F%252Ftracker.fastcast.nz%26tr%3Dwss%253A%252F%252Ftracker.openwebtorrent.com';

//$torrent_id= urlencode($movie->torrents[0]->url);

download($movie->medium_cover_image, $cover);

$success = $db->insertMovieEx($imdb, $title, $cover, $language, $genres, $year, $runtime, $rating, $trailer, $torrent_id);
if($success == true){
    echo 'Insert ' .$movie->title .' into DB success.<br>';
}else{
    echo 'Insert ' .$movie->title .' into DB failed.<br>';
}
//$success = $db->insertMovieEx();
//echo '<br>';
//echo '<br>imdb: ' .$movie->imdb_code ;
//echo '<br>title: ' .$movie->title ;
//echo '<br>Cover: ' .$movie->medium_cover_image;
//echo '<br>Language: ' .$movie->language;
//echo '<br>Year: ' .$movie->year;
//echo '<br>Lenght: ' .$movie->runtime; 
//echo '<br>Rating: ' .$movie->rating;
/*
//Cover
echo '<tr>';
echo '<td><img src="';
echo $movie->medium_cover_image;
echo '" alt="Movie Cover not available" height="160" width="120"></td>';
//IMDB
echo '<td><a target="_blank" href="http://www.imdb.com/title/';
echo $movie->imdb_code;
echo '/" lang="';
echo $movie->language;
echo '">';
echo htmlspecialchars($movie->title);
echo '</a></td>';
//Trailer
echo '<td><a target="_blank" href="https://www.youtube.com/watch?v=';
echo $movie->yt_trailer_code;
echo '">Youtube Trailer</a></td>';
//WebRTC 
echo '<td><a target="_blank" href="http://movietrailer.byethost12.com/movietrailer/player/video_player.html?id=';
echo urlencode($movie->torrents[0]->url);
echo '">Watch</a></td>';
//Year
echo '<td>';
echo $movie->year;
echo '</td>';
//Length
echo '<td>';
echo $movie->runtime;
echo ' m</td>';
//Rating
echo '<td>';
echo $movie->rating;
echo '</td></tr>';
*/
endforeach;
echo '</body>';
echo '</html>';
?>