<?php
define('DB_HOST', 'sql112.byethost12.com');
define('DB_USER', 'b12_20928819');
define('DB_PASS', 'Duy2809Khang0712');
define('DB_NAME', 'b12_20928819_my_movies');
define('DB_PREFIX', '');

// define('TBL_MOVIES', 'movies');
// CREATE TABLE `b12_20928819_my_movies`.`movies` (
// `$imdb_code` VARCHAR( 16 ) NOT NULL ,
// `title` VARCHAR( 256 ) NOT NULL ,
// `year` INT NOT NULL ,
// `runtime` INT NOT NULL ,
// `rating` INT NOT NULL ,
// `language` VARCHAR( 16 ) NOT NULL ,
// `mpa_rating` VARCHAR( 16 ) NOT NULL ,
// `poster` VARCHAR( 1024 ) NOT NULL ,
// `cover` VARCHAR( 1024 ) NOT NULL ,
// `genres` SET( 'Action', 'Adventure', 'Animation', 'Biography', 'Comedy', 'Crime', 'Documentary', 'Drama', 'Family', 'Fantasy', 'Film-Noir', 'Game-Show', 'History', 'Horror', 'Music', 'Musical', 'Mystery', 'News', 'Reality-TV', 'Romance', 'Sci-Fi', 'Sport', 'Talk-Show', 'Thriller', 'War', 'Western', 'Porn' ) NOT NULL ,
// `trailer` VARCHAR( 64 ) NOT NULL ,
// PRIMARY KEY ( `$imdb_code` )
// ) ENGINE = MYISAM ;

// define('TBL_TORRENTS', 'torrents');
// CREATE TABLE `b12_20928819_my_movies`.`torrents` (
// `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
// `quality` VARCHAR( 8 ) NOT NULL ,
// `size` BIGINT NOT NULL ,
// `hash` VARCHAR( 64 ) NOT NULL
// ) ENGINE = MYISAM ;

// define('TBL_USER', '#__users');
// define('TBL_DEVICES', '#__devices');
// define('TBL_ONLINES', '#__onlines');
class MDB
{

    public function __construct()
    {
        $this->conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);
        // or die('Could not connect: ' . mysql_error());
        if ($this->conn != null) {
            // echo 'Connect DB success';
            if (mysql_select_db(DB_NAME, $this->conn) == true) {
                // echo 'Select DB success';
            } else {
                echo 'Could not select database';
            }
        } else {
            echo 'Could not connect: ' . mysql_error();
        }
        return;
    }

    private function querySELECT($query)
    {
        return mysql_query($query, $this->conn);
    }

    private function queryINSERT($query)
    {
        mysql_query($query, $this->conn);
        return mysql_insert_id();
    }

    private function queryUPDATE($query)
    {
        $query = vsprintf($query, $args);
        return mysql_query($query, $this->conn);
    }

    public function movie_count($query_term, $genre)
    {
        if (is_null($query_term) == false) {
            $query = "SELECT count(*) " . "FROM `movies` " . "WHERE `title` LIKE '%" . $query_term . "%'";
            $result = $this->querySELECT($query);
        } else {
            $query = "SELECT count(*) " . "FROM `movies` " . "WHERE `genres` LIKE '%" . $genre . "%'";
            $result = $this->querySELECT($query);
        }
        return mysql_num_rows($result);
    }

    public function movie_list($limit, $page, $query_term, $genre, $sort_by, $order_by)
    {
        // `limit`, `page`, `sort_by` and `order_by` always present
        // `query_term` and `genre` maybe present but not at the same time
        $result = null;
        $offset = (intval($page) - 1) * intval($limit);
        if ($offset < 0) {
            $offset = 0;
        }
        if (is_null($query_term) == false) {
            $query = "SELECT *" . " FROM `movies`" . " WHERE `title` LIKE '%" . $query_term . "%'" . " ORDER BY `" . $sort_by . "` " . $order_by . " LIMIT " . strval($offset) . "," . $limit;
            $result = $this->querySELECT($query);
        } else {
            $query = "SELECT *" . " FROM `movies`" . " WHERE `genres` LIKE '%" . $genre . "%' " . " ORDER BY `" . $sort_by . "` " . $order_by . " LIMIT " . strval($offset) . "," . $limit;
            $result = $this->querySELECT($query);
        }
        
        if (mysql_num_rows($result) == 0) {
            return 'movie_list error';
        } else {
            $toreturn = array();
            while ($row = mysql_fetch_array($result))
                $toreturn[] = $row;
            return $toreturn;
        }
    }

    /**
     * Movies section
     */
    /**
     * all parameter must be string
     */
    public function insertMovie($imdb_code, $title, $year, $runtime, $language, $rating, $genres, $trailer, $torrents)
    {
        $this->queryINSERT('INSERT INTO `%s` (`imdb_code`, `title`, `year`, `runtime`, `language`, `rating`, `genres`, `trailers`, `torrents`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)', array(
            TBL_MOVIES,
            $imdb_code,
            $title,
            $year,
            $runtime,
            $language,
            $rating,
            $genres,
            $trailers,
            $torrents
        ));
        return mysql_affected_rows($this->conn) == 1;
    }

    public function editMovie($imdb_code, $column, $value)
    {
        if (! is_numeric($id) || ! is_numeric($rating))
            return false;
        $this->queryUPDATE("UPDATE `%s` SET `%s`=`%s` WHERE `imdb_code`='%s'", array(
            TBL_MOVIES,
            $column,
            $value,
            $imdb_code
        ));
        return mysql_affected_rows($this->conn) == 1;
    }

    public function insertTorrent($quality, $size, $hash)
    {
        $insertId = $this->queryINSERT('INSERT INTO `%s` (`quality`, `size`, `hash`) VALUES (%s, %s, %s)', array(
            TBL_TORRENTS,
            $quality,
            $size,
            $hash
        ));
        return $insertId;
    }

    public function editTorrent($id, $column, $value)
    {
        if (! is_numeric($id) || ! is_numeric($rating))
            return false;
        $this->queryUPDATE("UPDATE `%s` SET `%s`='%s'' WHERE `id`=%s", array(
            TBL_TORRENTS,
            $column,
            $value,
            $id
        ));
        return mysql_affected_rows($this->conn) == 1;
    }

    public function deleteMovie($imdb_code)
    {
        if (! is_numeric($id))
            return false;
        $this->queryDELETE("DELETE FROM `%s` WHERE `id`='%s'", array(
            TBL_MOVIES,
            $imdb_code
        ));
        return true;
    }
/**
 * Users section
 */
/**
 * Devices section
 */
}
?>    