<?php
header ( "Content-type: application/json; charset=utf-8" );
$result = file_get_contents('./update.json');
echo $result;
?>