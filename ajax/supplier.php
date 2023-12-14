<?php

require '../functions.php';

// pagination
// konfigurasi
$jumlahDataPerHalaman = 10;
// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM suppliers"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
// ternary 
if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$keyword = $_GET["keyword"];
$query = "SELECT * FROM suppliers
            WHERE
            name LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            phone LIKE '%$keyword%' OR
            started LIKE '%$keyword%' OR
            status LIKE '%$keyword%' 
            LIMIT $awal_data, $jumlahDataPerHalaman";

$suppliers = query($query);

?>

<table class=" table table-hover">
    <thead class="table table-sm" valign="middle">
        <tr>
            <th>
                <input class="ms-2" type="checkbox" onclick="select_all()" id="delete">
            </th>
            <th>Suppplier</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Start Join</th>
            <th>Status</th>
            <th>Action</th>
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