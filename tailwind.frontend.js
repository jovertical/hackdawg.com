module.exports = {
    purge: ['./resources/views/**/*.blade.php', '!./resources/views/backend'],
    theme: {
        extend: {
            colors: {
                blue: {
                    default: '#007CFF',
                },

                indigo: {
                    light: '#4219E5',
                    default: '#2B00D4',
                },

                green: {
                    lighter: '#00CFBE',
                    default: '#266963',
                    darker: '#003B36',
                    darkest: '#042825',
                },

                red: {
                    default: '#C81313',
                },

                yellow: {
                    default: '#FFDB69',
                },
            },

            zIndex: {
                '-1': '-1',
            },

            minHeight: {
                '72': '18rem',
                '84': '21rem',
                '96': '24rem',
            },

            spacing: {
                '3px': '3px',
                '72': '18rem',
                '84': '21rem',
                '96': '24rem',
            },

            borderWidth: {
                '1/2px': '0.5px',
            },
        },
    },
    variants: {},
    plugins: [],
};
