<?php

require '../functions.php';

if ( isset ( $_POST['checkbox'][0] ) ) {
	
    foreach($_POST['checkbox'] as $list) {

		$id=mysqli_real_escape_string($conn,$list);
		mysqli_query($conn,"delete from suppliers where id='$id'");
	}
}

// $id = $_GET["id"];

// if (hapussupplier($id) > 0) {

//     echo "
//             <script>
//                 alert('data berhasil dihapus');
//                 document.location.href = 'suppliers.php';
//             </script>
//         ";

// } else {
//     echo "
//             <script>
//                 alert('data gagal dihapus');
//                 document.location.href = 'suppliers.php';
//             </script>
//         ";
// }

?>