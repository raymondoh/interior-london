// src/js/main.js
import { initHeroSlider } from "./hero-slider.js";
import { initMobileNavDrawer } from "./mobile-nav-drawer.js";
import { initProjectGallery } from "./project-gallery.js";
import { initLoadMore } from "./load-more.js";

document.addEventListener("DOMContentLoaded", () => {
  initHeroSlider();
  initMobileNavDrawer();
  initProjectGallery();
  initLoadMore();
});
