<?php

require_once "../connect.php";

$name = filter_var(trim($_POST['name']));
$mail = filter_var(trim($_POST['mail']));
$review = filter_var(trim($_POST['message']));
$date = date("Y-m-d");

$result = $mysql->query("INSERT INTO review (name, mail, review, date) VALUES ('$name', '$mail', '$review', '$date')");

echo $result ? 'success' : 'error';
