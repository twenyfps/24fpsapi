<?php
require_once ('./db.php');
$db = new MDB();

$limit = $_GET['limit'];
$page = $_GET['page'];
$action = $_GET['action'];
$sort_by = $_GET['sort_by'];
$order_by = $_GET['order_by'];
$genre = $_GET['genre'];
$query_term = $_GET['query_term'];

$movies = null;

if (is_null($genre) == true) {
    $genre = '';
}
if (is_null($query_term) == true) {
    $query_term = '';
}
if (is_null($limit) == true) {
    $limit = '50';
}
if (is_null($page) == true) {
    $page = '1';
}
if (is_null($order_by) == true) {
    $order_by = 'DESC';
}
if (is_null($sort_by) == true) {
    $sort_by = 'title';
}
if ($action == 'count') {
    $movies = $db->movie_count($query_term, $genre);
    echo json_encode($movies);
} else {
    $movies = $db->movie_list($limit, $page, $query_term, $genre, $sort_by, $order_by);
}
if ($movies != null) {
    echo json_encode($movies);
} else {
    echo 'error';
}

$db->close();
?>    