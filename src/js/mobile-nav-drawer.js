export function initMobileNavDrawer() {
  const toggle = document.getElementById("mobile-nav-toggle");
  const shell = document.getElementById("mobile-shell");
  const drawer = document.getElementById("mobile-nav");
  const backdrop = document.getElementById("mobile-backdrop");
  const closeBtn = document.getElementById("mobile-close");
  const iconOpen = document.getElementById("icon-open");
  const iconClose = document.getElementById("icon-close");
  if (!toggle || !shell || !drawer || !backdrop) return;

  const isOpen = () => drawer.classList.contains("translate-x-0");
  const lockBody = lock => {
    document.body.style.overflow = lock ? "hidden" : "unset";
  };

  function setOpen(open) {
    // overlay shell visibility + pointer events
    shell.classList.toggle("opacity-100", open);
    shell.classList.toggle("visible", open);
    shell.classList.toggle("opacity-0", !open);
    shell.classList.toggle("invisible", !open);
    shell.classList.toggle("pointer-events-auto", open);
    shell.classList.toggle("pointer-events-none", !open);

    // drawer slide
    drawer.classList.toggle("translate-x-0", open);
    drawer.classList.toggle("translate-x-full", !open);

    // backdrop fade
    backdrop.classList.toggle("opacity-100", open);
    backdrop.classList.toggle("opacity-0", !open);

    // icons
    if (iconOpen && iconClose) {
      iconOpen.classList.toggle("hidden", open);
      iconClose.classList.toggle("hidden", !open);
    }

    toggle.setAttribute("aria-expanded", open ? "true" : "false");
    lockBody(open);

    // Stagger (optional)
    const items = drawer.querySelectorAll(".mobile-stagger");
    items.forEach((li, idx) => {
      const delay = open ? 100 * (idx + 1) : 0;
      li.style.transitionDelay = open ? `${delay}ms` : "0ms";
      li.classList.toggle("translate-x-0", open);
      li.classList.toggle("opacity-100", open);
      li.classList.toggle("translate-x-8", !open);
      li.classList.toggle("opacity-0", !open);
    });
  }

  setOpen(false);

  toggle.addEventListener("click", () => setOpen(!isOpen()));
  backdrop.addEventListener("click", () => setOpen(false));
  if (closeBtn) closeBtn.addEventListener("click", () => setOpen(false));
  drawer.addEventListener("click", e => {
    if (e.target.closest("a")) setOpen(false);
  });
}
