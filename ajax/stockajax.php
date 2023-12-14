<?php

require '../functions.php';

// PAGINATION
// KONFIGURASI
$jumlahDataPerHalaman = 10;

// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM quantity"));
// pembulatan hasil ke atas bilangan
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

// inisiasi untuk nomor pada awal data
$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$keyword = $_GET["keyword"];
$query = "SELECT * FROM quantity
            WHERE
            id_product LIKE '%$keyword%' OR
            product_name LIKE '%$keyword%' OR
            stock LIKE '%$keyword%' 
            LIMIT $awal_data, $jumlahDataPerHalaman";

$reports = query($query);

?>

<table class=" table table-hover">
    <thead class="table table-sm" valign="middle">
        <tr>
            <th scope="col">SKU</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Stok</th>
        </tr>
    </thead>

    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($reports as $row) : ?>

    <tbody>
        <tr valign="middle">

            <td><?php echo $row["id_product"]; ?></td>
            <td><?php echo $row["product_name"]; ?></td>
            <td><?php echo $row["stock"]; ?></td>
        </tr>
    </tbody>

    <?php $i++; ?>
<?php endforeach; ?>
</tbody>

</table>