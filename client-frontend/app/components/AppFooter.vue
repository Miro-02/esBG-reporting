<template>
  <footer class="footer">
    <div class="footer-inner">

      <!-- Logo -->
      <div class="footer-logo">
        <span class="logo-box">ESG</span>
      </div>

      <!-- Columns -->
      <div class="footer-columns">

        <!-- Contact -->
        <div class="footer-col">
          <p class="col-title">Contact us</p>
          <a href="mailto:easyg@gmail.com" class="footer-link">easyg@gmail.com</a>
          <a href="tel:+35988123 4567" class="footer-link">+359 88 123 4567</a>
          <p class="footer-text">Ovcha Kupel 15, Sofia, Bulgaria</p>
          <div class="socials">
            <a href="#" class="social-icon" aria-label="Facebook">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
              </svg>
            </a>
            <a href="#" class="social-icon" aria-label="LinkedIn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                <rect x="2" y="9" width="4" height="12"/>
                <circle cx="4" cy="4" r="2"/>
              </svg>
            </a>
            <a href="#" class="social-icon" aria-label="Twitter">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
              </svg>
            </a>
            <a href="#" class="social-icon" aria-label="Instagram">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Product -->
        <div class="footer-col">
          <p class="col-title">Product</p>
          <a href="#" class="footer-link">ESG Dashboard</a>
          <a href="#" class="footer-link">Generate Report</a>
          <a href="#" class="footer-link">ESG Score</a>
          <a href="#" class="footer-link">Recommendations</a>
          <a href="#" class="footer-link">Pricing</a>
        </div>

        <!-- About -->
        <div class="footer-col">
          <p class="col-title">About</p>
          <a href="#" class="footer-link">About us</a>
          <a href="#" class="footer-link">How it works</a>
          <a href="#" class="footer-link">Contact</a>
          <a href="#" class="footer-link">Privacy Policy</a>
          <a href="#" class="footer-link">Terms of Service</a>
        </div>

      </div>
    </div>

    <!-- Bottom bar -->
    <div class="footer-bottom">
      <div class="footer-bottom-inner">
        <div class="lang-selector">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
          </svg>
          <span>English</span>
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <polyline points="6 9 12 15 18 9"/>
          </svg>
        </div>
        <p class="copyright">Copyright © 2020. All rights reserved.</p>
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
  max-width: 1160px;
  margin: 0 auto;
  padding: 48px 32px 40px;
}

/* ── Logo ─────────────────────────────────────────── */
.footer-logo {
  margin-bottom: 32px;
}

.logo-box {
  display: inline-block;
  background: #fff;
  color: #11298a;
  font-family: 'Arial Black', Arial, sans-serif;
  font-size: 0.9rem;
  font-weight: 900;
  letter-spacing: 0.04em;
  padding: 3px 9px 2px;
  line-height: 1.3;
}

/* ── Columns ──────────────────────────────────────── */
.footer-columns {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 40px;
}

@media (max-width: 640px) {
  .footer-columns {
    grid-template-columns: 1fr;
    gap: 32px;
  }
}

.footer-col {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.col-title {
  font-size: 0.88rem;
  font-weight: 700;
  color: #fff;
  margin-bottom: 6px;
}

.footer-link {
  font-size: 0.83rem;
  color: rgba(255, 255, 255, 0.75);
  text-decoration: none;
  line-height: 1.5;
  transition: color 0.15s;
}

.footer-link:hover {
  color: #fff;
}

.footer-text {
  font-size: 0.83rem;
  color: rgba(255, 255, 255, 0.75);
  line-height: 1.5;
}

/* ── Socials ──────────────────────────────────────── */
.socials {
  display: flex;
  gap: 10px;
  margin-top: 8px;
}

.social-icon {
  width: 30px;
  height: 30px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 4px;
  color: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  transition: border-color 0.15s, color 0.15s;
}

.social-icon:hover {
  border-color: #fff;
  color: #fff;
}

/* ── Bottom bar ───────────────────────────────────── */
.footer-bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.12);
}

.footer-bottom-inner {
  max-width: 1160px;
  margin: 0 auto;
  padding: 16px 32px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.lang-selector {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.8rem;
  color: rgba(255, 255, 255, 0.75);
  cursor: pointer;
  transition: color 0.15s;
}

.lang-selector:hover {
  color: #fff;
}

.copyright {
  font-size: 0.78rem;
  color: rgba(255, 255, 255, 0.55);
}
</style>