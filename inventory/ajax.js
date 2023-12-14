// hilangkan tombol cari
$("#tombol-cari").hide();

// AJAX JQUERY
$(document).ready(function () {
  // event ketika keyword ditulis
  $("#keyword").on("keyup", function () {
    $("#containers").load(
      "../ajax/inventory.php?keyword=" + encodeURIComponent($("#keyword").val())
    );
  });
});

function select_all() {
  if (jQuery("#delete").prop("checked")) {
    jQuery("input[type=checkbox]").each(function () {
      jQuery("#" + this.id).prop("checked", true);
    });
  } else {
    jQuery("input[type=checkbox]").each(function () {
      jQuery("#" + this.id).prop("checked", false);
    });
  }
}

function delete_all() {
  var check = confirm("Apakah kamu yakin menghapus?");
  if (check == true) {
    jQuery.ajax({
      url: "remove.php",
      type: "post",
      data: jQuery("#frm").serialize(),
      success: function (result) {
        jQuery("input[type=checkbox]").each(function () {
          if (jQuery("#" + this.id).prop("checked")) {
            jQuery("#box" + this.id).remove();
          }
        });

        // Setelah menghapus data, refresh halaman
        window.location.href = "inventory.php";
      },
    });
  }
}

function print_barcode() {
  var check = confirm("Apakah kamu yakin print?");
  if (check == true) {
    var selectedIds = []; // Array untuk menyimpan ID yang dicentang

    // Loop melalui setiap checkbox dan periksa apakah dicentang
    jQuery("input[type=checkbox]").each(function () {
      if (jQuery(this).prop("checked")) {
        // Ambil ID dari checkbox yang dicentang dan tambahkan ke array
        selectedIds.push(this.id);
      }
    });

    // Kirim ID yang dicentang ke printbarcode.php melalui Ajax
    jQuery.ajax({
      url: "../printbarcode.php",
      type: "post",
      data: { selectedIds: selectedIds }, // Mengirim array ID
      success: function (result) {
        // Redirect ke printbarcode.php setelah berhasil
        window.location.href = "../inventory/inventory.php";
      },
    });
  }
}
