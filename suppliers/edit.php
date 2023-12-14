<?php

require '../functions.php';

// ambil data di url
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
$inven = query("SELECT * FROM suppliers WHERE id = $id")[0];

// cek apakah tombol submit sudah di tekan atau belum
if (isset($_POST["save"])) {

    if (ubahsupplier($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah');
                document.location.href = 'suppliers.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah');
                document.location.href = 'suppliers.php';
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
    <link rel="stylesheet" href="suppliers.css">

    <!--====== BOOTSTRAP======= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Inventory</title>
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
                            <span class="text nav-text">Inventory</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="../out-product/out-product.php">
                            <i class='bx bx-data icon'></i>
                            <span class="text nav-text">Out Products</span>
                        </a>
                    </li>

                    <li class="nav-link mb-4">
                        <a href="">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Suppliers</span>
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
        <div>
            <h1 class="text">SUPPLIERS</h1>
        </div>

        <div class="row g-0 mx-5 my-3 rounded-2">
            <div class="col-sm-6 col-md-10 shadow-sm p-3 mb-5 bg-body rounded">
                <div class="d-grid gap-2 d-md-flex justify-content-between">
                    <div class="text-start text-detail">Details Supplier</div>
                    <button class="edit-button edit-action" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class='bx bx-pencil me-1 edit-action'></i>Edit</i></button>
                </div>

                <div class="row mt-2 ">
                    <div class="col-8 my-3">
                        <ul class="nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Overview</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-6 mx-5">

                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $inven["id"] ?>">
                            <input type="hidden" name="image_old" value="<?php echo $inven["image"] ?>">
                            <div class="input-group">
                                <label class="input-group-text border-0 bg-body me-5" for="name">Nama</label>
                                <input class="form-control border-0 text-end" type="text" name="name" id="name" value="<?php echo $inven["name"] ?>">
                            </div>

                            <div class="input-group">
                                <label class="input-group-text border-0 bg-body me-1" for="email">Email</label>
                                <input class="form-control border-0 text-end" type="text" name="email" id="email" value="<?php echo $inven["email"] ?>">
                            </div>

                            <div class="input-group">
                                <label class="input-group-text border-0 bg-body me-1" for="phone">Phone</label>
                                <input class="form-control border-0 text-end" type="text" name="phone" id="phone" value="<?php echo $inven["phone"] ?>">
                            </div>

                            <div class="input-group">
                                <label class="input-group-text border-0 bg-body me-5" for="started">Started</label>
                                <input class="form-control border-0 text-end" type="text" name="started" id="started" value="<?php echo $inven["started"] ?>">
                            </div>

                            <div class="input-group">
                                <label class="input-group-text border-0 bg-body me-5" for="status">Status</label>
                                <input class="form-control border-0 text-end" type="text" name="status" id="status" value="<?php echo $inven["status"] ?>">
                            </div>
                            <div class="input-group">
                                <label class="input-group-text border-0 bg-body me-5" for="status">Performa</label>
                                <input class="form-control border-0 text-end" type="text" name="performa" id="performa" value="<?php echo $inven["performa"] ?>">
                            </div>
                    </div>
                    <div class="col-3 ms-5">
                        <table class="table">
                            <thead valign="center">
                                <tr>
                                    <center>
                                        <td class="ms-5" align="center" ;><img src="image/<?php echo $inven["image"]; ?>" width="150"></td>
                                    </center>
                                </tr>
                            </thead>
                        </table>
                        </form>
                    </div>
                </div>
                <button class="btn btn-secondary rounded-5 me-md-2 mt-5" type="button"><a href="suppliers.php" style="text-decoration: none; color:white; ">back</a></button>
            </div>
        </div>
    </section>


    <!--=====MODAL EDIT-INVENTORY=====-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $inven["id"] ?>">
                        <input type="hidden" name="image_old" value="<?php echo $inven["image"] ?>">

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="name" id="name" placeholder="Enter name" autocomplete="off" required value="<?php echo $inven["name"] ?>">
                                <label for="name" class="label">Name</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="email" id="email" placeholder="Enter email" required value="<?php echo $inven["email"] ?>">
                                <label for="email" class="label">Email</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="phone" id="phone" placeholder="Enter Phone number" required value="<?php echo $inven["phone"] ?>">
                                <label for="phone" class="label">Phone Number</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="date" name="started" id="started" placeholder="Start Joining" required value="<?php echo $inven["started"] ?>">
                                <label for="started" class="label">Started</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="status" value="<?php echo $inven["status"] ?>">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Not Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="performa">Performa:</label>
                                <input type="range" name="performa" id="performa" min="0" max="100" step="1" value="<?php echo $inven["performa"] ?>" oninput="updatePerformaValue(this)">
                                <span id="performaValue"><?php echo $inven["performa"] ?></span> <!-- Display the current value -->
                            </div>
                        </div>

                        <div class="form-group">
                            <center><img src="image/<?php echo $inven['image'] ?>" width="150"></center>
                            <div class="input-group">
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="image">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="save">Save</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!--=====MODAL EDIT-INVENTORY END=====-->
    <script>
        function updatePerformaValue(input) {
            // Get the value of the range input
            var newValue = input.value;

            // Update the span with the new value
            document.getElementById('performaValue').innerText = newValue;
        }
    </script>
    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>