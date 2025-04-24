module.exports = {
    content: [
      './src/**/*.{js,jsx,ts,tsx,scss}',
      './**/*.php'
    ],
    theme: { extend: {
        fontFamily: {
            /* NOTE: not working with live reload - have added font vars via utilities in vite.css*/
            body: ['var(--font-body)', 'QuicksandRegular', 'Arial', 'sans-serif'],
            bodylight: ['var(--font-body-light)', 'QuicksandLight', 'Arial', 'sans-serif'],
            bodybold: ['var(--font-bodybold)', 'QuicksandBold', 'Arial', 'sans-serif'],
            display: ['var(--font-display)', 'SpecialElite', 'Arial', 'sans-serif'],
        },
        textColor: {
            primary: 'var(--text-primary)', 
            secondary: 'var(--text-secondary)',
        },
        backgroundColor: {
            primary: 'var(--text-primary)', 
            secondary: 'var(--text-secondary)', 
          },
        spacing: {
            15: '60px', 
        },
        colors: {
          primary: 'var(--text-primary)',  
    } },
    plugins: []
  }
  

  