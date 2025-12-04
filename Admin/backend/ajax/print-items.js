let offset = 0;
const limit = 4;
const listContainer = document.getElementById("listContainer");
const loadMoreBtn = document.getElementById("loadMoreBtn");

function fetchProducts() {
  let formData = new FormData();
  formData.append("offset", offset);
  formData.append("limit", limit);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "backend/php/print-data.php", true);

  xhr.onload = () => {
    if (xhr.status === 200) {
      const data = xhr.response.trim();

      if (data === "no_more") {
        loadMoreBtn.disabled = true;
        loadMoreBtn.innerText = "No more products";
        return;
      }

      listContainer.innerHTML += data;
      offset += limit;
    }
  };

  xhr.send(formData);
}

// First load
fetchProducts();

// On button click → load next 4
loadMoreBtn.addEventListener("click", fetchProducts);
