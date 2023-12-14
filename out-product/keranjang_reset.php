<?php
session_start();

$_SESSION['cart'] = [];
header('location:tambahproduk.php');
