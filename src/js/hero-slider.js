// src/js/hero-slider.js
export function initHeroSlider() {
  const sliderSection = document.getElementById("hero-slider-section");
  if (!sliderSection) return;

  const slides = sliderSection.querySelectorAll(".hero-slide");
  const indicators = sliderSection.querySelectorAll(".hero-indicator");
  const prevButton = document.getElementById("hero-prev-slide");
  const nextButton = document.getElementById("hero-next-slide");

  // Dynamic text/CTAs (may exist only on hero pages)
  const heroTitle = document.getElementById("hero-title");
  const heroSubtitle = document.getElementById("hero-subtitle");
  const ctaPrimary = document.getElementById("hero-cta-primary");
  const ctaSecondary = document.getElementById("hero-cta-secondary");

  if (!slides.length) return;

  let currentSlide = 0;
  let slideInterval;

  function showSlide(index) {
    if (!slides[index]) return;

    slides.forEach((slide, i) => {
      slide.style.opacity = i === index ? "1" : "0";
    });

    indicators.forEach((indicator, i) => {
      indicator.classList.toggle("bg-white", i === index);
      indicator.classList.toggle("scale-125", i === index);
      indicator.classList.toggle("bg-white/50", i !== index);
    });

    // Update dynamic content from data-* on active slide
    const s = slides[index];
    if (heroTitle) heroTitle.innerHTML = s.dataset.title || "";
    if (heroSubtitle) heroSubtitle.textContent = s.dataset.subtitle || "";

    if (ctaPrimary) {
      if (s.dataset.primaryUrl) ctaPrimary.href = s.dataset.primaryUrl;
      if (s.dataset.primaryText) {
        // ensure text node exists as first child
        const txt = s.dataset.primaryText + " ";
        if (ctaPrimary.firstChild && ctaPrimary.firstChild.nodeType === Node.TEXT_NODE) {
          ctaPrimary.firstChild.nodeValue = txt;
        } else {
          ctaPrimary.insertBefore(document.createTextNode(txt), ctaPrimary.firstChild);
        }
      }
    }

    if (ctaSecondary) {
      if (s.dataset.secondaryUrl) ctaSecondary.href = s.dataset.secondaryUrl;
      if (s.dataset.secondaryText) ctaSecondary.textContent = s.dataset.secondaryText;
    }

    currentSlide = index;
  }

  function next() {
    showSlide((currentSlide + 1) % slides.length);
  }
  function prev() {
    showSlide((currentSlide - 1 + slides.length) % slides.length);
  }

  function startAutoplay() {
    clearInterval(slideInterval);
    slideInterval = setInterval(next, 5000);
  }
  function stopAutoplay() {
    clearInterval(slideInterval);
  }

  // Attach listeners only if elements exist
  if (nextButton)
    nextButton.addEventListener("click", () => {
      next();
      stopAutoplay();
      startAutoplay();
    });
  if (prevButton)
    prevButton.addEventListener("click", () => {
      prev();
      stopAutoplay();
      startAutoplay();
    });
  indicators.forEach(indicator => {
    indicator.addEventListener("click", e => {
      const i = parseInt(indicator.dataset.index, 10);
      if (!Number.isNaN(i)) {
        showSlide(i);
        stopAutoplay();
        startAutoplay();
      }
    });
  });

  // Init
  showSlide(0);
  startAutoplay();
}
