<?php
header('Content-Type: application/json');
if(isset($_GET["link"])) {
    $link = urldecode($_GET["link"]);
    $provider = urldecode($_GET["provider"]);
    //Test
    //$link = "https://www.podnapisi.net/subtitles/en-222-2014/IYVE";
    //$provider = 'podnapisi.net';
    if($provider == 'yifysubtitles.com'){
        $page = file_get_contents($link);
        if(preg_match('<a class="btn-icon download-subtitle" href="(.*?)">', $page, $download)) {
            header('Location: ' .$download[1]);
        }
    }else if($provider == 'subscene.com'){
        $page = file_get_contents($link);
        if(preg_match('/<div class="download">.*?<a href="(.*?)" rel="nofollow" onclick="DownloadSubtitle\(this\)" id="downloadButton" class="button positive">.*?Download /s', $page, $download)) {
            header('Location: https://subscene.com' .$download[1]);
        }
    }else if($provider == 'podnapisi.net'){        
        header('Location: ' .$link .'/download');
    }else{
        exit($provider);
    }
}else if(isset($_GET["link"])) {
    
}
exit('{"error":"parameters is required"}');
?>
