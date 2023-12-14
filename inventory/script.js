const body = document.querySelector("body"),
  sidebar = body.querySelector("nav"),
  toggle = body.querySelector(".toggle");

toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

const searchBox = document.querySelector(".search-box");
const searchBtn = document.querySelector(".search-icon");
const cancelBtn = document.querySelector(".cancel-icon");
const searchInput = document.querySelector(".search");
const searchData = document.querySelector(".search-data");

searchBtn.onclick = () => {
  searchBox.classList.add("actived");
  searchBtn.classList.add("actived");
  searchInput.classList.add("actived");
  cancelBtn.classList.add("actived");
  searchInput.focus();
  if (searchInput.value != "") {
    var values = searchInput.value;
    searchData.classList.remove("actived");
    searchData.innerHTML =
      "You just typed " +
      "<span style='font-weight: 500;'>" +
      values +
      "</span>";
  } else {
    searchData.textContent = "";
  }
};
cancelBtn.onclick = () => {
  searchBox.classList.remove("actived");
  searchBtn.classList.remove("actived");
  searchInput.classList.remove("actived");
  cancelBtn.classList.remove("actived");
  searchData.classList.toggle("actived");
  searchInput.value = "";
};
