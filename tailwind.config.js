// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/views/**/*.vue',
  ],

  theme: {
    container: {
      center: true,
      padding: '1rem',
      screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1280px',
        '2xl': '1400px',
      },
    },
    extend: {
      fontFamily: {
        sans: ['Montserrat', 'Poppins', ...defaultTheme.fontFamily.sans],
        heading: ['Montserrat', ...defaultTheme.fontFamily.sans],
        display: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        // Primary brand
        brand: {
          DEFAULT: '#B71C1C', 
          50:  '#FBEAEA',
          100: '#F5D5D5',
          200: '#E9ACAC',
          300: '#DB8080',
          400: '#CC5757',
          500: '#BF2F2F',
          600: '#B71C1C', 
          700: '#921515',
          800: '#6E1010',
          900: '#3E0A0A',
          foreground: '#FFFFFF',  
        },
        neutral: {
          25:  '#FCFCFD',
          50:  '#F8FAFC',
          100: '#F1F5F9',
          200: '#E2E8F0',
          300: '#CBD5E1',
          400: '#94A3B8',
          500: '#64748B',
          600: '#475569',
          700: '#334155',
          800: '#1E293B',
          900: '#0F172A',
        },
      },
      ringColor: {
        DEFAULT: '#B71C1C',
      },
      outlineColor: {
        brand: '#B71C1C',
      },
      boxShadow: {
        card: '0 10px 20px rgba(0,0,0,0.06), 0 6px 6px rgba(0,0,0,0.04)',
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.25rem',
      },
    },
  },

  plugins: [forms],
}
