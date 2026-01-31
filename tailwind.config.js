import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {

    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

theme: {
    extend: {
        fontFamily: {
            // "When I say font-sans, use Inter"
            sans: ['Inter', 'sans-serif'], 
            
            // "When I say font-serif, use Merriweather"
            serif: ['Merriweather', 'serif'],
        },
    },
},

    plugins: [forms],
};
