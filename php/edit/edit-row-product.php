<?php
require_once '../connect.php';

$operation = !empty($_POST['operation']) ? filter_var(trim($_POST['operation'])) : '';

$type = !empty($_POST['type']) ? filter_var(trim($_POST['type'])) : '';

$id = !empty($_POST['id']) ? filter_var(trim($_POST['id'])) : '';

$title = !empty($_POST['title']) ? filter_var(trim($_POST['title'])) : '';

$volume = !empty($_POST['volume']) ? filter_var(trim($_POST['volume'])) : '';

$price = !empty($_POST['price']) ? filter_var(trim($_POST['price'])) : '';

$description = !empty($_POST['description']) ? filter_var(trim($_POST['description'])) : '';

$img = !empty($_POST['img']) ? filter_var(trim($_POST['img'])) : '';

if ($operation === 'edit') {

    if ($type === 'products') {

        $result = $mysql->query("UPDATE product SET title = '$title', volume = '$volume', price = '$price' WHERE id = '$id'");
    }

    if ($type === 'services') {

        $result = $mysql->query("UPDATE service SET title = '$title', description = '$description', price = '$price', img = '$img' WHERE id = '$id'");
    }
}

if ($operation === 'delete') {

    if ($type === 'products') {

        $result = $mysql->query("DELETE FROM product WHERE id = '$id'");
    }

    if ($type === 'services') {

        $result = $mysql->query("DELETE FROM service WHERE id = '$id'");
    }
}

echo $result ? 'success' : 'false';
