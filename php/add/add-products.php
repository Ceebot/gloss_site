<?php
require_once "../connect.php";

$typeName = !empty($_POST['typeName']) ? filter_var(trim($_POST['typeName'])) : '';

$name = !empty($_POST['name']) ? filter_var(trim($_POST['name'])) : '';

$volume = !empty($_POST['volume']) ? filter_var(trim($_POST['volume'])) : '';

$price = !empty($_POST['price']) ? filter_var(trim($_POST['price'])) : '';

$description = !empty($_POST['description']) ? filter_var(trim($_POST['description'])) : '';

$img = !empty($_POST['img']) ? filter_var(trim($_POST['img'])) : '';

if ($typeName === 'products')
    $result = $mysql->query("INSERT INTO product (title, volume, price) VALUES ('$name', '$volume', '$price')");

if ($typeName === 'services')
    $result = $mysql->query("INSERT INTO service (title, description, price, img) VALUES ('$name', '$description', '$price', '$img')");

echo $result ? 'success' : 'false';
