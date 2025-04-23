module.exports = {
    content: [
      './src/**/*.{js,jsx,ts,tsx,scss}',
      './**/*.php'
    ],
    theme: { extend: {
        /* NOTE: not working with live reload - have added font vars via utilities in vite.css*/
        body: ['var(--font-body)', 'QuicksandRegular', 'Arial', 'sans-serif'],
        bodybold: ['var(--font-bodybold)', 'QuicksandBold', 'Arial', 'sans-serif'],
        display: ['var(--font-display)', 'SpecialElite', 'Arial', 'sans-serif'],
    } },
    plugins: []
  }
  

  