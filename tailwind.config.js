/** @type {import('tailwindcss').Config} */
module.exports = {
  enabled: true,
  content: ['./src/**/*.{js,jsx,ts,tsx}', './public/master.php', './**/*.php'],
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
  fontFamily: {
    'sans': ['Karla', 'sans-serif']
  },
  letterSpacing: {
    '-0.4px': '-0.4px',
  }
};


