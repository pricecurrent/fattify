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
            },
            fontFamily: {
                sans: ['Poppins']
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
