/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.ts',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {},
  },
  safelist: [
    'w-32',
    'text-red-600',
    'text-teal-600',
    'mr-2',
    'multiselect__tag',
  ],
  plugins: [],
}
