<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
header("Content-type: application/json; charset=utf-8");
$type = $_GET["type"];//mobile, tablet, tv
$build = $_GET["build"];
$latest_version_mobile = 'beta_0aefea1';
$latest_version_tablet = 'beta_0aefea1';
$latest_version_tv = 'beta_0aefea1';

$latest_release_mobile = 'https://od.lk/s/MjZfNzE4MDM1Nl8/beta_0aefea1.apk';//lastet release download
$latest_release_tablet = 'https://od.lk/s/MjZfNzE4MDM1Nl8/beta_0aefea1.apk';//lastet release download
$latest_release_tv = 'https://od.lk/s/MjZfNzE4MDM1Nl8/beta_0aefea1.apk';//lastet release download
$available_genres = 'action;adventure;animation;biography;comedy;crime;documentary;drama;family;fantasy;history;horror;musical;mystery;news;romance;sci-fi;sport;thriller;war;western';
//$available_genres = 'action;adventure;animation;biography;comedy;crime;documentary;drama;family;fantasy;history;horror;musical;mystery;news;romance;sci-fi;sport;thriller;war;western;tv shows;anime';
//$available_genres = 'action;adventure;animation;biography;comedy;crime;documentary;drama;family;fantasy;history;horror;musical;mystery;news;romance;sci-fi;sport;thriller;war;western;tv shows';
//$available_genres = 'action;adventure;animation';
class Result {
    var $status;//": "ok",
    var $status_message;//": "Query was successful",
    var $data;
    function __construct() 
    {
        $this->status = 'ok';
        $this->status_message = 'Query was successful';
        $this->data = '';
    }
}

$result = new Result();

//Error sample
//    $result->status = 'warning';
//    $result->status_message = 'Beta 0 has been expired, please install latest version';
//    $result->data= $latest_release;

//if($build == 'beta0'){
//    $result->status = 'ok';
//    $result->status_message = 'Query was successful';
//}else if($build == 'beta_4fe9f8ce38_1'){    

if($type == 'mobile'){
    if($build == $latest_version_mobile){
        $result->status = 'ok';
        $result->status_message = 'Query was successful';
    }else{
        $result->status = 'warning';
        $result->status_message = 'Current version is not up-to-date, please install latest version for best performance.';
        $result->data = $latest_release_mobile;
    }
} else if($type == 'tablet'){
    if($build == $latest_version_tablet){
        $result->status = 'ok';
        $result->status_message = 'Query was successful';
        $result->data = $available_genres;

    }else{
        $result->status = 'warning';
        $result->status_message = 'Current version is not up-to-date, please install latest version for best performance.';
        $result->data = $latest_release_tablet;
    }
} else if($type == 'tv'){
    if($build == $latest_version_tv){
        $result->status = 'ok';
        $result->status_message = 'Query was successful';
        $result->data = $available_genres;
    }else{
        $result->status = 'warning';
        $result->status_message = 'Current version is not up-to-date, please install latest version for best performance.';
        $result->data = $latest_release_tv;
    }
}else{
    $result->status = 'error';
    $result->status_message = 'Invalid params!';
}

echo json_encode($result);
?>