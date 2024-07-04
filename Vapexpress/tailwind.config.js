/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",],
  theme: {
    extend: {
      colors: {
        navbar: {
          DEFAULT: "#932F6D",
        },
        primary: {
          DEFAULT: "#DCCCFF",
        },
        text_principal: {
          DEFAULT: "#420039",
        },
        text_navbar: {
          DEFAULT: "#FFFFFF",
          dark: '#DCCCFF'
        },
        text_a: {
          DEFAULT: "#FFFFFF",
          dark: '#DCCCFF'
        }
      }
    },
  },
  plugins: [],
}

