const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/tw-elements/dist/js/**/*.js',
        './src/**/*.{html,js}'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                male: {
                    1: '#7dd3fc',
                    2: '#38bdf8',
                    3: '#0ea5e9',
                },
                female: {
                    1: '#fbcfe8',
                    2: '#f472b6',
                    3: '#ec4899',
                },
                andro: {
                    1: '#9ca3af',
                    2: '#6b7280',
                    3: '#4b5563',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('tw-elements/dist/plugin')],
};
