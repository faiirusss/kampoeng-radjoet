//!multiple photo
const dropArea = document.querySelector(".drop-area");
const inputFile = document.getElementById("input-file");

dropArea.addEventListener("click", function () {
  inputFile.click();
});

inputFile.addEventListener("change", function () {
  const file = this.files[0];

  if (file.type.startsWith("image/")) {
    if (file.size < 2000000) {
      create_thumbnail(file);
    } else {
      alert("Image size must be less than 2MB");
    }
  } else {
    alert("Must be image");
  }
});

dropArea.addEventListener("dragover", function (e) {
  e.preventDefault();
  this.style.borderStyle = "solid";

  const h3 = this.querySelector("h3");
  h3.textContent = "Release here to upload image";
});

dropArea.addEventListener("drop", function (e) {
  e.preventDefault();

  inputFile.files = e.dataTransfer.files;
  const file = e.dataTransfer.files[0];

  if (file.type.startsWith("image/")) {
    if (file.size < 2000000) {
      create_thumbnail(file);
    } else {
      alert("Image size must be less than 2MB");
    }
  } else {
    alert("Must be image");
  }
});

const command = ["dragleave", "dragend"];

command.forEach((item) => {
  dropArea.addEventListener(item, function () {
    this.style.borderStyle = "dashed";

    const h3 = this.querySelector("h3");
    h3.textContent = "Drag and drop or click here to select image";
  });
});

function create_thumbnail(file) {
  const img = document.querySelectorAll(".thumbnail");
  const imgName = document.querySelectorAll(".img-name");
  img.forEach((item) => item.remove());
  imgName.forEach((item) => item.remove());

  const reader = new FileReader();
  reader.onload = () => {
    const url = reader.result;
    const img = document.createElement("img");
    img.src = url;
    img.className = "thumbnail";
    const span = document.createElement("span");
    span.className = "img-name";
    span.textContent = file.name;
    dropArea.appendChild(img);
    dropArea.appendChild(span);
    dropArea.style.borderColor = "transparent";
  };
  reader.readAsDataURL(file);
}

document.getElementById("warna").addEventListener("change", function () {
  var warnaDropdown = this.value;
  var inputWarnaLainnya = document.getElementById("inputWarnaLainnya");

  if (warnaDropdown === "lainnya") {
    inputWarnaLainnya.style.display = "block";
  } else {
    inputWarnaLainnya.style.display = "none";
  }
});

// Tambahkan event listener untuk memantau perubahan pada dropdown kategori
document.getElementById("kategori").addEventListener("change", function () {
  var selectedValue = this.value;
  var inputKategoriBaru = document.getElementById("inputKategoriBaru");

  // Tampilkan atau sembunyikan input kategori baru berdasarkan pilihan dropdown
  if (selectedValue == "lainnya") {
    inputKategoriBaru.style.display = "block";
  } else {
    inputKategoriBaru.style.display = "none";
  }
});
