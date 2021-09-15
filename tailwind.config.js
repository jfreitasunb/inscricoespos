module.exports = {
  purge: [
     './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
     './public/css/*.css',
   ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
          'bg-azul-MAT':'#009FE5',
          'bg-verde-MAT':'#449D44',
        }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
