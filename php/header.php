<?php

require_once 'php/helper.php';
require_once 'php/connect.php';
/** @var $mysql */
session_start();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/header.less">
    <title>Глянец</title>
</head>
<body>
<header class="header">

    <div class="container header__container">
        <?php
        $users = [];
        if (isset($_SESSION['user']) && $_SESSION['user'] != '') {

            $session = true;
            $id = $_SESSION['user'];
            $user = $mysql->query("SELECT * FROM admin WHERE id='$id'")->fetch_assoc();

            $users[] = [
                'id' => $user['id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname']
            ];

        } else {
            $session = false;
        }

        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];

        echo vueTag("vue-header-menu", [
            'users' => $users,
            'session' => $session,
            'url' => $url
        ]);
        ?>

        <a href="index.php" class="header__logo">
            <img src="img/icon.png" alt="Логотип" class="logo-img">
        </a>
    </div>
</header>
