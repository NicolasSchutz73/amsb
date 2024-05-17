import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                test : '#ffe5e5',
                red: {
                    50: '#ffe5e5',
                    100: '#ffcccc',
                    200: '#ff9999',
                    300: '#ff6666',
                    400: '#ff3333',
                    500: '#d81e00', // Votre couleur rouge primaire personnalisée
                    600: '#bf1a00',
                    700: '#a61700',
                    800: '#8c1300',
                    900: '#730f00',
                },
            },
        },
    },

    plugins: [forms],
};
