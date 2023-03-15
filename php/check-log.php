<?php
require_once 'connect.php';
session_start();

$login = filter_var(trim($_POST['login']));
$password = md5(filter_var(trim($_POST['password']))."asd343313r3435");

$user = $mysql->query("SELECT * FROM admin WHERE login = '$login' AND password = '$password'")->fetch_assoc();

if ($user) {
    $_SESSION['user'] = $user['id'];
    echo 'success';
    exit;
}

echo 'error';
