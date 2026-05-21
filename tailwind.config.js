import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                // Palette del portale — identica al prototipo HTML
                navy:    '#0D2B4B',
                'navy-dark': '#1C2833',
                blue:    '#1A5276',
                sky:     '#2E86C1',
                gold:    '#D4AC0D',
                amber:   '#F39C12',
                light:   '#D6EAF8',
                offwhite: '#F4F6F7',
            },
            fontFamily: {
                sans: ['Inter', 'Segoe UI', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(160deg, #0D2B4B 0%, #0a3d6b 40%, #1a6b8a 100%)',
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'fade-in': 'fadeIn 0.5s ease-in-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms, typography],
};
