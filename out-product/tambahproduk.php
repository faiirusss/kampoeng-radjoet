<?php

session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: login/login.php");
    exit;
}
require '../functions.php';
require '../vendor/autoload.php';

$barang = mysqli_query($conn, 'SELECT * FROM barang_masuk');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../inventory/inventory.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- FONT AWE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Tambah Produk Keluar</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../images/logos.png">
                </span>

                <div class="text logo-text">
                    <span class="name">Kampoeng</span>
                    <span class="profession">Radjoet</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu align-item-center">

                <ul class="menu-links">
                    <li class="nav-link mb-4">
                        <a href="../index.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="../inventory/inventory.php">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Inventory</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="out-product.php">
                            <i class='bx bx-data icon'></i>
                            <span class="text nav-text">Out Products</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="../suppliers/suppliers.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Pengrajin</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../reports/input.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../logout/logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <section class="home overflow-x-hidden">
        <!-- navbar -->
        <header>
            <div class="nav-head d-flex justify-content-between">
                <div class="judul-menu">
                    <h1 class="ms-1">Tambah Produk</h1>
                </div>
                <div>
                    <?php
                    $admin = query("SELECT * FROM user WHERE username='$user[username]'");
                    ?>
                    <h6><?php echo $admin[0]["username"] ?></h6>
                    <span>admin</span>
                </div>
            </div>
        </header>
        <!-- end navbar -->

        <div class="row g-0 text-center mx-5 my-4 container-fluid">

            <div class="container text-center btn-table">

                <form method="post" action="keranjang_act.php">
                    <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-4 rounded-2 box">
                        <!--=====TABLE=====-->
                        <div id="containers">

                            <div class="text-judul py-4">Informasi Barang</div>
                            <div class="pb-4 my-2">
                                <label class="label-tambah" for="tanggal">SKU Barang</label>
                                <input class="input-tambah" type="text" placeholder="Masukkan SKU Barang" name="sku" autofocus>
                            </div>
                        </div>
                        <!--=====TABLE END=====-->
                    </div>
                </form>
                <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-5 rounded-2 box">
                    <!--=====TABLE=====-->
                    <div id="containers">
                        <form method="POST" action="keranjang_update.php">
                            <table class="table ms-4">
                                <thead class="table table-sm">
                                    <tr>
                                        <th>SKU</th>
                                        <th>PRODUK</th>
                                        <th>WARNA</th>
                                        <th>TANGGAL</th>
                                        <th>HARGA</th>
                                        <th>STOK</th>
                                    </tr>
                                </thead>

                                <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                <?php if (isset($_SESSION['cart'])) : ?>
                                    <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                        <tr class="">
                                            <td><?php echo $value["sku"] ?></td>
                                            <td><?php echo $value["nama_produk"] ?></td>
                                            <td><?php echo $value["warna"] ?></td>
                                            <td><?php echo date('Y-m-d H:i:s') ?></td>
                                            <td><?php echo $value["harga"] ?></td>
                                            <td class="col-md-2 pe-5">
                                                <input type="number" name="stok[<?= $key ?>]" value="<?= $value['stok'] ?>" class="form-control">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php endif; ?>
                            </table>
                    </div>
                    <!--=====TABLE END=====-->
                </div>
                <!-- button -->
                <div class="row row-cols-auto mb-3">
                    <div class="delete mt-2">
                        <a class="btn-delete" style="text-decoration: none;" href="out-product.php">
                            <div class="col text-button me-1">Cancel</div>
                        </a>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn-data">
                            <div class="col text-button me-1">Simpan</div>
                        </button>
                    </div>
                    </form>
                    <div class="delete mt-2">
                        <a class="btn-delete" style="text-decoration: none;" href="keranjang_reset.php">
                            <div class="col text-button me-1">Reset</div>
                        </a>
                    </div>
                    <div class="mt-2">
                        <form action="final.php" method="POST">
                            <button class="btn-data" type="submit" name="submit">
                                <div class="col text-button me-4">Selesai</div>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- END BUTTON TABLE -->



    </section>

    <script src="main.js"></script>
    <script src="script.js"></script>
    <script src="image.js"></script>
</body>

</html>