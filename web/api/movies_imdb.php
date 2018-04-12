<?php
$sig = $_SERVER['HTTP_SIG'];
include 'sig_checker.php';
$sigCheck = sigCheck($sig);
if($sigCheck == true){
    $service_url = 'https://yts.ag/api/v2/list_movies.json';
    $query_term = $_GET['query_term'];
    $imdbs = explode(",", $query_term);
    class Data{
        var $movie_count;//": 1,
        var $limit;//": 20,
        var $page_number;//": 1,
        var $movies;//": [{
        function __construct() 
        {
            $this->movie_count = 0;
            $this->limit = 20;
            $this->page_number = 1;
            $this->movies = [];
        }
        function append($movie) 
        {
            $this->movie_count ++;
            array_push ( $this->movies, $movie);
        }
    }
    class Result {
        var $status;//": "ok",
        var $status_message;//": "Query was successful",
        var $data;
        function __construct() 
        {
            $this->status="ok";
            $this->status_message="Query was successful";
            $this->data = new Data();
        }
        function appendMovie($movie) 
        {
            return $this->data->append($movie);
        }
    }
    $result = new Result();
    foreach ($imdbs as $imdb) 
    { // each part
        $curl_post_data = array(
            "query_term"=>$imdb
        );
        $url = sprintf("%s?%s", $service_url, http_build_query($curl_post_data));
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $imdbResult = json_decode($curl_response);
        $status = $imdbResult->status;
        $data = $imdbResult->data;
        $movies = $data->movies;
        if($data->movie_count > 0)
        {
            foreach ($movies as $movie) 
            {
                $result->appendMovie($movie);
            }
        }
    }
    echo json_encode($result);
    exit();
}else{
    $errorMsg = '{ "status": "error", "status_message": "Time not match, Please check your device time settings."}';
    echo $errorMsg;
    exit();
}
?>
