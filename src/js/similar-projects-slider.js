export function initSimilarProjectsSlider() {
  const el = document.getElementById("similar-projects-swiper");
  if (!el || typeof Swiper === "undefined") return;

  const slidesCount = el.querySelectorAll(".swiper-slide").length;
  const shouldLoop = slidesCount >= 4;

  // eslint-disable-next-line no-undef
  new Swiper(el, {
    slidesPerView: 1.1,
    spaceBetween: 16,
    loop: shouldLoop,
    watchOverflow: true,
    grabCursor: true,

    breakpoints: {
      640: { slidesPerView: 1.5, spaceBetween: 20 },
      768: { slidesPerView: 2, spaceBetween: 24 },
      1024: { slidesPerView: 3, spaceBetween: 24 }
    },

    pagination: {
      el: el.querySelector(".swiper-pagination"),
      clickable: true
    },

    a11y: { enabled: true }
  });
}
