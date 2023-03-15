<?php
require_once 'connect.php';
require_once 'helper.php';

header('Content-Type: application/json; charset=utf-8');

$results = $mysql->query("SELECT * FROM review ORDER BY id DESC");

$reviews = [];

for($i = 0; $i < 3; $i++) {
    $review = $results->fetch_assoc();
    $reviews[] = [
        'id' =>  $review['id'],
        'name' => limitSymbol($review['name'], 64),
        'message' => limitSymbol($review['review'], 255),
    ];
}
echo json_encode($reviews);
