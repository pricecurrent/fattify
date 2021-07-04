const colors = require('tailwindcss/colors')
module.exports = {
    mode: 'jit',
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                'cool-gray': colors.coolGray,
                gray: colors.blueGray,
                orange: colors.orange,
                fuchsia: colors.fuchsia,
                sky: colors.sky,
                lime: colors.lime,
                cyan: colors.cyan,
                violet: colors.violet,
                rose: colors.rose,
                amber: colors.amber,
                teal: colors.teal,
                emerald: colors.emerald,
            },
            fontFamily: {
                sans: ['Poppins'],
                num: ['Nunito'],
            },
            animation: {
                input: "scale-input 0.2s forwards",
            },
            keyframes: {
                'scale-input': {
                    '0%': { transform: "translate(0px, 0px) scale(1)" },
                    '33%': { transform: "translate(5px, 0px) scale(1.02)" },
                    '66%': { transform: "translate(-5px, 0px) scale(0.98)" },
                    '100%': { transform: "translate(0px, 0px) scale(1.05)" },
                },
            },
            spacing: {
                "safe-top": "env(safe-area-inset-top)",
                "safe-bottom": "env(safe-area-inset-bottom)",
                "safe-left": "env(safe-area-inset-left)",
                "safe-right": "env(safe-area-inset-right)",
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
