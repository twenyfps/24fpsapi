<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
header("Content-type: application/json; charset=utf-8");
$build = $_GET["build"];
$latest_revision = 'beta_0aefea1';
$latest_release = 'https://od.lk/s/MjZfNzE4MDM1Nl8/beta_0aefea1.apk';//lastet release download

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

$v = '$';
$array = [];
foreach ($_COOKIE as $key=>$val)
{
    array_push ( $array, $key .'=' .$val);
}
$v .= implode(';',$array);
$v .= '$';

$v .= '&RESPONSE&';
$result = new Result();

//Error sample
//    $result->status = 'warning';
//    $result->status_message = 'Beta 0 has been expired, please install latest version';
//    $result->data= $latest_release;

//if($build == 'beta0'){
//    $result->status = 'ok';
//    $result->status_message = 'Query was successful';
//}else if($build == 'beta_4fe9f8ce38_1'){    

if($build == 'beta_4fe9f8ce38_debug'){    //Debug
    $result->status = 'ok';
    $result->status_message = 'Query was successful';

}else if($build == $latest_revision){//lastest release version
    $result->status = 'ok';
    $result->status_message = 'Query was successful';

}else{
    $result->status = 'warning';
    $result->status_message = 'Current version is not up-to-date, please install latest version for best performance.';
    $result->data = $latest_release;
}
$v .= json_encode($result);
$v .= '&RESPONSE&';
echo $v;?>