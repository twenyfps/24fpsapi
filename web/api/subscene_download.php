<?php
error_reporting ( E_ERROR | E_PARSE );

$link = url_decode ( $_GET ['url'] ); // $link = 'https://subscene.com/subtitles/the-outsider-2018/arabic/1732879';
$page = file_get_contents ( $link );
$dom = new DOMDocument ( '1.0', 'UTF-8' );
$dom->loadHTML ( $page );
$lis = $dom->getElementsByTagName ( 'li' );
foreach ( $lis as $li ) {
	if ($li->hasAttribute ( 'class' )) {
		$li_class = trim ( $li->getAttribute ( 'class' ) );
		if ($li_class === 'clearfix') {
			$divs = $li->getElementsByTagName ( 'div' );
			foreach ( $divs as $div ) {
				if ($div->hasAttribute ( 'class' )) {
					$div_class = trim ( $div->getAttribute ( 'class' ) );
					if ($div_class === 'download') {
						$div_a = $div->getElementsByTagName ( 'a' ) [0];
						$href = 'https://subscene.com' . trim ( $div_a->getAttribute ( 'href' ) );
						header ( 'Location: ' . $href );
					}
				}
			}
		}
	}
}
?>