module.exports = {
    mode: 'jit',
    content: [
        './resources/**/*.{html,js,jsx,vue,php}',
    ],
    darkMode: 'class',
    theme: {
        zIndex: {
            '5': 5,
            '10': 10,
            '15': 15,
            '20': 20,
            '25': 25,
            '30': 30,
            '35': 35,
            '40': 40,
            '45': 45,
            '50': 50,
            '75': 75,
            '100': 100,
            '200': 200,
            '999': 999,
            '1000': 1000,
            '9999': 9999,
            'auto': 'auto',
        },
        extend: {
            keyframes: {
                'fade-in-down': {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(-10px)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    },
                },
                'wiggle': {
                    '0%, 100%': { transform: 'rotate(-4deg)' },
                    '50%': { transform: 'rotate(4deg)' },
                }
            },
            animation: {
                'spin-slow': 'spin 3s linear infinite',
                'fade-in-down': 'fade-in-down 0.5s ease-out',
                'wiggle': 'wiggle 0.4s ease-in-out infinite'
            },
            colors: {
                theme: {
                    1: "#990011",
                    2: "#FCF6F5",
                },
                dark: {
                    1: "#181f29",
                    2: "#001433",
                }
            },
            fontFamily: {
                // add your custom fonts here
                'cataraman': ['Catamaran', 'sans-serif'],
            },
            backgroundImage: {
                'site-template__bg': "url('/images/logo.png') !important",
            }
        },
    },
}
