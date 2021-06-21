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
            },
            fontFamily: {
                sans: ['Poppins'],
                num: ['Nunito'],
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
