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
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
};