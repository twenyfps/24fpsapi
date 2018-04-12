<?php
class Torrent {
    public $hash;//":"D34584A9280669C76BA7C1D58FE0FDFDC0C282C4",
    public $quality;//":"720p",
    public $seeds;//":949,
    public $peers;//":1246,
    public $size;//":"919.74 MB",
    public $size_bytes;
    public $date_uploaded_unix;//":1509153605
    function __construct(
        $hash,
        $quality,
        $seeds,
        $peers,
        $size,
        $size_bytes,
        $date_uploaded_unix)
    {
        $this->hash = $hash;
        $this->quality = $quality;
        $this->seeds = $seeds;
        $this->peers = $peers;
        $this->size =$size;
        $this->size_bytes = $size_bytes;
        $this->date_uploaded_unix = $date_uploaded_unix;
    }
}
class Movie {
    public $id;
    public $imdb_code;
    public $title_long;
    public $year;
    public $rating;
    public $runtime;
    public $genres;//Array String 
    public $summary;
    public $description_full;
    public $yt_trailer_code;
    public $language;
    public $background_image_original;
    public $medium_cover_image;
    public $torrents;//Array Torrent 
    public $mpa_rating;
    public $series;
    public $season;
    public $episode;
    function __construct(
        $id,
        $imdb_code,
        $title_long,
        $year,
        $rating,
        $runtime,
        $genres,
        $summary,
        $description_full,
        $yt_trailer_code,
        $language,
        $background_image_original,
        $medium_cover_image,
        $mpa_rating,
        $series,
        $season,
        $episode) 
    {
        $this->id = $id;
        $this->imdb_code = $imdb_code;
        $this->title_long = $title_long;
        $this->year = $year;
        $this->rating = $rating;
        $this->runtime = $runtime;
        $this->genres = $genres;
        $this->summary = $summary;
        $this->description_full = $description_full;
        $this->yt_trailer_code = $yt_trailer_code;
        $this->language = $language;
        $this->background_image_original = $background_image_original;
        $this->medium_cover_image = $medium_cover_image;
        $this->mpa_rating = $mpa_rating;
        $this->series = $series;
        $this->season = $season;
        $this->episode = $episode;
        $this->torrents = [];
    }
    function addTorrent($torrent){
        array_push ( $this->torrents , $torrent);
    }
}
class Data{
    public $id;
    public $movie_count;
    public $limit;
    public $page_number;
    public $movies;//Array Movie
    function __construct() {
        $this->movie_count = 0;
        $this->limit = 30;
        $this->page_number = 1;
        $this->movies = [];
    }
    function addMovie($movie){
        $this->movie_count ++;
        array_push ( $this->movies , $movie);
    }
}
class MTResult {
    public $status;//": "ok",
    public $status_message;//": "Query was successful",
    public $data;//": {
    function __construct() {
        $this->status = 'ok';
        $this->status_message='Query was successful';
        $this->data = new Data();
    } 
}
class SeasonResult {
    public $status;//": "ok",
    public $status_message;//": "Query was successful",
    public $data;//": {
    function __construct() {
        $this->status = 'ok';
        $this->status_message='Query was successful';
        $this->data = [];
    } 
    function addSeason($season){
        array_push ( $this->data , $season);
    }
}
function pt2mtResult($ptResult, $series){
    //print_r($result);
    $MovieList = $ptResult->MovieList;
    $mtResult = new MTResult();
    foreach ($MovieList as $movie){
        //print_r($curl_response);
        $torrents = null;
        if(property_exists($movie, 'items') == true){ 
            $torrents = $movie->items;
        }
        $mtMovie = new Movie(
            $movie->id,
            $movie->imdb,
            $movie->title,
            $movie->year,
            $movie->rating,
            0,
            $movie->genres,
            '',
            $movie->description,
            $movie->trailer,
            '',
            '',
            $movie->poster_med,
            '',
            $series,
            '',
            '');
        $valid = false;
        if($torrents != null && sizeof($torrents) > 0){
            foreach ($torrents as $torrent){
                if($torrent->size_bytes < 2500000000){
                    $mtMovie->addTorrent(new Torrent(
                        $torrent->id,
                        $torrent->quality,
                        $torrent->torrent_seeds,
                        $torrent->torrent_peers,
                        '',
                        $torrent->size_bytes,
                        0
                    ));
                    $valid = true;
                }
            }
            
        }
        if($valid == true){
            $mtResult->data->addMovie($mtMovie);
        }
    }
    return $mtResult;
}
function pt2mtMovie($ptMovie){
    $torrents = null;
    if(property_exists($ptMovie, 'items') == true){ 
        $torrents = $ptMovie->items;
    }
    $episodeId = $ptMovie->id;
    $episodeId = str_replace("_", "", $episodeId);
    $episodeId = str_replace("-", "", $episodeId);
    $mtMovie = new Movie(
        $episodeId,
        $ptMovie->imdb,
        $ptMovie->title,
        $ptMovie->year,
        $ptMovie->rating,
        0,
        $ptMovie->genres,
        '',
        $ptMovie->synopsis,
        $ptMovie->trailer,
        '',
        '',
        $ptMovie->poster_med,
        '',
        false,
        $ptMovie->season,
        $ptMovie->episode
        );
    $valid = false;
    if($torrents != null && sizeof($torrents) > 0){
        foreach ($torrents as $torrent){
            if($torrent->size_bytes < 2500000000){
                $mtMovie->addTorrent(new Torrent(
                    $torrent->id,
                    $torrent->quality,
                    $torrent->torrent_seeds,
                    $torrent->torrent_peers,
                    '',
                    $torrent->size_bytes,
                    0
                ));
                $valid = true;
            }
        }
        
    }
    if( $valid == true){
        return $mtMovie;
    }else{
        return null;
    }
}
?>