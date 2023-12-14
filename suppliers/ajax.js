// hilangkan tombol cari
$("#tombol-cari").hide();

// AJAX JQUERY
$(document).ready(function () {
  // event ketika keyword ditulis
  $("#keyword").on("keyup", function () {
    $("#containers").load(
      "../ajax/supplier.php?keyword=" + encodeURIComponent($("#keyword").val())
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
  var check = confirm("Are you sure?");
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

        window.location.href = "suppliers.php";
      },
    });
  }
}

$(document).ready(function () {
  // Update label value display in real-time
  $("input[type='range']").on("input", function () {
    $(this).next(".label-value").text($(this).val());
  });
});
