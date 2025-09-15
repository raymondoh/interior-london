export function initAboutTeamSlider() {
  const el = document.getElementById("about-team-swiper");
  // Swiper is conditionally enqueued by your PHP module flag
  if (!el || typeof Swiper === "undefined") return;

  // Prevent double-init if hot reloading / partial nav
  if (el.dataset.initialized === "1") return;

  new Swiper(el, {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 16,
    pagination: {
      el: el.querySelector(".swiper-pagination"),
      clickable: true
    },
    // Nice gentle feel
    speed: 550
  });

  el.dataset.initialized = "1";
}
