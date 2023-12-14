<?php
session_start();
require '../functions.php';
require '../vendor/autoload.php';

$barang = mysqli_query($conn, 'SELECT * FROM barang_masuk');

?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Produk Keluar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Produk Keluar</h1>
                <a href="out-product.php">Kembali</a> |
                <a href="keranjang_reset.php">Reset Keranjang</a> |
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="keranjang_act.php" class="form-inline">
                    <div class="form-group">
                        <input type="text" name="sku" class="form-control" placeholder="Masukkan SKU" autofocus>
                    </div>
                </form>
                <br>
                <form method="POST" action="keranjang_update.php">
                    <table class="table table-bordered">
                        <tr>
                            <th>SKU</th>
                            <th>Produk</th>
                            <th>Warna</th>
                            <th>Tanggal</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                        <?php date_default_timezone_set('Asia/Jakarta'); ?>
                        <?php if (isset($_SESSION['cart'])) : ?>
                            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                <tr>
                                    <td><?php echo $value["sku"] ?></td>
                                    <td><?php echo $value["nama_produk"] ?></td>
                                    <td><?php echo $value["warna"] ?></td>
                                    <td><?php echo date('Y-m-d H:i:s') ?></td>
                                    <td><?php echo $value["harga"] ?></td>
                                    <td class="col-md-2">
                                        <input type="number" name="stok[<?= $key ?>]" value="<?= $value['stok'] ?>" class="form-control">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endif; ?>
                    </table>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
                <div class="mt-2">
                    <form action="final.php" method="POST">
                        <button type="submit" class="btn btn-primary mt-2">Selesai</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>

</html>