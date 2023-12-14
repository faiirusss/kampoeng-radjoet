<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';
$products = query("SELECT * FROM quantity");

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
                <th>SKU</th>
                <th>NAMA PRODUK</th>
                <th>Stock</th>
            </tr>';

$i = 1;
foreach ($products as $row) {
    $html .= '<tr>
        <td>' . $i++ . '</td>
        <td>' . $row["id_product"] . '</td>
        <td>' . $row["product_name"] . '</td>
        <td>' . $row["stock"] . '</td>        
    </tr>';
}

$html .= '</table>

</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('stok barang.pdf', "I");
