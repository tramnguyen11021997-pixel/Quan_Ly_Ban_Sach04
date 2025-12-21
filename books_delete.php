<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit();
}

$id = $_GET['id'];
$books = $_SESSION['books'];

foreach ($books as $i => $b) {
    if ($b['id'] == $id) {
        unset($books[$i]);
        break;
    }
}

$_SESSION['books'] = array_values($books);
header("Location: books.php");
exit();
