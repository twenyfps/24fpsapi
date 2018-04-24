<?php
define ( 'DIR', dirname ( __FILE__ ) );
class sqlitedb extends SQLite3 {
	var $dbfile = './RelaxingTime.sqlite';
	var $debug = false;
	function __construct($debug) {
		$this->debug = $debug;
		if ($this->debug) {
			echo ("<br>Open DB");
		}
		
		$this->open ( DIR . $this->dbfile );
	}
	
	/**
	 * Liste von Filmen
	 *
	 * @param Array $filters
	 *        	REQUEST-Suchfilter
	 * @return Array Filme
	 * @todo Sortierungsmöglichkeiten
	 */
	function getMovieList($filters = null, $limit) {
		if ($this->debug) {
			echo ("<br>getMovieList");
		}
		$sql = 'SELECT * FROM Movies ';
		if ($filters != null) {
			$sql = $sql . 'WHERE ' . $filters;
		}
		$sql = $sql . ' ORDER BY year DESC';
		if ($limit !== null) {
			$sql = $sql . ' LIMIT ' . $limit;
		}
		if ($this->debug == true) {
			echo ('<br>' . $sql);
		}
		return $this->results ( $sql );
	}
	/**
	 * Detail-Informationen eines Films
	 *
	 * @param Integer $imdb_id
	 *        	IMDb-ID
	 * @return Array Filmdaten
	 */
	function getSingleMovie($imdb_id) {
		if ($this->debug) {
			echo ("<br>getSingleMovie");
		}
		$movies = $this->results ( "SELECT * FROM Movies WHERE movie_id='" . $imdb_id . "'", array (
				'@imdb_id' => $imdb_id 
		) );
		$movie = $movies [0];
		return $movie;
	}
	
	/**
	 * SQLite-Wrapper für Queries mit Parametern
	 *
	 * @param String $sql
	 *        	SQL-Query mit ggf. Platzhaltern
	 * @param Array $placeholders
	 *        	assoziatives Array mit Platzhaltern und deren Datentypen
	 * @return Array Ergebnis der SQL-Abfrage
	 */
	public function results($sql, $placeholders = array()) {
		if ($this->debug) {
			echo ("<br>call results with " . $sql);
		}
		$query = $this->prepare ( $sql );
		foreach ( $placeholders as $key => $value ) {
			if (empty ( $value ) && $value != 0)
				$type = SQLITE3_NULL;
			else
				switch ($key {0}) {
					case '@' :
						$type = SQLITE3_INTEGER;
						break;
					case '#' :
						$type = SQLITE3_FLOAT;
						break;
					case '$' :
					default :
						$type = SQLITE3_TEXT;
						break;
				}
			$query->bindValue ( ':' . substr ( $key, 1 ), $value, $type );
		}
		$res = $query->execute ();
		$data = array ();
		if ($res)
			while ( $ds = $res->fetchArray ( SQLITE3_ASSOC ) )
				$data [] = $ds;
		return $data;
	}
}
?>    
