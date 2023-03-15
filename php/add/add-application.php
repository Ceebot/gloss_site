<?php

require_once '../connect.php';
session_start();

$name = filter_var(trim($_POST['name']));
$tel = filter_var(trim($_POST['tel']));
$mail = filter_var(trim($_POST['mail']));
$selected = filter_var(trim($_POST['selected']));
$message = filter_var(trim($_POST['message']));
$date = filter_var(trim($_POST['date']));

$result = $mysql->query(
    "INSERT INTO application (name, tel, mail, selected, text, date) VALUES ('$name', '$tel', '$mail', '$selected', '$message', '$date')"
);

echo $result ? 'success' : 'error';
