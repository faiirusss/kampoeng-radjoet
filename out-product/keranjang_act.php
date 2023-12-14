<?php

require '../functions.php';
session_start();
require '../vendor/autoload.php';


if (isset($_POST['sku'])) {

    $kode_barang = $_POST['sku'];
    $stok = $_POST["stok"];

    //menampilkan data barang
    $data = mysqli_query($conn, "SELECT * FROM barang_masuk WHERE barcode='$kode_barang'");
    $b = mysqli_fetch_assoc($data);


    $barang = [
        'sku' => $b['sku'],
        'nama_produk' => $b['nama_produk'],
        'warna' => $b['warna'],
        'tanggal' => $b['tanggal'],
        'harga' => $b['harga'],
        'stok' => $stok
    ];


    $_SESSION['cart'][] = $barang;
    krsort($_SESSION['cart']);
    header('location:tambahproduk.php');
}
