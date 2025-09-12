// In src/js/sliders.js

import Swiper from "swiper";
// We need to import the Navigation and Pagination modules for the arrows and dots
import { Navigation, Pagination } from "swiper/modules";

// Import the required CSS for Swiper
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// Initialize Swiper on any element with the class ".swiper"
const swiper = new Swiper(".swiper", {
  // Use the imported modules
  modules: [Navigation, Pagination],

  // Configuration
  loop: true, // Loop the slides
  slidesPerView: 3, // Show 3 slides at a time on desktop
  spaceBetween: 30, // Add 30px of space between slides

  // Navigation arrows
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },

  // Pagination dots
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  }
});
