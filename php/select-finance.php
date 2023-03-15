<?php

require_once 'connect.php';
require_once 'helper.php';

header('Content-Type: application/json; charset=utf-8');

$period = !empty(($_POST['period'])) ? filter_var(trim($_POST['period'])) : '';

$firstDate = !empty($_POST['firstDate']) ? filter_var(trim($_POST['firstDate'])) : '';

$lastDate = !empty($_POST['lastDate']) ? filter_var(trim($_POST['lastDate'])) : '';

switch ($period) {

    case 'За все время':

        $query = "SELECT * FROM finance ORDER BY date DESC";
        break;

    case 'За последний месяц':

        $query = "SELECT * FROM finance WHERE date> NOW() - INTERVAL 1 MONTH ORDER BY date DESC";
        break;

    case 'За последний день':
        $query = "SELECT * FROM finance WHERE date> NOW() - INTERVAL 1 DAY ORDER BY date DESC";
        break;

    case 'За период с':

        $query = "SELECT * FROM finance WHERE date BETWEEN '$firstDate' AND '$lastDate' ORDER BY date DESC";
        break;

    default:

        $query = "SELECT * FROM finance ORDER BY date DESC";
}

$dataFinance = $mysql->query($query);

$finance = [];

while ($item = $dataFinance->fetch_assoc()) {

    $finance[] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'quantity' => $item['quantity'],
        'price' => $item['price'],
        'date' => $item['date'],
        'type' => $item['type']
    ];
}

echo json_encode($finance);
