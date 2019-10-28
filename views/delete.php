<?php require_once('../config.php');
session_start();
$user_id = $_SESSION['user_id'];

// echo "ID = " . $_GET['id'];

$o = new Orders();
$d = new OrderItems();

$d->order_id = (int)$_GET['id'];

$o->id = (int)$_GET['id'];
$o->user_id = (int)$_SESSION['user_id'];

$d->delOrder();
$o->delFromUser();

header("Location: myorders.php");


?>