/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#007daf',
        secondary: '#c771d4',
        accent: '#ffb829',
      },
    },
  },
  plugins: [],
}
