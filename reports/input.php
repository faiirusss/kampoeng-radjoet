<?php

session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: login/login.php");
    exit;
}

require '../functions.php';

$sub_sql = "";
$toDate = $fromDate = "";

// PAGINATION
// KONFIGURASI
$jumlahDataPerHalaman = 10;

// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM reports_masuk"));
// pembulatan hasil ke atas bilangan
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

// inisiasi untuk nomor pada awal data
$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

if (isset($_POST['submit-filter'])) {
    $from = $_POST['from'];
    $fromDate = $from;
    $fromArr = explode("/", $from);
    $from = $fromArr['2'] . '-' . $fromArr['1'] . '-' . $fromArr['0'];
    $from = $from . " 00:00:00";

    $to = $_POST['to'];
    $toDate = $to;
    $toArr = explode("/", $to);
    $to = $toArr['2'] . '-' . $toArr['1'] . '-' . $toArr['0'];
    $to = $to . " 23:59:59";

    $sub_sql = " where tanggal >= '$from' && tanggal <= '$to' ";
    // ambil data dari tabel inventory
    // Tambahan filter waktu

    $reports = mysqli_query($conn, "SELECT * FROM reports_masuk $sub_sql ORDER BY id DESC");
} else {
    $reports = mysqli_query($conn, "SELECT * FROM reports_masuk ORDER BY id DESC LIMIT $awal_data, $jumlahDataPerHalaman");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="reports.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="index.js"></script>

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
                    <h1>Report Masuk</h1>
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

            <!-- BUTTON TABLE -->
            <div class="container text-center btn-table d-flex">
                <nav>
                    <div class="row row-cols-auto mb-4 text-button2">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="">Data Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="output.php">Data Keluar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="stock.php">Data Stok</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="row row-cols-auto mb-4">
                    <div class="col me-3 text-button">
                        <form method="post">
                            <label for="from"><i class='bx bx-filter-alt me-3'></i>Date Range</label>
                            <input class="mx-2" type="text" id="from" name="from" required autocomplete="off" value="<?php echo $fromDate ?>">
                            <label for="to">to</label>
                            <input class="mx-2" type="text" id="to" name="to" required autocomplete="off" value="<?php echo $toDate ?>">
                            <input class="filter-btn" type="submit" name="submit-filter" value="Filter">
                        </form>
                    </div>
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Ekspor</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../print-pdf.php">PDF</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../print-excel.php">Excel</a></li>
                    </ul>
                    <!-- <div>
                        <select id="timeFilter" name="timeFilter">
                            <option value="all">Semua</option>
                            <option value="week">Per Minggu</option>
                            <option value="3months">Per 3 Bulan</option>
                            <option value="6months">Per 6 Bulan</option>
                            <option value="year">Per Tahun</option>
                        </select>
                        <button class="filter-btn" type="submit" name="submit-filter">Filter</button>
                    </div> -->
                </div>
            </div>
            <!-- END BUTTON TABLE -->

            <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-5 rounded-2 box">
                <!--=====TABLE=====-->
                <div id="containers">
                    <form method="POST" id="frm">
                        <table class=" table table-hover">
                            <thead class="table table-sm" valign="middle">
                                <tr>
                                    <th>
                                        <!-- <input class="ms-2" type="checkbox"onclick="select_all()"  id="delete">                                     -->
                                    </th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Pengrajin</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Kategori Produk</th>
                                    <th scope="col">Warna</th>
                                    <th scope="col">Sku</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Barcode</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($reports as $row) : ?>

                            <tbody>
                                <tr valign="middle">
                                    <td>
                                        <!-- <input class="ms-2" type="checkbox" id="<?php echo $row['id'] ?>" name="checkbox[]" value="<?php echo $row['id'] ?>" /> -->
                                    </td>
                                    <td>
                                        <img width="50" src="../inventory/images/<?php echo $row["foto"]; ?>">
                                    </td>
                                    <td><?php echo $row["pengrajin"]; ?></td>
                                    <td><?php echo $row["nama_produk"]; ?></td>
                                    <td><?php echo $row["kategori"]; ?></td>
                                    <td><?php echo $row["warna"]; ?></td>
                                    <td><?php echo $row["sku"]; ?></td>
                                    <td><?php echo $row["stok"]; ?></td>
                                    <td><?php echo $row["tanggal"]; ?></td>
                                    <td><?php echo $row["harga"]; ?></td>

                                    <td>
                                        <img src="../barcode.php?codetype=Code128&size=40&text=<?php echo $row["barcode"];  ?>&print=true" alt="barcode">
                                    </td>
                                </tr>
                            </tbody>

                            <?php $i++; ?>
                        <?php endforeach; ?>
                        </tbody>
                        </table>
                    </form>
                </div>
                <!--=====TABLE END=====-->

                <!--======= PAGINATION=======-->
                <!-- <div class="mt-5">
                    <nav aria-label="Page navigation example d-flex">
                        <ul class="pagination justify-content-between">

                            <div class="next-prev">
                                <li class="page-item">
                                    <a class="" href="?halaman=<?php echo $halamanAktif - 1; ?>">Previous</a>
                                </li>
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
                                <li class="page-item">
                                    <a class="" href="?halaman=<?php echo $halamanAktif +  1; ?>">Next</a>
                                </li>
                            </div>
                        </ul>
                    </nav>
                </div> -->
                <!--======= PAGINATION END=======-->
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var dateFormat = "dd/mm/yy",
                from = $("#from")
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "dd/mm/yy",
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#to").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "dd/mm/yy",
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
        });
    </script>

    <script src="jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="../script.js"></script>

</body>

</body>

</html>