<?php
// convert file ke bentuk excel
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Stok Barang.xls");
?>

<h3>Data Stok Barang</h3>

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>SKU</th>
            <th>NAMA PRODUK</th>
            <th>STOK</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "kampoeng_radjoet");
        $data = mysqli_query($conn, "SELECT * FROM quantity");
        $i = 1;
        while ($row = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['id_product'] ?></td>
                <td><?php echo $row['product_name'] ?></td>
                <td><?php echo $row['stock'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>