<?php
session_start();
require '../functions.php';


//insert ke tabel barang keluar
foreach ($_SESSION['cart'] as $key => $value) {

    try {

        date_default_timezone_set('Asia/Jakarta');
        $sku = $value['sku'];
        $nama_produk = $value['nama_produk'];
        $warna = $value['warna'];
        $tanggal = date('Y-m-d H:i:s');
        $harga = $value['harga'];
        $stok = $value['stok'];
        $randN = rand(100000, 999999);
        $barcode = $value['sku'] . $randN;

        mysqli_autocommit($conn, false);

        $query_stock = "SELECT stock FROM quantity WHERE id_product = '$sku' FOR UPDATE";
        $result_stock = mysqli_query($conn, $query_stock);
        $data_stock = mysqli_fetch_assoc($result_stock);
        $stock = $data_stock["stock"];

        if ($stok <= $stock) {
            // Insert into out_product
            $query3 = "INSERT INTO barang_keluar
                        VALUES ('', 
                        '$nama_produk', 
                        '$warna', 
                        '$tanggal',                         
                        '$stok', 
                        '$sku', 
                        '$harga', 
                        '$barcode')";
            mysqli_query($conn, $query3);

            // Insert into out_reports
            $query4 = "INSERT INTO reports_keluar
                        VALUES ('', 
                         '$nama_produk',
                         '$warna',
                         '$tanggal', 
                         '$stok', 
                         '$sku', 
                         '$harga', 
                         '$barcode')";
            mysqli_query($conn, $query4);

            // Update stock in quantity table
            $query6 = "UPDATE quantity SET stock = stock - $stok WHERE id_product = '$sku' AND warna = '$warna'";
            mysqli_query($conn, $query6);

            // Commit the transaction
            mysqli_commit($conn);

            $message = "Data Berhasil disimpan";
            echo '<script>';
            echo 'alert("' . $message . '");';
            echo 'window.location.href = "out-product.php";';
            echo '</script>';
        } else {
            // Rollback the transaction
            mysqli_rollback($conn);

            $message = "Gagal input data, Stok tidak mencukupi";
            echo '<script>';
            echo 'alert("' . $message . '");';
            echo 'window.location.href = "tambahdata.php";';
            echo '</script>';
        }
    } catch (Exception $e) {
        // Rollback the transaction
        mysqli_rollback($conn);

        echo '<script>alert("Gagal Menambah Data, Silahkan Ulangi atau Periksa ketersediaan Stok");</script>';
    }
}

$_SESSION['cart'] = [];

//redirect ke halaman transaksi selesai
header("location:tambahproduk.php?");
