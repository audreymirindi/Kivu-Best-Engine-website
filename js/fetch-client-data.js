let offset = 0;
const limit = 4;
const listContainer = document.getElementById("cards");
const loadMoreBtn = document.getElementById("loadmoreBtn");
const spinner = document.getElementById("spinner");

function fetchProducts() {
  // Show spinner
  spinner.style.display = "block";
  loadMoreBtn.disabled = true;

  let formData = new FormData();
  formData.append("offset", offset);
  formData.append("limit", limit);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "fetch-data.php", true);

  xhr.onload = () => {
    // Hide spinner
    spinner.style.display = "none";
    loadMoreBtn.disabled = false;

    if (xhr.status === 200) {
      const data = xhr.response.trim();

      if (data === "no_more") {
        loadMoreBtn.disabled = true;
        loadMoreBtn.innerText = "Pas de produits disponible";
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

// Button loads more
loadMoreBtn.addEventListener("click", fetchProducts);
