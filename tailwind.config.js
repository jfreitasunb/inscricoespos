/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

const defaultTheme = require('tailwindcss/defaultTheme')

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
        'azul-MAT': '#009FE5',
        'verde-MAT': '#449D44',
    },
    extend: {
        fontFamily: {
        'sans': ['Proxima Nova', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [],
}

