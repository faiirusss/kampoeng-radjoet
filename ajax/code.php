<?php

require '../functions.php';

if (isset($_POST['click_view_btn'])) {

    $id = $_POST['user_id'];
    // echo $id;

    $fetch_query = "SELECT * FROM barang_masuk WHERE id='$id'";
    $fetch_query_run = mysqli_query($conn, $fetch_query);

    if (mysqli_num_rows($fetch_query_run) > 0) {
        while ($row = mysqli_fetch_array($fetch_query_run)) {
?>
            <table>
                <tr>
                    <td width="50">
                        <img width="150px" src="images/<?php echo $row['foto'] ?>">
                    </td>
                    <td style="padding:20px">
                        <p>Pengrajin : <?php echo $row['pengrajin'] ?></p>
                        <p>Nama Produk : <?php echo $row['nama_produk'] ?></p>
                        <p>Kategori : <?php echo $row['kategori'] ?></p>
                        <p>Kondisi : <?php echo $row['kondisi'] ?></p>
                        <p>SKU : <?php echo $row['sku'] ?></p>
                        <p>Harga : <?php echo $row['harga'] ?></p>
                        <p>Tanggal : <?php echo $row['tanggal'] ?></p>
                        <p>Stok : <?php echo $row['stok'] ?></p>
                        <p>Deskripsi : <?php echo $row['deskripsi'] ?></p>
                        <center><img src="../barcode.php?codetype=Code128&size=40&text=<?php echo $row["barcode"];  ?>&print=true" alt="barcode"></center>
                    </td>

                </tr>
            </table>

        <?php } ?>
    <?php } ?>
<?php } ?>