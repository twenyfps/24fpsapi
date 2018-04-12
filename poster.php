<?php
    //header('Content-Type: application/json');
    //http://www.omdbapi.com/?i=tt3896198&apikey=5f7d3710
    $imdb = $_GET['imdb'];
    $link = "http://www.omdbapi.com/?i=" .$imdb ."&apikey=5f7d3710";
    $page = file_get_contents($link);
    //print_r($page);
    $detail = json_decode($page);   
    $poster = $detail->Poster;
    header('Location: ' .$poster);
      //"Poster": "https://images-na.ssl-images-amazon.com/images/M/MV5BMTg2MzI1MTg3OF5BMl5BanBnXkFtZTgwNTU3NDA2MTI@._V1_SX300.jpg",

    //$provider = urldecode($_GET["provider"]);
    //Test
    //$link = "https://www.podnapisi.net/subtitles/en-222-2014/IYVE";
    //$provider = 'podnapisi.net';
    //if($provider == 'yifysubtitles.com'){
    //    $page = file_get_contents($link);
    //   if(preg_match('<a class="btn-icon download-subtitle" href="(.*?)">', $page, $download)) {
    //        header('Location: ' .$download[1]);
    //    }
    //}else if($provider == 'subscene.com'){
    //    $page = file_get_contents($link);
    //    if(preg_match('/<div class="download">.*?<a href="(.*?)" rel="nofollow" onclick="DownloadSubtitle\(this\)" id="downloadButton" class="button positive">.*?Download /s', $page, $download)) {
    //        header('Location: https://subscene.com' .$download[1]);
    //    }
    //}else if($provider == 'podnapisi.net'){        
    //    header('Location: ' .$link .'/download');
    //}else{
    //    exit($provider);
    //}    
?>
