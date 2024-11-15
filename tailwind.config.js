/** @type {import('tailwindcss').Config} */

import tailwindScrollbar from 'tailwind-scrollbar'

module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Inter', 'sans-serif'],
      }
    },
  },
  plugins: [tailwindScrollbar()],
}
