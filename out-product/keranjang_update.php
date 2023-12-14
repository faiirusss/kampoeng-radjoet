<?php
require '../functions.php';
session_start();
require '../vendor/autoload.php';

$stok = $_POST["stok"];

foreach ($_SESSION['cart'] as $key => $value) {
    $_SESSION['cart'][$key]['stok'] = $stok[$key];
}
header('location:tambahproduk.php');
