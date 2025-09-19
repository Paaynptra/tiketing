import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    // Emerald/Teal oceanic spiritual palette
                    primary: {
                        DEFAULT: '#059669', // emerald-600
                        50: '#ECFDF5',
                        100: '#D1FAE5',
                        200: '#A7F3D0',
                        300: '#6EE7B7',
                        400: '#34D399',
                        500: '#10B981',
                        600: '#059669',
                        700: '#047857',
                        800: '#065F46',
                        900: '#064E3B',
                    },
                    accent: {
                        DEFAULT: '#0D9488', // teal-600
                        50: '#F0FDFA',
                        100: '#CCFBF1',
                        200: '#99F6E4',
                        300: '#5EEAD4',
                        400: '#2DD4BF',
                        500: '#14B8A6',
                        600: '#0D9488',
                        700: '#0F766E',
                        800: '#115E59',
                        900: '#134E4A',
                    },
                    gold: {
                        DEFAULT: '#D97706', // amber-700 as warm gold accent
                        50: '#FFFBEB',
                        100: '#FEF3C7',
                        200: '#FDE68A',
                        300: '#FCD34D',
                        400: '#F59E0B',
                        500: '#D97706',
                        600: '#B45309',
                        700: '#92400E',
                        800: '#78350F',
                        900: '#4C260A',
                    },
                },
                // Warm gray for typography/backgrounds
                warm: {
                    50: '#FAFAF9',
                    100: '#F5F5F4',
                    200: '#E7E5E4',
                    300: '#D6D3D1',
                    400: '#A8A29E',
                    500: '#78716C',
                    600: '#57534E',
                    700: '#44403C',
                    800: '#292524',
                    900: '#1C1917',
                },
            },
            fontFamily: {
                // UI text
                sans: ['Inter var', 'Inter', ...defaultTheme.fontFamily.sans],
                // Elegant headings
                display: ['"Playfair Display"', 'Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            borderRadius: {
                sm: '6px',
                md: '10px',
            },
        },
    },

    plugins: [forms],
};
