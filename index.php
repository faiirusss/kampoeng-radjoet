<?php

use Mpdf\Tag\Q;

session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: login/login.php");
    exit;
}

require 'functions.php';

$jumlahData = count(query("SELECT * FROM suppliers"));

$qty = query("SELECT SUM(stok) AS Qty FROM barang_masuk");

$qty_product = query("SELECT SUM(stok) AS Qty FROM barang_keluar");

$supplier = query("SELECT COUNT(DISTINCT name) AS total_supplier FROM suppliers");
$product = query("SELECT COUNT(DISTINCT nama_produk) AS product FROM barang_masuk;");

$barang_masuk = query("SELECT * FROM barang_masuk ORDER BY id DESC LIMIT 0,5");
$rank_pengrajin = query("SELECT * FROM view_pengrajin LIMIT 0, 5");
$rank_stok = query("SELECT * FROM view_stock LIMIT 0, 3");
$penghasilan = query("SELECT SUM(harga) as Profit FROM barang_keluar");
$query3 = query("SELECT nama_produk as produk_keluar, SUM(stok) as stok_keluar FROM barang_keluar GROUP BY produk_keluar ORDER BY stok_keluar DESC");
$query2 = query("SELECT MONTHNAME(started) as month, SUM(id) as total_supplier FROM suppliers GROUP BY month ORDER BY total_supplier DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- FONT AWE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Dashboard</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="images/logos.png">
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
                        <a href="index.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="inventory/inventory.php">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Barang Masuk</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="out-product/out-product.php">
                            <i class='bx bx-data icon'></i>
                            <span class="text nav-text">Barang Keluar</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="suppliers/suppliers.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Pengrajin</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="reports/input.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="logout.php">
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
                    <h1>Dashboard</h1>
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

        <!-- dashboard full -->
        <div class="row gx-5 container-fluid py-3 mx-3 ">
            <!-- 1 - column left to right -->
            <div class="row mt-3">
                <!-- box top -->
                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="card z-index-2 h-100 mb-4" style="border: none;">
                        <div class="ms-3 pb-0 pt-3 bg-transparent d-flex">
                            <div class="text-capitalize judul">Barang Masuk</div>
                            <div class="text-capitalize judul title-top2">Barang Keluar</div>
                            <div class="text-capitalize judul title-top3">Stok Barang</div>
                        </div>
                        <div class="card-body p-3 overflow-hidden">
                            <div class="row gx-5 mx-0">
                                <div class="row">
                                    <div class="col flex-row justify-content-evenly card ">
                                        <div class="p-3">
                                            <!-- total stok masuk -->
                                            <p><i class="fa-solid fa-box-archive fa-xl" style="color: #8f939a;"></i> Total Stok</p>
                                            <div class="subs-text"><?php echo $qty[0]["Qty"] ?></div>
                                        </div>
                                        <img class="p-3" src="images/Line.png" alt="line">
                                        <!-- total produk -->
                                        <div class="p-3">
                                            <p><i class="fa-solid fa-box-archive fa-xl" style="color: #8f939a;"></i> Total Produk</p>
                                            <div class="subs-text"><?php echo $product[0]["product"] ?></div>
                                        </div>
                                    </div>
                                    <div class="col mx-4 flex-row justify-content-evenly card">
                                        <div class="p-3">
                                            <p><i class="fa-solid fa-truck-fast fa-xl" style="color: #8f939a;"></i> Total Stok</p>
                                            <div class="subs-text"><?php echo $qty_product[0]["Qty"] ?></div>
                                        </div>
                                        <img class="p-3" src="images/Line.png" alt="line">
                                        <div class="p-3">
                                            <p><i class="fa-solid fa-dollar-sign fa-xl" style="color: #8f939a;"></i> Total Penjualan</p>
                                            <div class="subs-text"><?php echo $penghasilan[0]["Profit"]; ?></div>
                                        </div>
                                    </div>

                                    <!-- stok -->
                                    <div class="col-5 card flex-row justify-content-evenly">
                                        <?php foreach ($rank_stok as $stok) :  ?>
                                            <div class="p-3">

                                                <div><i class="fa-solid fa-box-open fa-xl" style="color: #8f939a;"></i> <?php echo $stok["product_name"]; ?></div>
                                                <div><?php echo $stok["warna"]; ?></div>
                                                <div class="subs-text"><?php echo $stok["stock"]; ?></div>
                                            </div>
                                            <img class="p-3" src="images/Line.png" alt="line">
                                        <?php endforeach; ?>
                                        <!-- <div class="p-3">
                                            <p>Payment Paid</p>
                                            <div>15,000</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end box top -->

                <!-- box middle -->
                <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                    <div class="card z-index-2 h-100 mb-4" style="border: none;">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize judul">Barang Keluar</h6>
                        </div>
                        <div class="card-body p-3 overflow-hidden">
                            <span class="ms-2" style="color: #8f939a;"><i class="fa-solid fa-truck-fast fa-sm" style="color: #8f939a;"></i> <strong>Top List</strong> Produk Terjual</span>
                            <div class="row gx-5 mx-2">
                                <div class="col gx-2 mt-2 d-flex justify-content-between">
                                    <div class="card-chart" style="width: 65%;">
                                        <canvas id="myChart3"></canvas>
                                    </div>
                                    <div class="row ms-5 d-flex">
                                        <div class="d-flex">
                                            <div class="box-diagram1 me-2"></div>
                                            <p class="text-diagram">
                                                <?php echo $query3[0]["produk_keluar"]; ?><br>
                                                <?php echo $query3[0]["stok_keluar"]; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="box-diagram2 me-2"></div>
                                            <p class="text-diagram">
                                                <?php echo $query3[1]["produk_keluar"]; ?><br>
                                                <?php echo $query3[1]["stok_keluar"]; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="box-diagram3 me-2"></div>
                                            <p class="text-diagram">
                                                <?php echo $query3[2]["produk_keluar"]; ?><br>
                                                <?php echo $query3[2]["stok_keluar"]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                    <div class="card z-index-2 h-100 mb-4" style="border: none;">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize judul">Barang Masuk</h6>
                        </div>
                        <div class="card-body p-3 overflow-hidden">
                            <div class="row gx-0 mt-2 mx-2 card">
                                <div class="chart" style="width: 100%;">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                    <div class="card z-index-2 h-100 mb-4" style="border: none;">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize judul">Report Pengrajin</h6>
                        </div>
                        <div class="card-body p-3 overflow-hidden">
                            <span class="ms-2" style="color: #8f939a;"><i class="fa-solid fa-truck-fast fa-sm" style="color: #8f939a;"></i> <strong>Top List</strong> Pengrajin /Bulan</span>
                            <div class="row gx-5 mx-2">
                                <div class="col gx-2 mt-2 d-flex justify-content-between">
                                    <div class="card-chart2" style="width: 60%;">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                    <div class="row ms-5 d-flex">
                                        <div class="d-flex">
                                            <div class="box2-diagram1 me-2"></div>
                                            <p class="text-diagram">
                                                <?php echo $query2[0]["month"]; ?><br>
                                                <?php echo $query2[0]["total_supplier"]; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="box2-diagram2 me-2"></div>
                                            <p class="text-diagram">
                                                <?php echo $query2[1]["month"]; ?><br>
                                                <?php echo $query2[1]["total_supplier"]; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="box2-diagram3 me-2"></div>
                                            <p class="text-diagram">
                                                <?php echo $query2[2]["month"]; ?><br>
                                                <?php echo $query2[2]["total_supplier"]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end box middle -->

                <!-- box bottom -->
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <!-- overview barang masuk -->
                    <div class="card z-index-2 h-100 mb-0" style="border: none;">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize judul">Pengrajin</h6>
                        </div>
                        <div class="card-body px-3 overflow-hidden">
                            <div class="row gx-5 mx-2 ">

                                <?php $i = 1; ?>
                                <table class="table table-sm">
                                    <?php foreach ($rank_pengrajin as $data) : ?>
                                        <tbody>
                                            <tr align="center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $data["pengrajin"]; ?></td>
                                                <td><i class="fa-solid fa-arrow-right-long fa-lg" style="color: #9e41fb;"></i></td>
                                                <td><?php echo $data["total_stok"]; ?></td>
                                            </tr>
                                        </tbody>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- grafik report barang masuk-->
                <div class="col-lg-8 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-80" style="border: none;">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize judul">Info Produk</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm dash-product">
                                <thead>
                                    <tr>
                                        <th>PRODUK</th>
                                        <th>STATUS</th>
                                        <th>KATEGORI</th>
                                        <th>SKU</th>
                                        <th>WARNA</th>
                                        <th>STOK</th>
                                        <th>TANGGAL</th>
                                    </tr>
                                </thead>
                                <?php foreach ($barang_masuk as $row) : ?>
                                    <tbody>
                                        <tr align="left">
                                            <td><?php echo $row["nama_produk"]; ?></td>
                                            <td><span class="status">Masuk</span></td>
                                            <td><?php echo $row["kategori"]; ?></td>
                                            <td><?php echo $row["sku"]; ?></td>
                                            <td><?php echo $row["warna"]; ?></td>
                                            <td><?php echo $row["stok"]; ?></td>
                                            <td><?php echo $row["tanggal"]; ?></td>

                                        </tr>
                                    </tbody>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end box bottom -->
            </div>
        </div>
    </div>

    <!-- CHART PHP -->
    <?php
    $conn = new mysqli('localhost', 'root', '', 'kampoeng_radjoet');

    // chart 1 query -> jumlah barang masuk untuk setiap bulan
    $query = $conn->query(
        "SELECT 
                MONTHNAME(tanggal) as monthname,
                SUM(stok) as quantity
                FROM reports_masuk
                GROUP BY monthname
            "
    );

    foreach ($query as $data) {
        $month[] = $data['monthname'];
        $amount[] = $data['quantity'];
    }


    // chart 2 query -> total pengrajin yang daftar di setiap bulannya
    $query2 = $conn->query(
        "SELECT 
                MONTHNAME(started) as month,
                SUM(id) as total_supplier
                FROM suppliers
                GROUP BY month
            "
    );

    foreach ($query2 as $supplier) {
        $month_supplier[] = $supplier['month'];
        $total[] = $supplier['total_supplier'];
    }

    // chart 3 query -> total stok keluar untuk setiap barang 
    $query3 = $conn->query(
        "SELECT
        nama_produk as produk_keluar ,
        SUM(stok) as stok_keluar
        FROM barang_keluar
        GROUP BY produk_keluar
        ORDER BY stok DESC"
    );

    foreach ($query3 as $stok_produk) {
        $name_product[] = $stok_produk['produk_keluar'];
        $stok[] = $stok_produk['stok_keluar'];
    }


    ?>
    <!-- CHART PHP END-->


    </section>


    <!-- SCRIPT CHART CONFIG -->
    <script>
        // config chart 1
        const labels = <?php echo json_encode($month) ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Inventory Report',
                data: <?php echo json_encode($amount) ?>,
                backgroundColor: [
                    '#9E41FB',
                    '#4E7CFF',
                    '#F65164'
                ],
                hoverOffset: 8
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
        // end config chart 1

        // config chart 2
        const label2 = <?php echo json_encode($month_supplier) ?>;

        const data_supplier = {
            labels: label2,
            datasets: [{
                label: 'Supplier Report',
                data: <?php echo json_encode($total) ?>,
                backgroundColor: [
                    '#2C55FB',
                    '#5677FC',
                    '#95AAFD'
                ],
                hoverOffset: 8
            }]
        };

        const config2 = {
            type: 'doughnut',
            data: data_supplier,
            options: {
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                },
                scales: {
                    x: {
                        display: false, // Menonaktifkan sumbu x
                    },
                    y: {
                        display: false, // Menonaktifkan sumbu y
                    },
                }
            },
        };

        var myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );
        // end charrt 2

        // start chart 3
        const label3 = <?php echo json_encode($name_product) ?>;
        const data_stok = {
            labels: label3,
            datasets: [{
                label: 'Stok Keluar',
                data: <?php echo json_encode($stok) ?>,
                backgroundColor: [
                    '#9E41FB',
                    '#C995FD',
                    '#EAD6FE'
                ],
                hoverOffset: 8
            }]
        };

        const config3 = {
            type: 'doughnut',
            data: data_stok,
            options: {
                plugins: {

                    legend: {
                        display: false,
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                },
                scales: {
                    x: {
                        display: false, // Menonaktifkan sumbu x
                    },
                    y: {
                        display: false, // Menonaktifkan sumbu y
                    },
                }
            },

        };

        var myChart3 = new Chart(
            document.getElementById('myChart3'),
            config3
        );
    </script>
    <!-- ENDSCRIPT CHART CONFIG -->


    <!-- SCRIPT JS -->
    <script src="script.js"></script>



    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>