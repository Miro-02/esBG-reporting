export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt"],
  ssr: true,
  
  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.NUXT_PUBLIC_API_BASE_URL || 'http://localhost:89'
    },
  },
  
  vite: {
    server: {
      hmr: {
        protocol: 'ws',
        host: 'night-duty-helper.localhost',
        port: 89,
        clientPort: 89
      }
    }
  },
  
  css: [
    "vuetify/styles",
    "@mdi/font/css/materialdesignicons.css",
    "~/assets/css/tailwind.css",
  ],
  build: {
    transpile: ["vuetify"],
  },
  postcss: {
    plugins: {
      "@tailwindcss/postcss": {},
      autoprefixer: {},
    },
  },
});