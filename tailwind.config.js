/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./dist/*.{html,js,php}"],
           
  theme: {
    extend: {
      fontFamily:{
        body : ['Quicksand']
      }
    },
  },
  plugins: [],
}

