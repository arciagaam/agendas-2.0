/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily : {
        'roboto' : ['Roboto Flex', 'sans-serif'],
        'inter' : ['Inter', 'sans-serif'],
      },

      colors : {
        project : {
          primary : '#1e1e1e',
          dominant : '#fff',
          accent : '#34C759',
          gray: { default: '#E5E5EA', light: "#F9FAFB", dark: "#3A3A3C"}
        }
      }
    },
  },
  plugins: [],
}