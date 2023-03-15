<?php
require_once 'connect.php';
require_once 'helper.php';

header('Content-Type: application/json; charset=utf-8');

$dataApplication = $mysql->query("SELECT * FROM application");

$application = [];

while ($item = $dataApplication->fetch_assoc()) {

    $application[] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'tel' => $item['tel'],
        'mail' => $item['mail'],
        'text' => $item['text'],
        'date' => $item['date'],
    ];
}

$dataReview = $mysql->query("SELECT * FROM review");

$review = [];

while ($item = $dataReview->fetch_assoc()) {

    $review[] = [
        'id' => $item['id'],
        'review' => $item['review'],
        'name' => $item['name'],
        'mail' => $item['mail'],
        'date' => $item['date'],
    ];
}

$clients = [$application, $review];

echo json_encode($clients);
