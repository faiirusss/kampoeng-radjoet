// !dropdown kategori
const selectArea = document.querySelector(".select-field");
const selectList = document.querySelector(".select-list");
const selectItems = document.querySelectorAll(".select-items");

selectItems.forEach((option) => {
  option.addEventListener("click", () => {
    let selectOption = option.querySelector(".select-items p").innerHTML;
    document.getElementById("input").placeholder = selectOption;
    console.log(selectOption);

    selectList.classList.remove("active");

    document.querySelector(".select-btn i").classList.remove("bx-chevron-up");
  });
});

selectArea.addEventListener("click", () => {
  selectList.classList.toggle("active");

  document.querySelector(".select-btn i").classList.toggle("bx-chevron-up");
});
