/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/components/**/*.vue',
    './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        'blue-institutional': '#1E3A8A',
        'green-success': '#10B981',
        'blue-vibrant': '#3B82F6',
        'red-alert': '#EF4444',
      },
    },
  },
  plugins: [],
}
