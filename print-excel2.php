<?php
// convert file ke bentuk excel
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data barangKeluar.xls");
?>

<h3>Data Barang Keluar</h3>

<table border="1">
    <thead>
        <tr>
            <th>NAMA PRODUK</th>
            <th>SKU</th>
            <th>STOK</th>
            <th>TANGGAL</th>
            <th>HARGA</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "kampoeng_radjoet");
        $data = mysqli_query($conn, "SELECT * FROM reports_keluar");
        while ($row = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $row['nama_produk'] ?></td>
                <td><?php echo $row['sku'] ?></td>
                <td><?php echo $row['stok'] ?></td>
                <td><?php echo $row['tanggal'] ?></td>
                <td><?php echo $row['harga'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>