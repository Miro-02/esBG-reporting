<template>
  <footer class="footer" role="contentinfo" aria-label="Site footer">
    <div class="footer-inner">

      <!-- Logo -->
      <div class="footer-logo">
        <NuxtLink to="/" aria-label="ESG Reporting Home" class="footer-logo-link">
          <img src="/logo.svg" alt="ESG Logo" class="footer-logo-image"/>
        </NuxtLink>
      </div>

      <!-- Columns with semantic nav -->
      <div class="footer-columns">

        <!-- Contact -->
        <nav class="footer-col" aria-label="Contact information">
          <h2 class="col-title">Contact us</h2>
          <ul class="footer-list">
            <li>
              <a href="mailto:easyg@gmail.com" class="footer-link">easyg@gmail.com</a>
            </li>
            <li>
              <a href="tel:+35988123 4567" class="footer-link">+359 88 123 4567</a>
            </li>
            <li>
              <address class="footer-text">Ovcha Kupel 15, Sofia, Bulgaria</address>
            </li>
          </ul>
          <div class="socials" aria-label="Social media links">
            <a href="#" class="social-icon" aria-label="Follow on Facebook" title="Facebook">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
              </svg>
            </a>
            <a href="#" class="social-icon" aria-label="Follow on LinkedIn" title="LinkedIn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                <rect x="2" y="9" width="4" height="12"/>
                <circle cx="4" cy="4" r="2"/>
              </svg>
            </a>
            <a href="#" class="social-icon" aria-label="Follow on Twitter" title="Twitter">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
              </svg>
            </a>
            <a href="#" class="social-icon" aria-label="Follow on Instagram" title="Instagram">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
              </svg>
            </a>
          </div>
        </nav>

        <!-- Product -->
        <nav class="footer-col" aria-label="Product links">
          <h2 class="col-title">Product</h2>
          <ul class="footer-list">
            <li><a href="#" class="footer-link">ESG Dashboard</a></li>
            <li><a href="#" class="footer-link">Generate Report</a></li>
            <li><a href="#" class="footer-link">ESG Score</a></li>
            <li><a href="#" class="footer-link">Recommendations</a></li>
            <li><a href="#" class="footer-link">Pricing</a></li>
          </ul>
        </nav>

        <!-- About -->
        <nav class="footer-col" aria-label="Company links">
          <h2 class="col-title">About</h2>
          <ul class="footer-list">
            <li><a href="#" class="footer-link">About us</a></li>
            <li><a href="#" class="footer-link">How it works</a></li>
            <li><a href="#" class="footer-link">Contact</a></li>
            <li><a href="#" class="footer-link">Privacy Policy</a></li>
            <li><a href="#" class="footer-link">Terms of Service</a></li>
          </ul>
        </nav>

      </div>
    </div>

    <!-- Bottom bar -->
    <div class="footer-bottom">
      <div class="footer-bottom-inner">
        <button 
          type="button"
          class="lang-selector"
          aria-label="Change language (currently English)"
          title="Language selector"
        >
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
          </svg>
          <span>EN</span>
        </button>
        <p class="copyright">Copyright © 2026. All rights reserved.</p>
      </div>
    </div>

  </footer>
</template>

<script setup lang="ts">
</script>

<style scoped>
.footer {
  background: #11298a;
  color: #fff;
  font-family: 'Arial', sans-serif;
}

/* ── Main area ────────────────────────────────────── */
.footer-inner {
  max-width: 1280px;
  margin: 0 auto;
  padding: 3rem 2rem 2.5rem;
}

@media (max-width: 768px) {
  .footer-inner {
    padding: 2rem 1.5rem;
  }
}

/* ── Logo ─────────────────────────────────────────── */
.footer-logo {
  margin-bottom: 2rem;
}

.footer-logo-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  outline: none;
}

.footer-logo-link:focus-visible {
  border-radius: 0.5rem;
  outline: 2px solid white;
  outline-offset: 2px;
}

.footer-logo-image {
  height: 2.5rem;
  width: auto;
}

/* ── Columns ──────────────────────────────────────── */
.footer-columns {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 2.5rem;
}

@media (max-width: 1024px) {
  .footer-columns {
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
}

@media (max-width: 768px) {
  .footer-columns {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
}

@media (max-width: 640px) {
  .footer-columns {
    gap: 1.5rem;
  }
}

.footer-col {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.col-title {
  font-size: 0.875rem;
  font-weight: 700;
  color: #fff;
  margin: 0 0 0.75rem 0;
  padding: 0;
}

.footer-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.footer-link {
  font-size: 0.8125rem;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  line-height: 1.6;
  transition: color 0.2s ease, outline 0.2s ease;
  padding: 0.25rem;
  border-radius: 0.25rem;
  outline: none;
}

.footer-link:hover {
  color: #fff;
  text-decoration: underline;
}

.footer-link:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
  background-color: rgba(255, 255, 255, 0.1);
}

.footer-text {
  font-size: 0.8125rem;
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.6;
  margin: 0;
  padding: 0;
  font-style: normal;
}

address {
  font-style: normal;
}

/* ── Socials ──────────────────────────────────────── */
.socials {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-top: 1rem;
}

.social-icon {
  width: 40px;
  height: 40px;
  min-width: 40px;
  min-height: 40px;
  border: 1.5px solid rgba(255, 255, 255, 0.4);
  border-radius: 0.375rem;
  color: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  transition: all 0.2s ease;
  outline: none;
}

.social-icon:hover {
  border-color: #fff;
  color: #fff;
  background-color: rgba(255, 255, 255, 0.1);
}

.social-icon:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
}

@media (max-width: 768px) {
  .social-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    min-height: 36px;
  }

  .socials svg {
    width: 14px;
    height: 14px;
  }
}

/* ── Bottom bar ───────────────────────────────────── */
.footer-bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.15);
  background-color: rgba(0, 0, 0, 0.1);
}

.footer-bottom-inner {
  max-width: 1280px;
  margin: 0 auto;
  padding: 1.25rem 2rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  align-items: flex-start;
}

@media (min-width: 768px) {
  .footer-bottom-inner {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
}

@media (max-width: 768px) {
  .footer-bottom-inner {
    padding: 1rem 1.5rem;
  }
}

.lang-selector {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.8125rem;
  color: rgba(255, 255, 255, 0.8);
  cursor: pointer;
  transition: color 0.2s ease, outline 0.2s ease;
  background: transparent;
  border: none;
  padding: 0.5rem;
  border-radius: 0.25rem;
  outline: none;
  font-weight: 500;
}

.lang-selector:hover {
  color: #fff;
}

.lang-selector:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
}

.copyright {
  font-size: 0.75rem;
  color: rgba(255, 255, 255, 0.6);
  margin: 0;
  padding: 0;
}

@media (max-width: 640px) {
  .copyright {
    width: 100%;
    text-align: center;
  }

  .lang-selector {
    width: 100%;
    justify-content: center;
  }
}

/* ───────────────────────────────────────────────────── */
/* High Contrast Mode Support                            */
/* ───────────────────────────────────────────────────── */

@media (prefers-contrast: more) {
  .footer-link {
    color: #fff;
    text-decoration: underline;
  }

  .social-icon {
    border-color: white;
  }
}

/* ───────────────────────────────────────────────────── */
/* Reduced Motion Support                               */
/* ───────────────────────────────────────────────────── */

@media (prefers-reduced-motion: reduce) {
  .footer-link,
  .social-icon,
  .lang-selector {
    transition: none;
  }
}
</style>