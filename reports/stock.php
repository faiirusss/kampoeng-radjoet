<?php
session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: ../login/login.php");
    exit;
}

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

// ambil data dari tabel inventory
// dengan menggunakan LIMIR data sesuai dengan (awal mulai data, total data perhalaman yg ditampilkan)
$reports = query("SELECT * FROM quantity ORDER BY id DESC LIMIT $awal_data, $jumlahDataPerHalaman");
$reports_view = query("SELECT * FROM quantity ORDER BY id DESC LIMIT $awal_data, 6");


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="stock.css">
    <link rel="stylesheet" href="reports.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- FONT AWE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Reports</title>
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

    <div class="home overflow-x-hidden overflow-y-auto">
        <!-- navbar -->
        <header>
            <div class="nav-head d-flex justify-content-between">
                <div class="judul-menu">
                    <h1>Stok Barang</h1>
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

        <div class="row gx-5 container-fluid py-1 mx-3 ">

            <!--BOX PRODUK-->
            <div id="productCarousel" class="carousel slide row row-cols-1 row-cols-md-3 row-cols-lg-1 g-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach (array_chunk($reports_view, 3) as $index => $chunk) : ?>
                        <div class="carousel-item<?php echo ($index === 0) ? ' active' : ''; ?>">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php foreach ($chunk as $data) : ?>
                                    <div class="col box-hover">
                                        <div class="card d-flex flex-column p-3" style="border: none;">
                                            <div class="d-flex justify-content-between">
                                                <img width="50px" src="../inventory/images/<?php echo $data["image"]; ?>" class="image-box">
                                                <?php
                                                // Menentukan nilai dinamis untuk card-text-status berdasarkan stok
                                                $statusValue = ($data["stock"] > 500) ? 'Stok Banyak' : (($data["stock"] == 0) ? 'Kosong' : 'Tersedia');

                                                echo '<p class="card-text-status">' . $statusValue . '</p>';
                                                ?>
                                            </div>
                                            <div class="card mt-3" style="border: none;">
                                                <h6 class="card-title produk_name"><?php echo $data["product_name"]; ?></h6>
                                                <p class="card-text-stok"><?php echo $data["stock"]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- END BOX PRODUK -->
            <div class=" container-fluid d-flex">
                <main class="tables mt-4">
                    <section class="table__header">
                        <h1 class="m-xl-4">Tabel Stok</h1>
                    </section>


                    <section class="table__body ">
                        <table class="table table-sm">
                            <thead>
                                <tr valign="top">
                                    <th>Produk</th>
                                    <th>SKU</th>
                                    <th>Warna</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <?php foreach ($reports as $row) : ?>
                                <tbody>
                                    <tr valign="middle">
                                        <td>
                                            <img class="ms-2" width="80px" src="../inventory/images/<?php echo $row["image"]; ?>">
                                            <?php echo $row["product_name"]; ?>
                                        </td>
                                        <td><?php echo $row["id_product"]; ?></td>
                                        <td><?php echo $row["warna"]; ?></td>
                                        <td><?php echo $row["stock"]; ?></td>
                                        <?php
                                        $statusValue = ($row["stock"] > 500) ? 'Stok Banyak' : (($row["stock"] == 0) ? 'Kosong' : 'Tersedia');
                                        ?>
                                        <td><span class="status"><?php echo $statusValue ?></span></td>
                                    </tr>
                                </tbody>
                            <?php endforeach; ?>
                        </table>
                    </section>
                </main>
            </div>
        </div>
    </div>

    <script src="jquery-3.7.0.min.js"></script>
    <script src="/ajax/ajaxfile.php"></script>
    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>