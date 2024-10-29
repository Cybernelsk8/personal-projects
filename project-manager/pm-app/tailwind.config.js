/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'green-muni' : '#00bc70',
        'blue-muni' : '#1700a5',
        'lime-muni' : '#97d700',
      }
    },
  },
  plugins: [
    require('tailwindcss-animated')
  ],
}

