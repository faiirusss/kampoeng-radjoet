<?php

require '../functions.php';

// PAGINATION
// KONFIGURASI
$jumlahDataPerHalaman = 10;

// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM barang_keluar"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

// inisiasi untuk nomor pada awal data
$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$keyword = $_GET["keyword"];
$query = "SELECT * FROM barang_keluar
            WHERE
            nama_produk LIKE '%$keyword%' OR
            warna LIKE '%$keyword%' OR
            tanggal LIKE '%$keyword%' OR
            stok LIKE '%$keyword%' OR
            sku LIKE '%$keyword%' OR
            harga LIKE '%$keyword%' OR
            barcode LIKE '%$keyword%'
            LIMIT $awal_data, $jumlahDataPerHalaman";

$products = query($query);
?>

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