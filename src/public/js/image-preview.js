document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll("[data-preview-input]");

    inputs.forEach((input) => {
        const previewAreaSelector = input.dataset.previewArea;
        const keepSelector = input.dataset.previewKeep || null;

        const previewArea = document.querySelector(previewAreaSelector);
        if (!previewArea) return;

        input.addEventListener("change", (e) => {
        const file = e.target.files && e.target.files[0];
        if (!file) return;
        if (!file.type.startsWith("image/")) return;

        const reader = new FileReader();

        reader.onload = (event) => {
            const keepEl = keepSelector ? previewArea.querySelector(keepSelector) : null;

            previewArea.innerHTML = "";
            if (keepEl) previewArea.appendChild(keepEl);

            const img = document.createElement("img");
            img.src = event.target.result;
            img.alt = "preview";

            previewArea.appendChild(img);
        };

        reader.readAsDataURL(file);
        });
    });
});
