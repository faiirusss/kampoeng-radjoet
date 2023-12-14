<?php

session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: login/login.php");
}

require '../functions.php';

if (isset($_POST["submit"])) {


    if (addsupplier($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'suppliers.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan');
                document.location.href = 'suppliers.php';
            </script>
        ";
    }
}

// PAGINATION
// KONFIGURASI
$jumlahDataPerHalaman = 10;

// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM suppliers"));

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
$supplier = query("SELECT COUNT(DISTINCT name) AS total_supplier FROM suppliers");
$suppliers = query("SELECT * FROM suppliers ORDER BY id DESC LIMIT $awal_data, $jumlahDataPerHalaman ");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="suppliers.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- FONT AWE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Pengrajin</title>
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
                    <h1>Pengrajin</h1>
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

        </div>

        <div class="row g-0 text-center mx-5 my-4 container-fluid">

            <!-- BUTTON TABLE -->
            <div class="container text-center btn-table">
                <div class="row row-cols-auto mb-4">

                    <a style="text-decoration: none" ; href="javascript:void(0)" class="link_delete" onclick="delete_all()" class="delete-text">
                        <div class="col me-3 text-button">
                            Delete
                        </div>
                    </a>

                    <button class="btn-data" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <div class="col text-button me-4">Add</div>
                    </button>

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
                    <form method="POST" id="frm">
                        <table class=" table table-hover">
                            <thead class="table table-sm" valign="middle">
                                <tr>
                                    <th>
                                        <input class="ms-2" type="checkbox" onclick="select_all()" id="delete">
                                    </th>
                                    <th>PENGRAJIN</th>
                                    <th>EMAIL</th>
                                    <th>TELEPON</th>
                                    <th>TANGGAL</th>
                                    <th>STATUS</th>
                                    <th>PERFORMA</th>
                                    <th>INDIKATOR</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($suppliers as $row) : ?>

                            <tbody>
                                <tr valign="middle" id="box<?php echo $row['id'] ?>">
                                    <td>
                                        <input class="ms-2" type="checkbox" id="<?php echo $row['id'] ?>" name="checkbox[]" value="<?php echo $row['id'] ?>" />
                                    </td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php echo $row["phone"]; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row["started"])); ?></td>
                                    <td><?php echo $row["status"]; ?></td>
                                    <td>
                                        <input type="range" name="label[]" value="<?php echo $row['performa']; ?>" min="0" max="100" step="1">
                                        <span class="label-value"><?php echo $row['performa']; ?></span>
                                    </td>
                                    <td>
                                        <span class="performa">
                                            <?php
                                            $performa = $row['performa'];
                                            if ($performa > 80) {
                                                echo 'Pekerja Keras';
                                            } elseif ($performa < 30) {
                                                echo 'Malas';
                                            } else {
                                                echo 'Rajin';
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-edit">
                                            <a class="edit-action" style="text-decoration: none" ; href="edit.php?id= <?php echo $row["id"]; ?>"><i class='bx bx-pencil me-1'></i>Edit</a>
                                        </button>
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="" enctype="multipart/form-data">

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="name" id="name" placeholder="Enter name" autocomplete="off" required>
                                <label for="name" class="label">Name</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="email" name="email" id="email" placeholder="Enter email" required>
                                <label for="email" class="label">Email</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="phonenumber" id="phonenumber" placeholder="Enter phonenumber" required>
                                <label for="phonenumber" class="label">Phone Number</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="date" name="started" id="started" placeholder="Start joining" required>
                                <label for="started" class="label">Started</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="status">
                                    <option selected>Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Not Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script src="jquery-3.7.0.min.js"></script>
    <script src="ajax.js"></script>
    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>