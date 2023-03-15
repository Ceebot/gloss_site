<?php

require_once "../connect.php";

$name = filter_var(trim($_POST['name']));
$quantity = filter_var(trim($_POST['quantity']));
$price = filter_var(trim($_POST['price']));
$date = filter_var(trim($_POST['date']));
$type = filter_var(trim($_POST['type']));

$result = $mysql->query("INSERT INTO finance (name, quantity, price, date, type) VALUES ('$name', '$quantity', '$price', '$date', '$type')");

if (empty($result)) {
    echo 'false';
    exit;
}

else echo 'success';



