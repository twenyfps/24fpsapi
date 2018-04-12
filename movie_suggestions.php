<?php

$sig = $_SERVER['HTTP_SIG'];
include 'sig_checker.php';
$sigCheck = sigCheck($sig);
if($sigCheck == true){
    $service_url = 'https://yts.am/api/v2/movie_suggestions.json';
    //movie_id		Integer (Unsigned)	null	The ID of the movie

    $movie_id = $_GET['movie_id'];
    $curl_post_data = array(
        "movie_id"=>$movie_id
    );
    $service_url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    curl_close($curl);
    print_r($curl_response);
    exit();
}else{
    $errorMsg = '{ "status": "error", "status_message": "Time not match, Please check your device time settings."}';
    echo $errorMsg;
    exit();
}
?>
