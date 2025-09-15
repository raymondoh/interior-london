// src/js/main.js
import { initHeroSlider } from "./hero-slider.js";
import { initMobileNavDrawer } from "./mobile-nav-drawer.js";
import { initProjectGallery } from "./project-gallery.js";
import { initLoadMore } from "./load-more.js";
import { initAboutTeamSlider } from "./about-team-slider.js";
import { initSimilarProjectsSlider } from "./similar-projects-slider.js";

document.addEventListener("DOMContentLoaded", () => {
  console.log("[main.js] DOM loaded, looking for mobile nav trigger");
  initHeroSlider();
  initMobileNavDrawer();
  initProjectGallery();
  initLoadMore();
  initAboutTeamSlider();
  initSimilarProjectsSlider();
});
