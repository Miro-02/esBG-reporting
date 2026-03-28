export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt", "vuetify-nuxt-module"],
  ssr: true,
  
  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.NGROK_URL || process.env.NUXT_PUBLIC_API_BASE_URL || 'http://localhost:8000'
    },
  },
  
  vuetify: {
    moduleOptions: {
      styles: true,
      autoImport: true,
    }
  },
  
  vite: {
    server: {
      middlewareMode: true,
      hmr: {
        protocol: 'ws',
        host: 'localhost',
        port: 3000
      }
    }
  },
  
  css: [
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