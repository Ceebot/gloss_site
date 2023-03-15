<?php
require_once '../connect.php';

$typeManagement = !empty($_POST['typeManagement']) ? filter_var(trim($_POST['typeManagement'])) : '';

$description = !empty($_POST['description']) ? filter_var(trim($_POST['description'])) : '';

$id = filter_var(trim($_POST['id']));

if ($typeManagement === 'finance') {

    if ($description === 'delete') {

        $result = $mysql->query("DELETE FROM finance WHERE id = '$id'");
    }

    if ($description === 'edit') {

        $name = filter_var(trim($_POST['name']));

        $quantity = filter_var(trim($_POST['quantity']));

        $price = filter_var(trim($_POST['price']));

        $date = filter_var(trim($_POST['date']));

        $result = $mysql->query("UPDATE finance SET name = '$name', quantity = '$quantity', price = '$price', date = '$date' WHERE id = '$id'");
    }
}

if ($typeManagement === 'clients') {

    if ($description === 'applications') {

        $result = $mysql->query("DELETE FROM application WHERE id = '$id'");
    }

    if ($description === 'reviews') {

        $result = $mysql->query("DELETE FROM review WHERE id = '$id'");
    }
}

echo $result ? 'success' : 'false';
