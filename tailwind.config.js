const defaultTheme = require("tailwindcss/defaultTheme");
const plugin = require("tailwindcss/plugin");

module.exports = {
  mode: "jit",
  darkMode: "class",
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./vendor/laravel/jetstream/**/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
  ],

  theme: {
    extend: {
      fontFamily: {
        fira: ["'Fira Sans', sans-serif"],
      },
      fontSize: {
        'xxs': '10px',
      },
      colors: {
        transparent: "transparent",
        current: "currentColor",
        primary: "#003973",
        secondary: "#EC3237",
        "primary-light": "#cce6ff",
        background: "#e6f2ff",
        input: "#c4c4c4",
        tertiary: "#0B4654",
        placeholder: "#CEE2DA",
        dark: "#02160E",
        table: "#f38111",
        "secondary-light": "#F38111",
        grade: "#CFC700",
      },
    },
  },
  variants: {
    extend: {
      backgroundColor: ["checked", "disabled"],
      opacity: ["dark"],
      overflow: ["hover"],
    },
  },

  plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};
