const form = document.getElementById("formCard");
const visualizer = document.getElementById("visualizer");

form.addEventListener("submit", function (e) {
  e.preventDefault();

  const fileInput = form.querySelector('input[type="file"]');
  const imageFile = fileInput.files[0];

  if (imageFile) {
    const reader = new FileReader();
    reader.onload = function (event) {
      const img = new Image();
      img.src = event.target.result;

      img.onload = function () {
        const canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;

        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);

        canvas.toBlob(
          function (blob) {
            const formData = new FormData(form);
            formData.delete(fileInput.name); // Remove original image
            formData.append(fileInput.name, blob, "image.jpeg"); // Add JPEG blob

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "backend/php/save-data.php", true);

            xhr.onload = function () {
              const datas = xhr.response;
              if (xhr.status === 200 && datas === "saved") {
                showMessage("Publié avec succès!", "#009600");
                form.reset();
              } else {
                showMessage(
                  datas || "Erreur lors de la publication.",
                  "#ec8484"
                );
              }
            };
            xhr.send(formData);
          },
          "image/jpeg",
          0.7
        ); // Convert to WebP with 80% quality
      };
    };
    reader.readAsDataURL(imageFile);
  } else {
    showMessage("Aucun fichier sélectionné.", "#ec8484");
  }
});

function showMessage(text, color) {
  visualizer.style.display = "block";
  visualizer.style.backgroundColor = color;
  visualizer.style.color = "#fff";
  visualizer.innerHTML = text;
  setTimeout(() => {
    visualizer.style.display = "none";
    visualizer.innerHTML = "";
  }, 3000);
}
