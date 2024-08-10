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
        hover: {
          DEFAULT: "#7A2757",
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
  variants: {
    extend: {
      display: ['group-hover'],
      visibility: ['group-hover'],
    }
  },
  plugins: [],
}

