<?php

session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: login/login.php");
    exit;
}

require '../functions.php';
require '../vendor/autoload.php';

// PAGINATION
// KONFIGURASI
$jumlahDataPerHalaman = 10;

// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM barang_keluar"));
// pembulatan hasil ke atas bilangan
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

// inisiasi untuk nomor pada awal data
$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// ambil data dari tabel inventory
// dengan menggunakan LIMIR data sesuai dengan (awal mulai data, total data perhalaman yg ditampilkan)
$products = query("SELECT * FROM barang_keluar ORDER BY id DESC LIMIT $awal_data, $jumlahDataPerHalaman");

$qty = query("SELECT SUM(stok) AS Qty FROM barang_keluar");

$product = query("SELECT COUNT(DISTINCT nama_produk) AS product FROM barang_keluar;");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="outproduct.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- FONT AWE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Out Product</title>
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
            <div class="menu">

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
                            <span class="text nav-text">Barang Masuk</span>
                        </a>
                    </li>
                    <li class="nav-link mb-4">
                        <a href="../out-product/out-product.php">
                            <i class='bx bx-data icon'></i>
                            <span class="text nav-text">Barang Keluar</span>
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

    <section class="home overflow-x-hidden overflow-y-auto">
        <!-- navbar -->
        <header>
            <div class="nav-head d-flex justify-content-between">
                <div class="judul-menu">
                    <h1>Barang Keluar</h1>
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

        <div class="row g-0 mx-5 mt-3 rounded-2 container-fluid">
            <div class="col-sm-6 col-md-11 shadow-sm p-4 mb-5 rounded box">
                <div class="flex-row d-flex justify-content-evenly">

                    <div class="sales d-flex justift-content-between align-items-center">
                        <div class="sales-img my-3">
                            <center><i class='bx bx-package text-icon first'></i></center>
                        </div>
                        <div class="sales-text ms-3">
                            <div class="frame">
                                <div class="text-sub">Stok Keluar</div>
                                <div class="text-number"><?php echo $qty[0]["Qty"]; ?></div>
                            </div>
                        </div>
                    </div>

                    <img src="../images/Line.png" alt="line">

                    <div class="revenue d-flex justift-content-between align-items-center">
                        <div class="revenue-img my-3">
                            <center><i class='bx bx-user text-icon second'></i></center>
                        </div>
                        <div class="revenue-text ms-5">
                            <div class="frame">
                                <div class="text-sub">Product type out</div>
                                <div class="text-number"><?php echo $product[0]["product"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <img src="../images/Line.png" alt="line">

                    <div class="profit d-flex justift-content-between align-items-center">
                        <div class="profit-img my-3">
                            <center><i class='bx bx-box text-icon third'></i></center>
                        </div>
                        <div class="profit-text ms-5">
                            <div class="frame">
                                <div class="text-sub">Type of Products</div>
                                <div class="text-number"><?php echo $product[0]["product"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <img src="../images/Line.png" alt="line">

                    <div class="cost d-flex justift-content-between align-items-center">
                        <div class="cost-img my-3">
                            <center><i class='bx bx-archive-in text-icon fourth'></i></center>
                        </div>
                        <div class="cost-text  ms-5">
                            <div class="frame">
                                <div class="text-sub">Total data Keluar</div>
                                <div class="text-number"><?php echo $jumlahData; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0 text-center mx-5 my-4 container-fluid">
            <!-- BUTTON TABLE -->
            <div class="container text-center btn-table">
                <div class="row row-cols-auto mb-4">
                    <a href="tambahproduk.php" style="text-decoration:none;">
                        <div class="col text-button me-4">Add</div>
                    </a>

                    <div class="right">
                        <div class="search-box right">
                            <input type="search" placeholder="Type to search.." name="keyword" id="keyword">
                            <div class="search-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="cancel-icon">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="search-data"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BUTTON TABLE -->

            <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-5 rounded-2 box">
                <!--=====TABLE=====-->
                <div id="containers">
                    <table class="table table-hover">
                        <thead class="table table-sm">
                            <tr>
                                <th>
                                    <form action="">
                                        <input class="ms-1" type="checkbox">
                                    </form>
                                </th>
                                <th>INFO PRODUK</th>
                                <th>WARNA</th>
                                <th>STOK</th>
                                <th>TANGGAL</th>
                                <th>HARGA</th>
                                <th>STATUS</th>
                                <th>BARCODE</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        <?php foreach ($products as $row) : ?>

                            <tbody>
                                <tr valign="middle">
                                    <td style="display: none;" class="user_id"><?php echo $row["id"]; ?></td>
                                    <td>
                                        <form action="">
                                            <input class="ms-2" type="checkbox">
                                        </form>
                                    </td>
                                    <td>
                                        <b><?php echo $row["nama_produk"]; ?></b>
                                        <br>
                                        <?php echo "SKU: " . $row["sku"]; ?>

                                    </td>
                                    <td><?php echo $row["warna"]; ?></td>
                                    <td><?php echo $row["stok"]; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row["tanggal"])); ?></td>
                                    <td><?php echo $row["harga"]; ?></td>
                                    <td><button class="btn-status">Out</button></td>
                                    <td>
                                        <img src="../barcode.php?codetype=Code128&size=40&text=<?php echo $row["barcode"];  ?>&print=true" alt="barcode">
                                    </td>
                                    <td align="left">
                                        <button class="btn-action">
                                            <a style="text-decoration: none" ; href="#" class="view_data">Detail</a>
                                        </button>
                                        <button class="btn-action">
                                            <a style="text-decoration: none" ; href="remove.php?id= <?php echo $row["id"]; ?>" onclick="return confirm('yakin?');"><i class='fs-6 bx bx-trash-alt me-2'></i>Delete</a>
                                        </button>
                                </tr>
                            </tbody>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <!--=====TABLE END=====-->

                <!--========= PAGINATION=========-->
                <div class="mt-5">
                    <nav aria-label="Page navigation example d-flex">
                        <ul class="pagination justify-content-between">

                            <div class="next-prev">
                                <?php if ($halamanAktif > 1) : ?>
                                    <li class="page-item">
                                        <a class="" href="?halaman=<?php echo $halamanAktif - 1; ?>">Previous</a>
                                    </li>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex number-pgn">
                                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                                    <?php if ($i == $halamanAktif) : ?>
                                        <li class="page-item active"><a class="page-link" href="?halaman=<?php echo $i ?>"><?php echo $i ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a class="page-link" href="?halaman=<?php echo $i ?>"><?php echo $i ?></a></li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>

                            <div class="next-prev">
                                <?php if ($halamanAktif < $jumlahHalaman) : ?>
                                    <li class="page-item">
                                        <a class="" href="?halaman=<?php echo $halamanAktif + 1; ?>">Next</a>
                                    </li>
                                <?php endif; ?>
                            </div>
                        </ul>
                    </nav>
                </div>
                <!--======= PAGINATION END=======-->
            </div>
        </div>
    </section>

    <!-- modal pop up data -->
    <div class="modal fade" id="viewusermodal" tabindex="-1" aria-labelledby="viewusermodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewusermodalLabel">Detail Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="view_user_data">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script src="jquery-3.7.0.min.js"></script>
    <script src="ajax.js"></script>
    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            $('.view_data').click(function(e) {
                e.preventDefault()

                var user_id = $(this).closest('tr').find('.user_id').text();
                // console.log(user_id);

                $.ajax({
                    method: "POST",
                    url: "ajaxfile.php",
                    data: {
                        'click_view_btn': true,
                        'user_id': user_id,
                    },
                    success: function(response) {
                        // console.log(response);

                        $('.view_user_data').html(response);
                        $('#viewusermodal').modal('show');
                    }
                });
            });
        });
    </script>
</body>

</html>