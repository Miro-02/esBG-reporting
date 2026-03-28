<template>
  <div class="esg-page">

    <!-- Hero -->
    <section class="hero">
      <div class="hero-img-bg" />
      <div class="hero-overlay" />
      <AppContainer>
        <div class="hero-content col-7">
          <p class="eyebrow">Contact</p>
          <h1 class="hero-title">Get in Touch</h1>
          <p class="hero-subtitle">
            We're here to help. Reach out with questions, partnership inquiries, or support requests.
          </p>
        </div>
      </AppContainer>
    </section>

    <!-- Contact body -->
    <section class="section">
      <AppContainer>
        <div class="contact-layout">

          <!-- Left info -->
          <div class="contact-info">
            <p class="eyebrow">Contact details</p>
            <h2 class="section-title">Let's talk</h2>
            <p class="body-text mt">
              Have questions about our platform or want to learn how esBG Reporting can help your organization?
              We'd love to hear from you.
            </p>

            <div class="contact-items">
              <div class="contact-item" v-for="item in contactItems" :key="item.label">
                <div class="contact-icon">{{ item.icon }}</div>
                <div>
                  <p class="contact-label">{{ item.label }}</p>
                  <p class="contact-value">{{ item.value }}</p>
                </div>
              </div>
            </div>

            <div class="office-hours">
              <p class="oh-title">Office hours</p>
              <p class="oh-text">Monday – Friday, 09:00 – 18:00 CET</p>
            </div>
          </div>

          <!-- Right form -->
          <div class="contact-form-wrap">
            <p class="eyebrow">Send a message</p>
            <h2 class="section-title">Write to us</h2>

            <div class="form-body">
              <div class="form-row">
                <div class="field-wrap">
                  <label class="field-label">First name</label>
                  <input v-model="form.firstName" class="field" type="text" placeholder="John" />
                </div>
                <div class="field-wrap">
                  <label class="field-label">Last name</label>
                  <input v-model="form.lastName" class="field" type="text" placeholder="Doe" />
                </div>
              </div>
              <div class="field-wrap">
                <label class="field-label">Email address</label>
                <input v-model="form.email" class="field" type="email" placeholder="john@company.com" />
              </div>
              <div class="field-wrap">
                <label class="field-label">Company</label>
                <input v-model="form.company" class="field" type="text" placeholder="Your company name" />
              </div>
              <div class="field-wrap">
                <label class="field-label">Subject</label>
                <select v-model="form.subject" class="field field-select">
                  <option value="">Select a topic</option>
                  <option>Platform inquiry</option>
                  <option>Partnership</option>
                  <option>Technical support</option>
                  <option>General question</option>
                </select>
              </div>
              <div class="field-wrap">
                <label class="field-label">Message</label>
                <textarea v-model="form.message" class="field field-ta" rows="5" placeholder="Tell us how we can help…" />
              </div>
              <button class="pill-btn" @click="handleSubmit">Send message</button>
            </div>
          </div>

        </div>
      </AppContainer>
    </section>

  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'

const contactItems = [
  { icon: '✉', label: 'Email', value: 'info@esbg-reporting.com' },
  { icon: '☎', label: 'Phone', value: '+1 (555) 123-4567' },
  { icon: '◎', label: 'Address', value: '123 Business St, City, State 12345' },
]

const form = reactive({
  firstName: '',
  lastName: '',
  email: '',
  company: '',
  subject: '',
  message: '',
})

function handleSubmit() {}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');
* { box-sizing: border-box; margin: 0; padding: 0; }

.esg-page {
  font-family: 'DM Sans', sans-serif;
  color: #0f1f5e;
  background: #fff;
}

/* ── Hero ──────────────────────────────────────────── */
.hero {
  position: relative;
  height: 100vh;
  display: flex;
  align-items: center;
  overflow: hidden;
}

.hero-img-bg {
  position: absolute;
  inset: 0;
  background: url('https://images.unsplash.com/photo-1556740738-b6a63e27c4df?w=1400&q=80') center / cover no-repeat;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(10,22,90,0.92) 0%, rgba(10,22,90,0.65) 55%, rgba(10,22,90,0.25) 100%);
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
}

.hero-title {
  font-size: clamp(2.2rem, 5vw, 3.6rem);
  font-weight: 700;
  color: #fff;
  line-height: 1.1;
  letter-spacing: -0.02em;
  margin-bottom: 16px;
}

.hero-subtitle {
  font-size: 1.05rem;
  color: rgba(255,255,255,0.75);
  max-width: 460px;
  line-height: 1.65;
}

/* ── Shared ──────────────────────────────────────── */
.section { padding: 80px 0; }

.eyebrow {
  font-size: 0.7rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 10px;
}

.section-title {
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: -0.02em;
  line-height: 1.1;
  margin-bottom: 24px;
}

.body-text {
  font-size: 0.95rem;
  color: #4a5578;
  line-height: 1.75;
}

.mt { margin-top: 16px; }

/* ── Layout ──────────────────────────────────────── */
.contact-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: start;
}

@media (max-width: 768px) {
  .contact-layout { grid-template-columns: 1fr; gap: 48px; }
}

/* ── Info side ───────────────────────────────────── */
.contact-items {
  display: flex;
  flex-direction: column;
  margin: 28px 0;
}

.contact-item {
  display: flex;
  gap: 16px;
  align-items: flex-start;
  padding: 18px 0;
  border-bottom: 1px solid #e8e8f0;
}

.contact-item:first-child { border-top: 1px solid #e8e8f0; }

.contact-icon {
  width: 36px;
  height: 36px;
  background: #11298a;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.95rem;
  border-radius: 8px;
  flex-shrink: 0;
}

.contact-label {
  font-size: 0.7rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 3px;
}

.contact-value {
  font-size: 0.9rem;
  color: #0f1f5e;
  font-weight: 600;
}

.office-hours {
  background: #f7f7fc;
  border-left: 3px solid #11298a;
  border-radius: 0 8px 8px 0;
  padding: 16px 20px;
}

.oh-title {
  font-size: 0.7rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 4px;
}

.oh-text {
  font-size: 0.88rem;
  color: #0f1f5e;
  font-weight: 500;
}

/* ── Form side ───────────────────────────────────── */
.form-body {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-top: 24px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

@media (max-width: 480px) {
  .form-row { grid-template-columns: 1fr; }
}

.field-wrap {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.field-label {
  font-size: 0.78rem;
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: 0.03em;
}

.field {
  padding: 10px 14px;
  border: 1.5px solid #d8dce8;
  background: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.88rem;
  color: #0f1f5e;
  outline: none;
  border-radius: 12px;
  transition: border-color 0.15s;
  appearance: none;
}

.field:focus { border-color: #11298a; }

.field::placeholder { color: #aab0cc; }

.field-ta { resize: vertical; min-height: 120px; }

.field-select {
  cursor: pointer;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2311298a' d='M6 8L0 0h12z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  padding-right: 36px;
}

.pill-btn {
  align-self: flex-start;
  padding: 12px 32px;
  background: #11298a;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.88rem;
  font-weight: 700;
  border: none;
  cursor: pointer;
  border-radius: 9999px;
  transition: background 0.15s;
  margin-top: 4px;
}

.pill-btn:hover { background: #0d1f70; }
</style>