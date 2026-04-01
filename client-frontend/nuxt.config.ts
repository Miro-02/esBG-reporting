export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt", "vuetify-nuxt-module"],
  ssr: false,
  nitro: {
    prerender: {
      crawlLinks: true,
      routes: ['/sitemap.xml', '/robots.txt']
    }
  },
  
  app: {
    head: {
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1, viewport-fit=cover' },
        { name: 'description', content: 'ESG Reporting - Make ESG easy and fast' },
        { name: 'theme-color', content: '#11298a' },
        // Accessibility meta
        { 'http-equiv': 'X-UA-Compatible', content: 'IE=edge' },
      ],
      link: [
        { rel: "icon", type: "image/svg+xml", href: "/logo.svg" }
      ]
    }
  },
  
  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.NUXT_PUBLIC_API_BASE_URL || 'http://esbg-reporting.localhost:89'
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