/** @type {import('tailwindcss').Config} */
export default {
  content: ["./**/*.php", "./src/**/*.{js,ts}"],

  // v5: use a flat 'extend' block instead of theme:{extend:{}}
  extend: {
    // You can extend your theme here if needed
    fontFamily: {
      sans: ["var(--font-geist-sans)", "ui-sans-serif", "system-ui"],
      mono: ["var(--font-geist-mono)", "ui-monospace"]
    }
  },

  plugins: [
    require("@tailwindcss/line-clamp")
    // Enable per project if needed:
    // require("@tailwindcss/forms"),
    // require("@tailwindcss/typography"),
    // require("tailwindcss-animate"),
    // require("daisyui"),
  ]

  // If you enable DaisyUI above, you can also pick themes:
  // daisyui: { themes: ["light", "dark"] },
};
