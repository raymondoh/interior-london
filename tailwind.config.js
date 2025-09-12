/** @type {import('tailwindcss').Config} */
export default {
  content: ["./**/*.php", "./src/**/*.{js,ts}"],

  // v5: use a flat 'extend' block instead of theme:{extend:{}}
  extend: {
    // put custom tokens here later, e.g.:
    // colors: { brand: "#111827" },
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
