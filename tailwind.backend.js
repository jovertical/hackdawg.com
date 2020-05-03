const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: ['./resources/backend/js/{Pages,Shared}/**/*.jsx', './resources/backend/views/**/*.blade.php'],
        whitelistPatternsChildren: [/nprogress/],
    },
    theme: {
        extend: {
            spacing: {
                '72': '18rem',
                '84': '21rem',
                '96': '24rem',
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/ui')],
};