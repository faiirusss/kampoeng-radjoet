// performa_update.js

$(document).ready(function () {
  $(".performa-range").on("input", function () {
    var supplierId = $(this).data("supplier-id");
    var newValue = $(this).val();

    // Update the label value dynamically
    updateLabelValue(this);

    // Update the Indikator column
    updateIndikator(supplierId, newValue);

    // Handle AJAX request to update the database
    handleRangeChange(supplierId, newValue);
  });
});

function updateLabelValue(rangeInput) {
  var spanId = "labelValue" + rangeInput.id;
  var labelValueSpan = document.getElementById(spanId);

  if (labelValueSpan) {
    labelValueSpan.innerText = rangeInput.value;
  }
}

function updateIndikator(supplierId, value) {
  // Update the Indikator column based on the range value
  var indikatorSpan = $("#indikator" + supplierId);

  if (indikatorSpan) {
    var indikatorText = value > 50 ? "Rajin" : value < 50 ? "Malas" : "Normal";
    indikatorSpan.text(indikatorText);
  }
}

function handleRangeChange(supplierId, newValue) {
  $.ajax({
    type: "POST",
    url: "update_performa.php", // Replace with your server-side script to handle the database update
    data: {
      supplierId: supplierId,
      newValue: newValue,
    },
    success: function (response) {
      // Handle success (if needed)
      console.log(response);
    },
    error: function (error) {
      // Handle errors (if needed)
      console.error(error);
    },
  });
}
