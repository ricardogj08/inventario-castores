/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./app/Views/**/*.php', './app/Cells/**/*.php'],
  theme: {
    extend: {}
  },
  plugins: [require('daisyui')],
  // daisyUI config
  daisyui: {
    themes: ['corporate']
  }
}
