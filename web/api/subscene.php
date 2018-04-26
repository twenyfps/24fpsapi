<?php
error_reporting ( E_ERROR | E_PARSE );
class Subtitle {
	public $name;
	public $href;
	function __construct($name, $href) {
		$this->name = $name;
		$this->href = $href;
	}
}
class Subtitles {
	public $language;
	public $subtitles;
	function __construct() {
		$this->language = '';
		$this->subtitles = [ ];
	}
	function addSubtitle($subtitle) {
		array_push ( $this->subtitles, $subtitle );
	}
}

$imdb = $_GET ['imdb']; // 'tt2011311';
$title = $_GET ['title']; // 'the-outsider-2018';

$link = 'https://subscene.com/subtitles/' . $title;
$page = file_get_contents ( $link );
$re = '/tt([0-9])+/';

preg_match_all ( $re, $page, $matches, PREG_SET_ORDER, 0 );
$match = $matches [0] [0];
// require ('phpQuery.php');

if ($match === $imdb) {
	// echo ('Match! ' . $match);
	$dom = new DOMDocument ( '1.0', 'UTF-8' );
	$dom->loadHTML ( $page );
	$table = $dom->getElementsByTagName ( 'table' ) [0];
	$tableBody = $table->getElementsByTagName ( 'tbody' ) [0];
	$rows = $table->getElementsByTagName ( 'tr' );
	$all_subtitles = [ ];
	$subtitles = null;
	foreach ( $rows as $row ) {
		$cols = $row->getElementsByTagName ( 'td' );
		foreach ( $cols as $col ) {
			// <td colspan="5" class="language-start" id="brazillian-portuguese"></td>
			if ($col->hasAttribute ( 'class' )) {
				$col_class = trim ( $col->getAttribute ( 'class' ) );
				if ($col_class === 'language-start') {
					// neu truoc do da language_start thi add $subtitle va bat dau $subtitle moi
					if ($subtitles !== null) {
						array_push ( $all_subtitles, $subtitles );
					}
					$language = trim ( $col->getAttribute ( 'id' ) );
					if (strlen ( $language ) > 0) {
						$subtitles = new Subtitles ();
						$subtitles->language = $language;
					}
				} else if ($col_class === 'a1') {
					$a = $col->getElementsByTagName ( 'a' ) [0];
					$href = null;
					$name = null;
					if ($a->hasAttribute ( 'href' )) {
						$href = 'https://subscene.com' . trim ( $a->getAttribute ( 'href' ) );
					}
					$span = $a->getElementsByTagName ( 'span' ) [1];
					
					if ($span !== null) {
						$name = trim ( $span->textContent, " \t\n\r\0\x0B" );
						// $name = trim ( $a->ownerDocument->saveHTML ( $span ) );
					}
					$subtitles->addSubtitle ( new Subtitle ( $name, $href ) );
				}
			}
		}
	}
	echo json_encode ( $all_subtitles );
} else {
	echo ('Not match! ' . $match);
}
?>