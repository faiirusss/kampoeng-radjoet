<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';

$id = $_GET["id"];

$selectedIds = isset($_POST['selectedIds']) ? $_POST['selectedIds'] : [];

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
</head>
<body>

    <table border="1" cellpadding="10" cellspacing="0">

            <tr>
                <th>BARCODE</th>
            </tr>';

$i = 1;
foreach ($selectedIds as $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $print = mysqli_query($conn, "SELECT * FROM barang_masuk WHERE id=$id");

    while ($row = mysqli_fetch_assoc($print)) {
        $html .= '<tr>
        <td><img src="barcode.php?codetype=Code128&size=40&text=' .  $row["barcode"] . '&print=true" alt="barcode"></td>
    </tr>';
    }
}

$html .= '</table>

</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('barang masuk.pdf', "I");
