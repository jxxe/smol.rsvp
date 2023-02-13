const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.{php,js,svelte}'
    ],
    theme: {
        extend: {
            colors: {
                gray: colors.neutral
            },
            borderColor: {
                DEFAULT: colors.neutral[200]
            },
            fontFamily: {
                sans: ['"SF Pro"', '"Inter"', 'sans-serif']
            }
        }
    },
    plugins: [
    ]
}