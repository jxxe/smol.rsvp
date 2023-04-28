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
                sans: ['"Figtree"', '"SF Pro"', 'sans-serif']
            },
            animation: {
                hover: 'hover 5s infinite cubic-bezier(0.445, 0.050, 0.550, 0.950)',
                hover2: 'hover 6s infinite -2s cubic-bezier(0.445, 0.050, 0.550, 0.950)',
                hover3: 'hover 8s infinite -1s cubic-bezier(0.445, 0.050, 0.550, 0.950)'
            }
        }
    },
    plugins: [
    ]
}