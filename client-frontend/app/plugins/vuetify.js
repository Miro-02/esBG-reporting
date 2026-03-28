// client-frontend/app/plugins/vuetify.js
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'

export default defineNuxtPlugin((nuxtApp) => {
  // Disable SSR for Vuetify due to focus trap composable using browser APIs
  if (process.server) return
  
  const vuetify = createVuetify({
    components,
    directives,
    icons: {
      defaultSet: 'mdi',
    },
    defaults: {
      VCard: { rounded: 'lg' },
      VBtn: { rounded: 'pill' },
      VTextField: { rounded: 'lg', variant: 'outlined' },
      VTextarea: { rounded: 'lg', variant: 'outlined' },
      VSelect: { rounded: 'lg', variant: 'outlined' },
      VDialog: { class: 'rounded-dialog' },
      VMenu: { rounded: 'lg' },
      VChip: { rounded: 'pill' },
      VAlert: { rounded: 'lg' },
    },
    theme: {
      defaultTheme: 'light',
      themes: {
        light: {
          dark: false,
          colors: {
            primary: '#1976D2',
            secondary: '#424242',
            accent: '#82B1FF',
            error: '#FF5252',
            info: '#2196F3',
            success: '#4CAF50',
            warning: '#FB8C00',
            background: '#FFFFFF',
            surface: '#FFFFFF',
          }
        },
        dark: {
          dark: true,
          colors: {
            primary: '#2196F3',
            secondary: '#424242',
            accent: '#82B1FF',
            error: '#FF5252',
            info: '#2196F3',
            success: '#4CAF50',
            warning: '#FB8C00',
            background: '#121212',
            surface: '#1E1E1E',
          }
        }
      }
    }
  })
  nuxtApp.vueApp.use(vuetify)
})