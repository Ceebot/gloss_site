<?
require_once '../php/connect.php';
session_start();

$oldPassword = filter_var(trim($_POST['oldPassword']));
$newPassword = filter_var(trim($_POST['newPassword']));
$confirmPassword = filter_var(trim($_POST['confirmPassword']));

$id = $_SESSION['user'];

$result = $mysql->query("SELECT password FROM admin WHERE id = '$id'")->fetch_assoc();

$passwordDb = $result['password'];

if ( $passwordDb === md5($oldPassword."asd343313r3435") ) {

    if ($passwordDb !== md5($newPassword."asd343313r3435")) {

        if ($newPassword === $confirmPassword) {

            $newPassword = md5($newPassword."asd343313r3435");

            $mysql->query("UPDATE admin SET password = '$newPassword'");

            echo 'success';
        }

        else
            echo 'error-confirm-password';
    }

    else
        echo "error-old-pass-equl-new-pass";
}

else
    echo 'error-old-pass';
