<?php
$sig = $_SERVER['HTTP_SIG'];
include 'sig_checker.php';
include 'pt2mt.php';

$sigCheck = sigCheck($sig);
if($sigCheck == true){
    $movie_id = $_GET['movie_id'];
    
    $service_url = 'http://api.apiumando.info/show?app_id=T4P_AND&quality=720p,1080p&ver=3.0.0&os=ANDROID&imdb=' .$movie_id;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($curl_response);
    $properties =  get_object_vars ( $result );
    $seasons = array_keys($properties);
    $season_result = new SeasonResult();
    foreach($seasons as $season){
        $movies = $properties[$season];
        $ss = new Data();
        $ss->id = $season;
        foreach($movies as $movie){
            $mv = pt2mtMovie($movie);
            $ss->addMovie($mv);
        }
        $season_result->addSeason($ss);   
    }
    echo json_encode(    $season_result);
}else{
    $errorMsg = '{ "status": "error", "status_message": "Time not match, Please check your device time settings."}';
    echo $errorMsg;
    exit();
}
//http://api.apiumando.info/show?app_id=T4P_AND&imdb=tt5675620&quality=720p,1080p&ver=3.0.0&os=ANDROID
?>
