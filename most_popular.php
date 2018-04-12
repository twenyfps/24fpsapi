<?php

$sig = $_SERVER['HTTP_SIG'];
include 'sig_checker.php';
include 'pt2mt.php';
$sigCheck = sigCheck($sig);
header('Content-Type: application/json');

if($sigCheck == true){
    $limit = $_GET['limit'];
    $page = $_GET['page'];
    $quality = $_GET['quality'];
    $minimum_rating = $_GET['minimum_rating'];
    $query_term = $_GET['query_term'];
    $genre = $_GET['genre'];
    $sort_by = $_GET['sort_by'];
    $order_by = $_GET['order_by'];
    $with_rt_ratings = $_GET['with_rt_ratings'];

    if(strtolower($genre) == 'tv_shows'){
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
        $mtResult = '(';
        $MovieList = $ptResult->MovieList;
        $count = 0;
        foreach ($MovieList as $movie){
            if(property_exists($movie, 'imdb') == true){ 
                if($count == 0){
                    $mtResult = $mtResult ."'" .$movie->imdb ."'";
                }else{
                    $mtResult = $mtResult .",'" .$movie->imdb ."'";
                }
                 $count++;
            }
        }
        $mtResult = $mtResult .')';
        echo $mtResult;
        
    }else if(strtolower($genre) == 'pt'){
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
        $mtResult = '(';
        $MovieList = $ptResult->MovieList;
        $count = 0;
        foreach ($MovieList as $movie){
            if(property_exists($movie, 'imdb') == true){ 
                if($count == 0){
                    $mtResult = $mtResult ."'" .$movie->imdb ."'";
                }else{
                    $mtResult = $mtResult .",'" .$movie->imdb ."'";
                }
                 $count++;
            }
        }
        $mtResult = $mtResult .')';
        echo $mtResult;
        
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
