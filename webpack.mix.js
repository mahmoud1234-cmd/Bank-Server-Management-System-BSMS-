const mix = require('laravel-mix');

mix.react('resources/js/app.jsx', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .version();
