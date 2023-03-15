<?php
require_once 'connect.php';
require_once 'helper.php';

header('Content-Type: application/json; charset=utf-8');

$dataProducts = $mysql->query("SELECT * FROM product");

$product = [];

while ($item = $dataProducts->fetch_assoc()) {
    $product[] = [
        'id' => $item['id'],
        'title' => $item['title'],
        'volume' => $item['volume'],
        'price' => $item['price'],
    ];
}

$dataServices = $mysql->query("SELECT * FROM service");

$service = [];

while ($item = $dataServices->fetch_assoc()) {
    $service[] = [
        'id' => $item['id'],
        'title' => $item['title'],
        'description' => $item['description'],
        'price' => $item['price'],
        'img' => $item['img'],
    ];
}

$updateProducts = [$product, $service];

echo json_encode($updateProducts);
