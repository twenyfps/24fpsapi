<?php
error_reporting ( E_ERROR | E_PARSE );

$imdb = $_GET ['imdb']; // 'the-outsider-2018';
$lang = $_GET ['lang'];
$title = urlencode($_GET ['title']); // 'the-outsider-2018';
$exact = urlencode($_GET ['exact']);

$link = 'http://homegift.vn/testA/search.php?title=' . $title . '&exact=' . $exact . '&imdb=' . $imdb . '&lang=' . $lang;
$curl = curl_init ( $link );
curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
$curl_response = curl_exec ( $curl );
curl_close ( $curl );
print_r ( $curl_response );

?>