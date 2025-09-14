export function initProjectGallery() {
  const root = document.getElementById("pjx-gallery");
  if (!root) return;

  const slides = Array.from(root.querySelectorAll(".pjx-slide"));
  const thumbs = Array.from(document.querySelectorAll(".pjx-thumb"));
  const prev = root.querySelector(".pjx-prev");
  const next = root.querySelector(".pjx-next");
  const counter = root.querySelector(".pjx-counter");

  let i = 0;
  const show = idx => {
    i = (idx + slides.length) % slides.length;
    slides.forEach((el, n) => el.classList.toggle("opacity-100", n === i));
    slides.forEach((el, n) => el.classList.toggle("opacity-0", n !== i));
    thumbs.forEach((t, n) => {
      t.classList.toggle("ring-2", n === i);
      t.classList.toggle("ring-gray-900", n === i);
      t.classList.toggle("opacity-70", n !== i);
    });
    if (counter) counter.textContent = `${i + 1} / ${slides.length}`;
  };

  prev?.addEventListener("click", () => show(i - 1));
  next?.addEventListener("click", () => show(i + 1));
  thumbs.forEach(t => t.addEventListener("click", () => show(parseInt(t.dataset.index, 10))));

  show(0);
}
