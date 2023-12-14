<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';
$products = query("SELECT * FROM reports_masuk");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
</head>
<body>
    <h1>Barang Masuk</h1>

    <table border="1" cellpadding="10" cellspacing="0">

            <tr>
                <th>No.</th>

                <th>INFO PRODUK</th>
                <th>TANGGAL</th>
                <th>NAMA PRODUK</th>
                <th>HARGA</th>
                <th>STOK</th>                
                <th>BARCODE</th>
            </tr>';

$i = 1;
foreach ($products as $row) {
    $html .= '<tr>
        <td>' . $i++ . '</td>
        <td>' . $row["nama_produk"] . ' <br> ' . $row["sku"] . '</td>
        <td>' . $row["tanggal"] . '</td>
        <td>' . $row["nama_produk"] . '</td>
        <td>' . $row["harga"] . '</td>
        <td>' . $row["stok"] . '</td>        
        <td><img src="barcode.php?codetype=Code128&size=40&text=' .  $row["barcode"] . '&print=true" alt="barcode"></td>
    </tr>';
}

$html .= '</table>

</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('barang masuk.pdf', "I");
