/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        greenJagat: '#2E6342',
        darkGreenJagat: '#1D462D',
      },
      fontFamily: {
        amiri: ['"Amiri"', 'sans-serif'],
        calistoga: ['"Calistoga"', 'sans-serif'],
      },
      keyframes: {
        'scroll-x': {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' },
        },
      },
      animation: {
        'scroll-x': 'scroll-x 15s linear infinite',
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('tailwind-clip-path'),
    function ({ addUtilities }) {
      addUtilities({
        // Hilangkan spinner untuk WebKit (Chrome, Safari)
        '.no-spinner::-webkit-inner-spin-button': {
          '-webkit-appearance': 'none',
          margin: '0',
        },
        '.no-spinner::-webkit-outer-spin-button': {
          '-webkit-appearance': 'none',
          margin: '0',
        },
        // Hilangkan spinner untuk Firefox
        '.no-spinner': {
          '-moz-appearance': 'textfield',
        },
      });
    }
  ],
};
