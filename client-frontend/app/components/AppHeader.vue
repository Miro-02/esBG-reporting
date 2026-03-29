<template>
  <header class="app-header" role="banner" aria-label="Site navigation">
    <!-- Skip to main content - hidden but focusable, appears on keyboard nav -->
    <a href="#main-content" class="skip-to-content">
      Skip to main content
    </a>

    <div class="header-container">
      <!-- Logo -->
      <NuxtLink to="/" class="logo-link" aria-label="ESG Reporting Home">
        <img src="/logo.svg" alt="ESG Logo" class="logo-image"/>
      </NuxtLink>

      <!-- Spacer (hidden on mobile) -->
      <div class="spacer"></div>

      <!-- Mobile menu toggle button (visible on mobile only) -->
      <button
        v-if="!isDesktop"
        type="button"
        class="mobile-menu-toggle"
        :aria-expanded="isMobileMenuOpen"
        aria-controls="mobile-menu"
        aria-label="Toggle navigation menu"
        @click="isMobileMenuOpen = !isMobileMenuOpen"
      >
        <span class="hamburger">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </span>
      </button>

      <!-- Desktop Navigation -->
      <nav 
        v-if="isDesktop"
        class="desktop-nav"
        aria-label="Main navigation"
      >
        <ul class="nav-list">
          <li>
            <NuxtLink 
              to="/" 
              class="nav-link"
              :aria-current="$route.path === '/' ? 'page' : undefined"
            >
              Home
            </NuxtLink>
          </li>
          
          <!-- Public Links (shown when not logged in) -->
          <template v-if="!authStore.isLoggedIn">
            <li>
              <NuxtLink 
                to="/about-us" 
                class="nav-link"
                :aria-current="$route.path === '/about-us' ? 'page' : undefined"
              >
                About us
              </NuxtLink>
            </li>
            <li>
              <NuxtLink 
                to="/testimonials" 
                class="nav-link"
                :aria-current="$route.path === '/testimonials' ? 'page' : undefined"
              >
                Testimonials
              </NuxtLink>
            </li>
            <li>
              <NuxtLink 
                to="/contact-us" 
                class="nav-link"
                :aria-current="$route.path === '/contact-us' ? 'page' : undefined"
              >
                Contact us
              </NuxtLink>
            </li>
            
            <li>
              <NuxtLink to="/register" class="nav-link-button">
                <AppButton variant="outlined" type="button">
                  Sign up
                </AppButton>
              </NuxtLink>
            </li>
            <li>
              <NuxtLink to="/login" class="nav-link-button">
                <AppButton variant="flat" type="button">
                  Log in
                </AppButton>
              </NuxtLink>
            </li>
          </template>

          <!-- Logged In Links -->
          <template v-else>
            <li>
              <NuxtLink 
                to="/reports" 
                class="nav-link"
                :aria-current="$route.path === '/reports' ? 'page' : undefined"
              >
                Report history
              </NuxtLink>
            </li>
            <li>
              <NuxtLink 
                to="/reports/create" 
                class="nav-link"
                :aria-current="$route.path === '/reports/create' ? 'page' : undefined"
              >
                Create a report
              </NuxtLink>
            </li>
            
            <li>
              <AppButton
                type="button"
                variant="flat"
                @click="handleLogout"
              >
                Log out
              </AppButton>
            </li>
          </template>

          <li>
            <button type="button" class="lang-selector-header" aria-label="Change language (currently English)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
              </svg>
              <span>EN</span>
            </button>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Mobile Navigation (visible on mobile when toggled) -->
    <nav 
      v-show="isMobileMenuOpen && !isDesktop"
      id="mobile-menu"
      class="mobile-nav"
      aria-label="Mobile navigation"
    >
      <ul class="mobile-nav-list">
        <li>
          <NuxtLink 
            to="/" 
            class="mobile-nav-link"
            @click="isMobileMenuOpen = false"
            :aria-current="$route.path === '/' ? 'page' : undefined"
          >
            Home
          </NuxtLink>
        </li>
        
        <!-- Public Links (shown when not logged in) -->
        <template v-if="!authStore.isLoggedIn">
          <li>
            <NuxtLink 
              to="/about-us" 
              class="mobile-nav-link"
              @click="isMobileMenuOpen = false"
              :aria-current="$route.path === '/about-us' ? 'page' : undefined"
            >
              About us
            </NuxtLink>
          </li>
          <li>
            <NuxtLink 
              to="/testimonials" 
              class="mobile-nav-link"
              @click="isMobileMenuOpen = false"
              :aria-current="$route.path === '/testimonials' ? 'page' : undefined"
            >
              Testimonials
            </NuxtLink>
          </li>
          <li>
            <NuxtLink 
              to="/contact-us" 
              class="mobile-nav-link"
              @click="isMobileMenuOpen = false"
              :aria-current="$route.path === '/contact-us' ? 'page' : undefined"
            >
              Contact us
            </NuxtLink>
          </li>
          
          <li class="mobile-nav-button-group">
            <NuxtLink to="/register">
              <AppButton variant="outlined" type="button" class="w-full">
                Sign up
              </AppButton>
            </NuxtLink>
          </li>
          <li class="mobile-nav-button-group">
            <NuxtLink to="/login">
              <AppButton variant="flat" type="button" class="w-full">
                Log in
              </AppButton>
            </NuxtLink>
          </li>
        </template>

        <!-- Logged In Links -->
        <template v-else>
          <li>
            <NuxtLink 
              to="/reports" 
              class="mobile-nav-link"
              @click="isMobileMenuOpen = false"
              :aria-current="$route.path === '/reports' ? 'page' : undefined"
            >
              Report history
            </NuxtLink>
          </li>
          <li>
            <NuxtLink 
              to="/reports/create" 
              class="mobile-nav-link"
              @click="isMobileMenuOpen = false"
              :aria-current="$route.path === '/reports/create' ? 'page' : undefined"
            >
              Create a report
            </NuxtLink>
          </li>
          
          <li class="mobile-nav-button-group">
            <AppButton
              type="button"
              variant="flat"
              class="w-full"
              @click="handleLogout"
            >
              Log out
            </AppButton>
          </li>
        </template>

        <li class="mobile-nav-lang">
          <button type="button" class="lang-selector-mobile" aria-label="Change language (currently English)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="12" r="10"/>
              <line x1="2" y1="12" x2="22" y2="12"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <span>EN</span>
          </button>
        </li>
      </ul>
    </nav>

    <slot />
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()
const route = useRoute()

const isMobileMenuOpen = ref(false)
const isDesktop = ref(true)

const handleLogout = async () => {
  isMobileMenuOpen.value = false
  await authStore.logout()
  router.push('/')
}

/**
 * Responsive breakpoint handler
 */
const updateIsDesktop = () => {
  isDesktop.value = window.innerWidth >= 768
  if (isDesktop.value) {
    isMobileMenuOpen.value = false
  }
}

/**
 * Close mobile menu when route changes
 */
watch(() => route.path, () => {
  isMobileMenuOpen.value = false
})

onMounted(() => {
  authStore.checkLoginStatus()
  updateIsDesktop()
  window.addEventListener('resize', updateIsDesktop)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateIsDesktop)
})
</script>

<style scoped>
/* ───────────────────────────────────────────────────── */
/* Header Layout & Styling                               */
/* ───────────────────────────────────────────────────── */

.app-header {
  background-color: #11298a;
  position: sticky;
  top: 0;
  z-index: 50;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  min-height: 100px;
}

.header-container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 0.75rem;
  display: flex;
  align-items: center;
  gap: 2rem;
  height: 100px;
}

/* Tablet and up: Small (640px) and Medium (768px) */
@media (min-width: 768px) {
  .header-container {
    padding: 0 2rem;
  }
}

/* Desktop and up: Large devices (1024px+) */
@media (min-width: 1024px) {
  .header-container {
    padding: 0 3rem;
  }
}

/* Extra large devices (1280px+) */
@media (min-width: 1280px) {
  .header-container {
    padding: 0 4rem;
  }
}

/* Logo and branding */
.logo-link {
  display: flex;
  align-items: center;
  flex-shrink: 0;
  text-decoration: none;
  outline: none;
}

.logo-link:focus-visible {
  border-radius: 0.5rem;
  outline: 2px solid white;
  outline-offset: 2px;
}

.logo-image {
  height: 2.5rem;
  width: auto;
}

/* Spacer for desktop layout */
.spacer {
  flex: 1;
  display: none;
}

@media (min-width: 768px) {
  .spacer {
    display: block;
  }
}

/* ───────────────────────────────────────────────────── */
/* Desktop Navigation */
/* ───────────────────────────────────────────────────── */

.desktop-nav {
  display: none;
}

@media (min-width: 768px) {
  .desktop-nav {
    display: block;
  }
}

.nav-list {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 2rem;
  align-items: center;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-size: 1.125rem;
  font-weight: 500;
  padding: 0.5rem 0.5rem;
  border-radius: 0.25rem;
  border-bottom: 2px solid transparent;
  transition: all 0.2s ease;
  outline: none;
}

.nav-link:hover {
  color: #e0e7ff;
  border-bottom-color: white;
}

.nav-link:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
}

/* Active page indicator */
.nav-link[aria-current="page"] {
  border-bottom-color: white;
  font-weight: 700;
}

.nav-link-button {
  text-decoration: none;
}

/* ───────────────────────────────────────────────────── */
/* Mobile Menu Toggle */
/* ───────────────────────────────────────────────────── */

.mobile-menu-toggle {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 44px;
  height: 44px;
  background: transparent;
  border: none;
  cursor: pointer;
  outline: none;
  padding: 0;
  margin: 0;
  margin-left: auto;
}

@media (min-width: 768px) {
  .mobile-menu-toggle {
    display: none;
  }
}

.mobile-menu-toggle:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
  border-radius: 0.25rem;
}

.hamburger {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.line {
  display: block;
  width: 24px;
  height: 3px;
  background-color: white;
  border-radius: 2px;
  transition: all 0.3s ease;
}

.mobile-menu-toggle[aria-expanded="true"] .line-1 {
  transform: translateY(9px) rotate(45deg);
}

.mobile-menu-toggle[aria-expanded="true"] .line-2 {
  opacity: 0;
}

.mobile-menu-toggle[aria-expanded="true"] .line-3 {
  transform: translateY(-9px) rotate(-45deg);
}

/* ───────────────────────────────────────────────────── */
/* Mobile Navigation */
/* ───────────────────────────────────────────────────── */

.mobile-nav {
  background-color: #0a1b4d;
  padding: 1rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (min-width: 768px) {
  .mobile-nav {
    display: none;
  }
}

.mobile-nav-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.mobile-nav-link {
  display: block;
  color: white;
  text-decoration: none;
  font-size: 1rem;
  padding: 0.75rem 1rem;
  border-radius: 0.25rem;
  transition: all 0.2s ease;
  outline: none;
}

.mobile-nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #e0e7ff;
}

.mobile-nav-link:focus-visible {
  outline: 2px solid white;
  outline-offset: -2px;
  background-color: rgba(255, 255, 255, 0.1);
}

.mobile-nav-link[aria-current="page"] {
  background-color: rgba(255, 255, 255, 0.2);
  font-weight: 700;
}

.mobile-nav-button-group {
  margin-top: 0.5rem;
  padding: 0.5rem 0;
}

/* ───────────────────────────────────────────────────── */
/* Language Selector */
/* ───────────────────────────────────────────────────── */

.lang-selector-header {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: white;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 0.5rem 0.75rem;
  border-radius: 0.25rem;
  font-size: 0.9rem;
  font-weight: 500;
  transition: all 0.2s ease;
  outline: none;
}

.lang-selector-header:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #e0e7ff;
}

.lang-selector-header:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
}

.lang-selector-mobile {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  width: 100%;
  color: white;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 0.75rem 1rem;
  border-radius: 0.25rem;
  font-size: 1rem;
  font-weight: 500;
  transition: all 0.2s ease;
  outline: none;
}

.lang-selector-mobile:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #e0e7ff;
}

.lang-selector-mobile:focus-visible {
  outline: 2px solid white;
  outline-offset: -2px;
  background-color: rgba(255, 255, 255, 0.1);
}

.mobile-nav-lang {
  padding-top: 0.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.15);
  margin-top: 0.5rem;
}

.skip-to-content {
  position: absolute;
  top: -40px;
  left: 0;
  background-color: #11298a;
  color: white;
  padding: 0.5rem 1rem;
  text-decoration: none;
  z-index: 100;
  border-radius: 0 0 0.5rem 0;
  font-weight: 600;
}

.skip-to-content:focus {
  top: 0;
  outline: 2px solid white;
  outline-offset: 2px;
}

/* ───────────────────────────────────────────────────── */
/* Responsive Adjustments */
/* ───────────────────────────────────────────────────── */

@media (max-width: 640px) {
  .header-container {
    gap: 1rem;
    padding: 0 0.75rem;
    height: 80px;
  }

  .logo-image {
    height: 2rem;
  }

  .nav-list {
    gap: 1rem;
  }

  .nav-link {
    font-size: 0.9375rem;
  }
}
</style>
