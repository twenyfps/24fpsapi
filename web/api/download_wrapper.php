<?php
error_reporting ( E_ERROR | E_PARSE );

$link = urlencode ( $_GET ['link'] );
echo ($link);
$url = 'http://homegift.vn/testA/download.php?link=' . $link;
$curl = curl_init ( $url );
curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
$curl_response = curl_exec ( $curl );
curl_close ( $curl );
header ( 'Location: ' . $curl_response );
// print_r ( $curl_response );
?>