/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      animation: {
        toast: 'toast 4s ease-in-out forwards'
      },
      keyframes: {
        toast: {
          '0%': { display: 'flex', opacity: 0 },
          '25%, 75%': { opacity: 1 },
          '100%': { display: 'none', opacity: 0 },
        },
        ping: {
          '75%, 100%': {
            transform: 'scale(1.5)',
            opacity: 0,
          }
        }
      },
      fontFamily : {
        'roboto' : ['Roboto Flex', 'sans-serif'],
        'inter' : ['Inter', 'sans-serif'],
      },

      colors : {
        project : {
          primary : {'900': '#111211', '800':'#191A19', '700':'#232523', '600':'#313532', '500':'#484C49'},
          dominant : '#fff',
          accent : {'900':'#031708', '800':'#0B4119', '700':'#178232', '600':'#29A347', '500':'#33CC59', '400': '#42D767', '300': '#7DE898', '200': '#A6F2B9', '100': '#D1FADB'},
          gray: { default: '#E5E5EA', light: "#F9FAFB", dark: "#3A3A3C", disabled: "#BABAC5"}
        }
      }
    },
  },
  plugins: [],
}