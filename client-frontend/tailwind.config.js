export default {
  content: [
    "./app/components/**/*.{vue,js,ts}",
    "./app/layouts/**/*.vue",
    "./app/pages/**/*.vue",
    "./app/plugins/**/*.{js,ts}",
    "./app/app.vue",
  ],
  theme: {
    extend: {
      screens: {
        'xs': '320px',  // Mobile-first: extra small devices
        'sm': '640px',  // Small devices
        'md': '768px',  // Tablets
        'lg': '1024px', // Desktops
        'xl': '1280px',
        '2xl': '1536px',
      },
      colors: {
        'blue': {
          '700': '#1d4ed8',
          '900': '#11298a',
        },
        'red': {
          '600': '#dc2626',
        },
        'green': {
          '600': '#16a34a',
        },
        'gray': {
          '100': '#f3f4f6',
          '200': '#e5e7eb',
          '300': '#d1d5db',
          '400': '#9ca3af',
          '500': '#6b7280',
          '600': '#4b5563',
          '700': '#374151',
          '800': '#1f2937',
          '900': '#111827',
        },
      },
      ringColor: {
        DEFAULT: '#11298a', // Primary brand color for focus rings
      },
    },
  },
  corePlugins: {
    // Enable all core plugins for focus utilities
  },
};