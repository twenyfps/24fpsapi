<?php

$sig = $_SERVER['HTTP_SIG'];
include 'sig_checker.php';
include 'pt2mt.php';
$sigCheck = sigCheck($sig);
header('Content-Type: application/json');

if($sigCheck == true){
    $service_url = 'https://yts.am/api/v2/list_movies.json';
    //limit			Integer 	between 1 - 50 (inclusive)										20			The limit of results per page that has been set
    //page			Integer 	(Unsigned)													1			Used to see the next page of movies, eg limit=15 and page=2 will show you movies 15-30
    //quality			String 	(720p, 1080p, 3D)												All			Used to filter by a given quality
    //minimum_rating	Integer 	between 0 - 9 (inclusive)											0			Used to filter movie by a given minimum IMDb rating
    //query_term		String																0			Used for movie search, matching on: Movie Title/IMDb Code, Actor Name/IMDb Code, Director Name/IMDb Code
    //genre			String																All			Used to filter by a given genre (See http://www.imdb.com/genre/ for full list)
    //sort_by			String 	(title, year, rating, peers, seeds, download_count, like_count, date_added)	date_added	Sorts the results by choosen value
    //order_by		String 	(desc, asc)													desc		Orders the results by either Ascending or Descending order
    //with_rt_ratings	Boolean																false		Returns the list with the Rotten Tomatoes rating included
    //Action	Adventure	Animation	Biography
    //Comedy	Crime	Documentary	Drama
    //Family	Fantasy	Film-Noir	Game-Show
    //History	Horror	Music	Musical
    //Mystery	News	Reality-TV	Romance
    //Sci-Fi	Sport	Talk-Show	Thriller
    //War	Western
    $limit = $_GET['limit'];
    $page = $_GET['page'];
    $quality = $_GET['quality'];
    $minimum_rating = $_GET['minimum_rating'];
    $query_term = $_GET['query_term'];
    $genre = $_GET['genre'];
    $sort_by = $_GET['sort_by'];
    $order_by = $_GET['order_by'];
    $with_rt_ratings = $_GET['with_rt_ratings'];

    if(strtolower($genre) == 'adults'){
        //TODO
        $service_url = 'https://od.lk/s/MjZfNzE5NzQ5M18/adults.txt';
        $content = file_get_contents($service_url);
        echo $content;

    }else if(strtolower($genre) == 'korean_drama'){
        $service_url = 'https://od.lk/s/MjZfNzE5NzQ5NF8/korean_drama.txt';
        $content = file_get_contents($service_url);
        echo $content;

    }else if(strtolower($genre) == 'anime_show'){
        //TODO

    }else if(strtolower($genre) == 'anime'){
        $curl_post_data = array(
        "app_id"=>"T4P_AND",
        "sort"=>"seeds",
        "count"=>$limit,
        "page"=>$page,
        "quality"=>"720p",
        "os"=>"ANDROID",
        "ver"=>"3.0.0"
        );
        if($query_term != null || strlen($query_term) > 0){
            $curl_post_data["keywords"]=$query_term;
        }
        $service_url = 'http://api.anime.apiumando.info/list';
        $service_url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $ptResult = json_decode($curl_response);
        $mtResult = pt2mtResult($ptResult, "false");
        echo json_encode($mtResult);

    }else if(strtolower($genre) == 'tv_shows'){
        $curl_post_data = array(
        "count"=>$limit,
        "page"=>$page,
        "quality"=>"720p,1080p",
        "genre"=>"all",
        "sort"=>$sort_by,
        "app_id"=>"T4P_AND",
        "os"=>"ANDROID",
        "ver"=>"3.0.0"
        );
        if($query_term != null || strlen($query_term) > 0){
            $curl_post_data["keywords"]=$query_term;
        }
        $service_url = 'http://api.apiumando.info/shows';
        $service_url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $ptResult = json_decode($curl_response);
        $mtResult = pt2mtResult($ptResult, "true");
        echo json_encode($mtResult);
        
    }else if(strtolower($genre) == 'pt'){
        //http://api.apiumando.info/list?app_id=T4P_AND&genre=all&sort=year&page=1&quality=480p,720p,1080p&ver=3.0.0&os=ANDROID
        
        $curl_post_data = array(
        "count"=>$limit,
        "page"=>$page,
        "quality"=>"720p,1080p",
        "genre"=>"all",
        "sort"=>$sort_by,
        "app_id"=>"T4P_AND",
        "os"=>"ANDROID",
        "ver"=>"3.0.0"
        );
        if($query_term != null || strlen($query_term) > 0){
            $curl_post_data["keywords"]=$query_term;
        }
        $service_url = 'http://api.apiumando.info/list';
        $service_url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $ptResult = json_decode($curl_response);
        $mtResult = pt2mtResult($ptResult, "false");
        echo json_encode($mtResult);
        
    }else{
         $curl_post_data = array(
        "limit"=>$limit,
        "page"=>$page,
        "quality"=>"720p",
        "minimum_rating"=>0,
        "query_term"=>$query_term,
        "genre"=>$genre,
        "sort_by"=>$sort_by,
        "order_by"=>$order_by,
        "with_rt_ratings"=>"false"
        );
        $service_url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        print_r($curl_response);
    }
    exit();
}else{
    $errorMsg = '{ "status": "error", "status_message": "Time not match, Please check your device time settings."}';
    echo $errorMsg;
    exit();
}
?>
