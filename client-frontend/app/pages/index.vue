<template>
  <div class="esg-home">

    <!-- ── Hero ───────────────────────────────────── -->
    <section class="hero">
      <div class="hero-img-bg" />
      <div class="hero-overlay" />
      <AppContainer>
        <div class="hero-content col-7">
          <h1 class="hero-title">Make ESG easy!</h1>
          <p class="hero-sub">Generate professional ESG reports in minutes. Make it easy and fast with us :)</p>
          <a href="#" class="hero-cta">Get your ESG score</a>
        </div>
      </AppContainer>
    </section>

    <!-- ── Why Choose Us ──────────────────────────── -->
    <section class="why-section">
      <div class="why-inner">
        <p class="eyebrow">The reasons</p>
        <h2 class="section-title">Why Choose Us?</h2>
        <div class="why-photo-wrap">
          <div class="why-photo" />
        </div>
      </div>
    </section>

    <!-- ── Testimonials ───────────────────────────── -->
    <section class="testi-section">
      <AppContainer>
        <p class="eyebrow">Testimonials</p>
        <h2 class="section-title">What's our customer says?</h2>

        <div class="testi-track-wrap">
          <button class="testi-arrow" @click="prevSlide" aria-label="Previous">&#8249;</button>

          <div class="testi-track">
            <div class="testi-card" v-for="(t, i) in visibleTestimonials" :key="t.name">
              <p class="testi-quote">{{ t.quote }}</p>
              <div class="testi-author">
                <div class="testi-avatar" :style="{ background: t.color }">{{ t.initials }}</div>
                <div>
                  <p class="testi-name">{{ t.name }}</p>
                  <p class="testi-role">{{ t.role }}</p>
                </div>
              </div>
            </div>
          </div>

          <button class="testi-arrow" @click="nextSlide" aria-label="Next">&#8250;</button>
        </div>

        <div class="testi-dots">
          <button
            v-for="(_, i) in testimonials"
            :key="i"
            class="dot"
            :class="{ active: activeSlide === i }"
            @click="activeSlide = i"
          />
        </div>
      </AppContainer>
    </section>

    <!-- ── Contact Us ─────────────────────────────── -->
    <section class="contact-section">
      <AppContainer>
        <div class="contact-layout">

          <!-- Form side -->
          <div class="contact-form-side">
            <h2 class="contact-title">Contact us</h2>
            <p class="contact-sub">The faster you reach, the greater you'll feel once you achieve it.</p>
            <div class="form-fields">
              <div class="form-row">
                <input class="field" type="text" placeholder="Your name" />
                <input class="field" type="email" placeholder="Email" />
              </div>
              <textarea class="field field-ta" placeholder="Leave a message..." rows="5" />
              <button class="contact-btn">Send a message</button>
            </div>
          </div>

          <!-- Map side -->
          <div class="contact-map-side">
            <div class="map-wrap">
              <div class="map-bg">
                <!-- Road lines to simulate a map -->
                <svg class="map-svg" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                  <!-- Grid streets -->
                  <line x1="0" y1="60" x2="400" y2="60" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="0" y1="120" x2="400" y2="120" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="0" y1="180" x2="400" y2="180" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="0" y1="240" x2="400" y2="240" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="80" y1="0" x2="80" y2="300" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="160" y1="0" x2="160" y2="300" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="240" y1="0" x2="240" y2="300" stroke="#d8dce8" stroke-width="1.5"/>
                  <line x1="320" y1="0" x2="320" y2="300" stroke="#d8dce8" stroke-width="1.5"/>
                  <!-- Main roads -->
                  <line x1="0" y1="150" x2="400" y2="150" stroke="#b8bfd8" stroke-width="4"/>
                  <line x1="200" y1="0" x2="200" y2="300" stroke="#b8bfd8" stroke-width="4"/>
                  <!-- Diagonal road -->
                  <line x1="0" y1="300" x2="300" y2="0" stroke="#c8cedf" stroke-width="2.5"/>
                  <!-- Block fills -->
                  <rect x="82" y="62" width="76" height="56" fill="#e8eaf2" rx="2"/>
                  <rect x="162" y="62" width="76" height="56" fill="#eceef5" rx="2"/>
                  <rect x="82" y="122" width="76" height="56" fill="#eceef5" rx="2"/>
                  <rect x="242" y="122" width="76" height="56" fill="#e8eaf2" rx="2"/>
                  <rect x="162" y="182" width="76" height="56" fill="#e8eaf2" rx="2"/>
                  <rect x="242" y="62" width="76" height="56" fill="#eceef5" rx="2"/>
                  <!-- Pin -->
                  <circle cx="200" cy="150" r="14" fill="#11298a" opacity="0.15"/>
                  <circle cx="200" cy="150" r="8" fill="#11298a"/>
                  <circle cx="200" cy="150" r="3" fill="#fff"/>
                </svg>
              </div>
            </div>
          </div>

        </div>
      </AppContainer>
    </section>

  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const activeSlide = ref(0)

const testimonials = [
  {
    name: 'Nikolay Dimitrov',
    initials: 'ND',
    role: 'Founder',
    color: '#2a3f8f',
    quote: 'Finally a tool that enables ESG in a way that actually makes sense.',
  },
  {
    name: 'Ivan Petrov',
    initials: 'IP',
    role: 'Real Business Owner',
    color: '#4a7a9b',
    quote: 'We needed an ESG report for a partnership, but had no idea where to start. esg.bg made the whole process incredibly simple.',
  },
  {
    name: 'Maria Georgieva',
    initials: 'MG',
    role: 'Company Manager',
    color: '#3a5a8a',
    quote: 'I was surprised how fast we got a complete ESG report. It saved us days of work.',
  },
]

const visibleTestimonials = computed(() => {
  // Always show all 3, dots just track active
  return testimonials
})

function prevSlide() {
  activeSlide.value = (activeSlide.value - 1 + testimonials.length) % testimonials.length
}

function nextSlide() {
  activeSlide.value = (activeSlide.value + 1) % testimonials.length
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');

* { box-sizing: border-box; margin: 0; padding: 0; font-family: 'DM Sans', sans-serif; }

.esg-home {
  font-family: 'Georgia', 'Times New Roman', serif;
  color: #0f1f5e;
  background: #fff;
}

/* ── Hero ─────────────────────────────────────────── */
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
  background: url('/pexels-fauxels-3184634.png')
    center / cover no-repeat;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to right,
    rgba(10, 22, 90, 0.88) 0%,
    rgba(10, 22, 90, 0.60) 50%,
    rgba(10, 22, 90, 0.20) 100%
  );
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
}

.hero-title {
  font-size: 6rem;
  font-weight: 700;
  color: #fff;
  line-height: 1.1;
  letter-spacing: -0.02em;
  margin-bottom: 14px;
}

.hero-sub {
  font-family: 'DM Sans', sans-serif;
  font-size: 1.25rem;
  color: rgba(255, 255, 255, 0.75);
  max-width: 560px;
  line-height: 1.65;
  margin-bottom: 28px;
}

.hero-cta {
  display: inline-block;
  background: #fff;
  color: #11298a;
  font-family: 'Arial', sans-serif;
  font-size: 20px;
  font-weight: 700;
  padding: 11px 22px;
  text-decoration: none;
  letter-spacing: 0.02em;
  transition: background 0.15s;
  border-radius: 9999px;
}

.hero-cta:hover {
  background: #dde1f2;
}

/* ── Why Choose Us ────────────────────────────────── */
.why-section {
  padding: 60px 0 0;
  text-align: center;
}

.why-inner {
  max-width: 1160px;
  margin: 0 auto;
  padding: 0 32px;
}

.eyebrow {
  font-family: 'Arial', sans-serif;
  font-size: 0.7rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 10px;
}

.section-title {
  font-size: clamp(1.5rem, 3vw, 2.2rem);
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: -0.02em;
  margin-bottom: 32px;
}

.why-photo-wrap {
  width: 100%;
  overflow: hidden;
  border-radius: 24px;
}

.why-photo {
  width: 100%;
  height: 400px;
  background: url('/pexels-kampus-8441790.png')
    center / cover no-repeat;
}

/* ── Testimonials ─────────────────────────────────── */
.testi-section {
  background: #fff;
  padding: 72px 0 56px;
  text-align: center;
}

.testi-section .eyebrow {
  margin-bottom: 10px;
}

.testi-section .section-title {
  margin-bottom: 40px;
}

.testi-track-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
}

.testi-arrow {
  background: none;
  border: 1px solid #dde1f2;
  color: #11298a;
  font-size: 1.8rem;
  width: 32px;
  height: 32px;
  flex-shrink: 0;
  cursor: pointer;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.15s;
  align-self: center;
  padding-bottom: 2px;
}

.testi-arrow:hover {
  background: #f0f0f8;
}

.testi-track {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  flex: 1;
}

@media (max-width: 768px) {
  .testi-track {
    grid-template-columns: 1fr;
  }
}

.testi-card {
  background: #fff;
  border: 1px solid #e8e8f0;
  padding: 24px 22px 20px;
  text-align: left;
  display: flex;
  flex-direction: column;
  gap: 20px;
  border-radius: 16px;
}

.testi-quote {
  font-family: 'Arial', sans-serif;
  font-size: 0.87rem;
  color: #4a5578;
  line-height: 1.7;
  flex: 1;
}

.testi-author {
  display: flex;
  align-items: center;
  gap: 12px;
}

.testi-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  color: #fff;
  font-family: 'Arial Narrow', Arial, sans-serif;
  font-size: 0.78rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.testi-name {
  font-family: 'Arial', sans-serif;
  font-size: 0.85rem;
  font-weight: 700;
  color: #0f1f5e;
  margin-bottom: 2px;
}

.testi-role {
  font-family: 'Arial', sans-serif;
  font-size: 0.75rem;
  color: #8890b0;
}

.testi-dots {
  display: flex;
  justify-content: center;
  gap: 6px;
  margin-top: 24px;
}

.dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #dde1f2;
  border: none;
  cursor: pointer;
  padding: 0;
  transition: background 0.15s;
}

.dot.active {
  background: #11298a;
}

/* ── Contact ──────────────────────────────────────── */
.contact-section {
  background: #f7f7fc;
  padding: 72px 0;
}

.contact-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 64px;
  align-items: start;
}

@media (max-width: 768px) {
  .contact-layout {
    grid-template-columns: 1fr;
    gap: 40px;
  }
}

.contact-title {
  font-size: 1.6rem;
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: -0.02em;
  margin-bottom: 8px;
}

.contact-sub {
  font-family: 'Arial', sans-serif;
  font-size: 0.85rem;
  color: #8890b0;
  line-height: 1.6;
  margin-bottom: 28px;
}

.form-fields {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

@media (max-width: 480px) {
  .form-row { grid-template-columns: 1fr; }
}

.field {
  width: 100%;
  padding: 10px 13px;
  border: 1.5px solid #d8dce8;
  background: #fff;
  font-family: 'Arial', sans-serif;
  font-size: 0.85rem;
  color: #0f1f5e;
  outline: none;
  transition: border-color 0.15s;
  border-radius: 12px;
}

.field:focus {
  border-color: #11298a;
}

.field::placeholder {
  color: #aab0cc;
}

.field-ta {
  resize: vertical;
  min-height: 110px;
}

.contact-btn {
  display: inline-block;
  padding: 11px 28px;
  background: #11298a;
  color: #fff;
  font-family: 'Arial', sans-serif;
  font-size: 0.82rem;
  font-weight: 700;
  border: none;
  cursor: pointer;
  letter-spacing: 0.03em;
  transition: background 0.15s;
  align-self: flex-start;
  border-radius: 9999px;
}

.contact-btn:hover {
  background: #0d1f70;
}

/* ── Map ──────────────────────────────────────────── */
.contact-map-side {
  height: 100%;
  min-height: 300px;
}

.map-wrap {
  width: 100%;
  height: 300px;
  border: 1.5px solid #d8dce8;
  overflow: hidden;
  background: #eef0f8;
  border-radius: 20px;
}

.map-bg {
  width: 100%;
  height: 100%;
  background: url('/map.png') center / cover no-repeat;
}

.map-svg {
  width: 100%;
  height: 100%;
}
</style>