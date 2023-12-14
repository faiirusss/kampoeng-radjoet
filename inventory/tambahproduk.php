<?php

session_start();
$user = $_SESSION['login'];
if (!isset($_SESSION["login"])) {

    header("Location: login/login.php");
    exit;
}

require '../functions.php';
require '../vendor/autoload.php';

if (isset($_POST["submit"])) {
    if (tambah($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'inventory.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan');
                document.location.href = 'tambahproduk.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="inventory.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- FONT AWE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Tambah Produk</title>
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
                        <a href="inventory.php">
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

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-4 rounded-2 box">
                        <!--=====TABLE=====-->
                        <div id="containers">

                            <div class="text-judul py-4">Informasi Pengrajin</div>
                            <div class="py-1">
                                <label class="label-tambah" for="pengrajin">Nama Pengrajin <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" id="pengrajin" placeholder="Masukkan Nama Pengrajin" name="pengrajin">
                            </div>
                            <div class="pb-4 my-2">
                                <label class="label-tambah" for="tanggal">Tanggal</label>
                                <input class="input-tambah" type="datetime-local" placeholder="Pilih Kategori" id="tanggal" name="tanggal">
                            </div>
                        </div>
                        <!--=====TABLE END=====-->
                    </div>

                    <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-5 rounded-2 box">
                        <!--=====TABLE=====-->
                        <div id="containers">

                            <div class="text-judul py-3">Informasi Produk</div>

                            <!-- nama produk -->
                            <div class="py-1">
                                <label class="label-tambah" for="nama_produk">Nama Produk <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" placeholder="Contoh: Cardigan Laviola" id="nama_produk" name="nama_produk">
                            </div>
                            <span class="d-flex text-desc">Tips: Nama Produk</span>

                            <!-- warna produk -->
                            <!-- <div class="py-4">
                                <label class="label-tambah" for="warna">Warna Produk <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" placeholder="Contoh: Merah" id="warna" name="warna">
                            </div> -->
                            <div class="py-4">
                                <label class="label-tambah" for="warna">Warna Produk <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <select class="input-tambah" id="warna" name="warna" require>
                                    <option value="">Pilih Warna</option>
                                    <option value="Merah">Merah</option>
                                    <option value="Hitam">Hitam</option>
                                    <option value="Hijau">Hijau</option>
                                    <option value="Kuning">Kuning</option>
                                    <option value="Putih">Putih</option>
                                    <option value="Biru">Biru</option>
                                    <option value="lainnya">Warna Lainnya</option>
                                </select>
                                <div id="inputWarnaLainnya" style="display: none;">
                                    <label class="label-tambah" for="warna_lainnya">Warna Lainnya</label>
                                    <input class="input-tambah" type="text" id="warna_lainnya" name="warna_lainnya" placeholder="Masukkan Warna Baru">
                                </div>
                            </div>

                            <!-- DROPDOWN KATEGORI -->
                            <div class="py-4">
                                <label class="label-tambah" for="kategori">Kategori Produk <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <select class="input-tambah" id="kategori" name="kategori" require>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Cardigan">Cardigan</option>
                                    <option value="Tas">Tas</option>
                                    <option value="Rok">Rok</option>
                                    <option value="Vest">Vest</option>
                                    <option value="Blouse">Blouse</option>
                                    <option value="Totebag">Totebag</option>
                                    <option value="Sweater">Sweater</option>
                                    <option value="Sweater">Bandana</option>
                                    <option value="lainnya">Kategori Lainnya</option>
                                </select>
                                <div id="inputKategoriBaru" style="display: none;">
                                    <label class="label-tambah" for="kategori_lainnya">Kategori Baru</label>
                                    <input class="input-tambah" type="text" id="kategori_lainnya" name="kategori_lainnya" placeholder="Masukkan Kategori Baru">
                                </div>
                            </div>

                            <!-- Kondisi Barang -->
                            <div class="py-2 my-2">
                                <label class="label-tambah" for="kondisi">Kondisi <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <!-- kondisi -->
                                <input class="radio-input" type="radio" id="baru" name="kondisi" value="baru" checked="checked">
                                <label for="baru">Baru</label>
                                <input class="ms-5 radio-input" type="radio" id="bekas" name="kondisi" value="bekas">
                                <label for="bekas">Bekas</label>
                            </div>
                            <!-- END Kondisi Barang -->

                            <!--deskripsi -->
                            <div class="py-2 my-3">
                                <label class="label-tambah kategori-label" for="deskripsi">Deskripsi</label>
                                <textarea class="overflow-auto input-tambah deskripsi" name="deskripsi" id="deskripsi" cols="100" rows="10" placeholder="Cardigan Laviola &#10;- Model simple &#10;- Nyaman digunakan &#10;- Tersedia warna hitam &#10;&#10;Bahan &#10;Sole: Premium Rubber Sole &#10;&#10;Ukuran &#10;- S &#10;- M &#10;- L &#10;- XL"></textarea>
                            </div>

                            <!-- harga satuan -->
                            <div class="pt-1 pb-5 mb-4">
                                <label class="label-tambah" for="harga">Harga Satuan <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Masukkan Harga" id="harga" name="harga">
                            </div>

                            <!-- MULTIPLE PHOTO -->
                            <div class="py-1 my-2">
                                <div class="form-group2">
                                    <label class="label-tambah" for="">Foto Produk <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                    <!-- FOTO 1 -->
                                    <div class="containerr">
                                        <div class="drop-area">
                                            <i class='bx bx-image-add icon-img'></i>
                                            <input type="file" accept="image/*" id="input-file" hidden multiple="" name="foto">
                                        </div>
                                    </div>
                                </div>

                                <!-- FOTO 2 -->
                                <!-- <div class="containerr me-3">
                                    <div class="drop-area">
                                        <i class='bx bx-image-add icon-img'></i>

                                        <input type="file" accept="image/*" id="input-file" hidden>

                                    </div>
                                </div> -->

                                <!-- <div class="containerr me-3">
                                    <div class="drop-area">
                                        <i class='bx bx-image-add icon-img'></i>
                                        <input type="file" accept="image/*" id="input-file" hidden>
                                    </div>
                                </div>

                                <div class="containerr">
                                    <div class="drop-area">
                                        <i class='bx bx-image-add icon-img'></i>
                                        <input type="file" accept="image/*" id="input-file" hidden>
                                    </div>
                                </div> -->

                            </div>
                            <!-- END MULTIPLE PHOTO -->
                        </div>
                        <!--=====TABLE END=====-->
                    </div>

                    <div class="col-sm-6 col-md-11 me-3 text-start shadow-sm mb-5 rounded-2 box">
                        <!--=====TABLE=====-->
                        <div id="containers">

                            <div class="text-judul py-4">Pengelolaan Produk</div>
                            <div class="py-3">
                                <label class="label-tambah" for="">Status Produk</label>

                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked disabled>
                                <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Aktif</label>
                            </div>

                            <div class="py-3">
                                <label class="label-tambah" for="stok">Stok Produk <button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Masukkan Jumlah Stok" id="stok" name="stok">
                            </div>
                            <div class="py-3">
                                <label class="label-tambah" for="sku">SKU (Stock Keeping Unit)</label>
                                <input class="input-tambah" type="text" placeholder="Masukkan SKU" id="sku" name="sku">
                            </div>
                        </div>
                        <!--=====TABLE END=====-->
                    </div>
                    <div class="row row-cols-auto mb-3">

                        <div class="delete mt-2">
                            <a class="btn-delete" style="text-decoration: none;" href="inventory.php">
                                <div class="col me-1 text-button">batal</div>
                            </a>
                        </div>

                        <div class="mt-2">
                            <button class="btn-data" type="submit" name="submit">
                                <div class="col text-button me-4">simpan</div>
                            </button>
                        </div>
                    </div>
                    <!-- END BUTTON TABLE -->
                </form>


    </section>

    <script src="main.js"></script>
    <script src="script.js"></script>
    <script src="image.js"></script>
</body>

</html>