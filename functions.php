<!-- fungsi untuk tiap menu -->
<!-- dan fungsi query ke databasse -->
<?php
// koneksi ke database
// database kampung_rajut
$conn = mysqli_connect("localhost", "root", "", "kampoeng_radjoet");

function query($query)
{
    global $conn;
    $rows = array();

    $result = mysqli_query($conn, $query);
    $row = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


// ==========================INVENTORY================================

// ===FUNCTION ADD BARANG MASUK
function tambah($data)
{
    global $conn;
    // warna produk - barcode

    $sku = ($data["sku"]);
    $warna = strtolower($data["warna"]);
    if ($warna == "lainnya") {
        $warnaLain = $data["warna"];
        $warna = $warnaLain;
    }
    $warnaHexa = bin2hex($warna);
    $Warna = substr($warnaHexa, 0, 8);
    $barcode = ($data["sku"]) . $Warna;
    $pengrajin = ($data["pengrajin"]);
    $tanggal = ($data["tanggal"]);
    $produk = ($data["nama_produk"]);
    $kategori = $data["kategori"];
    if ($kategori == "lainnya") {
        // Jika pengguna memilih kategori lainnya, ambil nilai dari input teks
        $kategoriBaru = $data["kategori_lainnya"];
        $kategori = $kategoriBaru;
    }
    $kondisi = ($data["kondisi"]);
    $deskripsi = ($data["deskripsi"]);
    $harga = ($data["harga"]);

    // upload khusus gambar
    $foto = uploadProduk();

    if (!$foto) {
        return false;
    }

    $stok = ($data["stok"]);

    // QUERY INSERT DATA TO DATABASE
    $query = "INSERT INTO barang_masuk
                VALUES
                ('', 
                '$pengrajin', 
                '$tanggal', 
                '$produk', 
                '$kategori',
                '$warna',
                '$kondisi', 
                '$deskripsi',
                '$harga', 
                '$foto',
                '$stok',
                '$sku',
                '$barcode'
                )";
    // $query = "CALL tambahDataMasuk('$supplier', '$codeProduct', '$product', '$qty', '$date', '$barcode')";

    // file_put_contents($barcode, $generator->getBarcode($sku, $generator::TYPE_CODE_128, 3, 50, $color)); // barcode

    // insert to reports
    $report = "INSERT INTO reports_masuk
                VALUES
                ('', 
                '$pengrajin', 
                '$produk', 
                '$kategori', 
                '$warna',
                '$tanggal', 
                '$stok', 
                '$sku', 
                '$harga', 
                '$foto', 
                '$barcode')
                ";
    // $report = "CALL tambahInvenReports('$supplier', '$codeProduct', '$product', '$qty', '$date', '$barimage')";

    $count = 0;
    $result = mysqli_query($conn, "SELECT * FROM quantity WHERE id_product = '$sku' AND warna = '$warna'");
    $count = mysqli_num_rows($result);

    if ($count === 0) {

        mysqli_query($conn, "INSERT INTO quantity 
                        VALUES
                    ('', 
                    '$sku', 
                    '$produk',
                    '$warna', 
                    '$stok',
                    '$foto'
                    )
                    ");
    } else {
        mysqli_query($conn, "UPDATE quantity SET stock = stock + $stok WHERE id_product = '$sku' AND warna = '$warna'");
    }

    mysqli_query($conn, $query);
    mysqli_query($conn, $report);

    return mysqli_affected_rows($conn);
}

function uploadProduk()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // cek ada gambar yang diupload atau tidak
    // jika tidak ada maka jalankan 
    if ($error === 4) {
        echo  "<script>
                    alert('Pilih gambar terlebih dahulu');
                </script>
            ";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo  "<script>
                    alert('yang anda upload bukan gambar!');
               </script>
        ";
        return false;
    }

    // cek jika ukuran file terlalu besar
    if ($ukuranFile > 1000000) {
        echo  "<script>
                    alert('ukuran gambar terlalu besar');
               </script>
        ";
        return false;
    }

    // jika lolos pengecekan, gambar siap upload
    // kemudian generate nama gambar baru

    // inisiasi untuk generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'images/' . $namaFileBaru);

    return $namaFileBaru;
}

// ===FUNCTION REMOVE===
function hapus($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM barang_masuk WHERE id = $id");

    return mysqli_affected_rows($conn);
}

// ==========================SUPPLIERS================================
// ===add supplier===
function addsupplier($data)
{
    global $conn;

    $name = ($data["name"]);
    $email = ($data["email"]);
    $phone = ($data["phonenumber"]);
    $started = ($data["started"]);
    $status = ($data["status"]);

    // upload khusus gambar
    $image = uploadsupplier();

    if (!$image) {
        return false;
    }

    // QUERY INSERT DATA TO DATABASE
    $query = "INSERT INTO suppliers
                VALUES
                ('', '$name', '$email', '$phone', '$started', '$status','NULL', '$image')
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// ===function upload===
function uploadsupplier()
{
    $namaFile = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    // cek ada gambar yang diupload atau tidak
    // jika tidak ada maka jalankan 
    if ($error === 4) {
        echo  "<script>
                    alert('Pilih gambar terlebih dahulu');
                </script>
            ";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo  "<script>
                    alert('yang anda upload bukan gambar!');
               </script>
        ";
        return false;
    }

    // cek jika ukuran file terlalu besar
    if ($ukuranFile > 1000000) {
        echo  "<script>
                    alert('ukuran gambar terlalu besar');
               </script>
        ";
        return false;
    }

    // jika lolos pengecekan, gambar siap upload
    // kemudian generate nama gambar baru

    // inisiasi untuk generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'image/' . $namaFileBaru);

    return $namaFileBaru;
}

// ===FUNCTION REMOVE===
function hapussupplier($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM suppliers WHERE id = $id");

    return mysqli_affected_rows($conn);
}

// ===FUNCTION EDIT===
function ubahsupplier($data)
{
    global $conn;

    $id = $data["id"];
    $name = htmlspecialchars($data["name"]);
    $email = htmlspecialchars($data["email"]);
    $phone = htmlspecialchars($data["phone"]);
    $started = htmlspecialchars($data["started"]);
    $status = ($data["status"]);
    $performa = $data["performa"];
    $image_old = ($data["image_old"]);

    // cek apakah user pilih gambar baru atau tidak    
    if ($_FILES['image']['error'] === 4) {
        $image = $image_old;
    } else {
        $image = uploadsupplier();
    }

    // query insert data baru
    $query = "UPDATE suppliers 
                SET    
                name = '$name',
                email = '$email',
                phone = '$phone',
                started = '$started',
                status = '$status',
                performa = '$performa',
                image = '$image'
                WHERE id = $id
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// ==========================END SUPPLIERS===========================

// ==========================OUT PRODUCT================================
// ===FUNCTION REMOVE===
function hapusproduct($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM barang_keluar WHERE id = $id");

    return mysqli_affected_rows($conn);
}

// ===FUNCTION EDIT===
function ubahreports($data)
{
    global $conn;

    $id = $data["id"];
    $product_name = htmlspecialchars($data["product_name"]);
    $codeProduct = htmlspecialchars($data["product_code"]);
    $qty = htmlspecialchars($data["quantity"]);
    $date = ($data["date"]);
    $id_report = htmlspecialchars($data["id_report"]);
    $status = htmlspecialchars($data["status"]);
    $performa = htmlspecialchars($data["performa"]);

    // query insert data baru
    $query = "UPDATE reports 
                SET    
                product_name = '$product_name',
                product_code = '$codeProduct',
                quantity = '$qty',
                date = '$date',
                id_report = '$id_report',
                status = '$status',
                performa = '$performa'
                WHERE id = $id
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// ==========================END REPORTS===========================
