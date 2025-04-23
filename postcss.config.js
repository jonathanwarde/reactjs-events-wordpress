// postcss.config.js
module.exports = {
  plugins: [
    require('postcss-normalize')(),
    require('@tailwindcss/postcss')(),   // ← the NEW PostCSS plugin for Tailwind v4+
    require('autoprefixer')(),
  ]
}


