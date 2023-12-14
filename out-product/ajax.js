// hilangkan tombol cari
$("#tombol-cari").hide();

// AJAX JQUERY
// $(document).ready(function () {
//   // event ketika keyword ditulis
//   $("#keyword").on("keyup", function () {
//     $("#containers").load(
//       "../ajax/out-product.php?keyword=" +
//         encodeURIComponent($("#keyword").val())
//     );
//   });
// });

$(document).ready(function () {
  $("#keyword").on("keyup", function () {
    var keyword = $("#keyword").val();
    $("#containers").load(
      "../ajax/out-product.php?keyword=" + encodeURIComponent(keyword),
      function (response, status, xhr) {
        if (status == "error") {
          $("#containers").html(
            "Terjadi kesalahan: " + xhr.status + " " + xhr.statusText
          );
        } else if (response.trim() === "") {
          $("#containers").html("Data tidak ada.");
        }
      }
    );
  });
});
