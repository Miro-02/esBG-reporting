<template>
  <div class="esg-page">

    <!-- Hero -->
    <section class="hero">
      <div class="hero-img-bg" />
      <div class="hero-overlay" />
      <AppContainer>
        <div class="hero-content col-7">
          <p class="eyebrow">Client stories</p>
          <h1 class="hero-title">What our clients say</h1>
          <p class="hero-subtitle">
            Trusted by sustainability leaders across industries worldwide.
          </p>
        </div>
      </AppContainer>
    </section>

    <!-- Stats -->
    <section class="stats-section">
      <AppContainer>
        <div class="stats-grid">
          <div class="stat-item" v-for="stat in stats" :key="stat.label">
            <p class="stat-value">{{ stat.value }}</p>
            <p class="stat-label">{{ stat.label }}</p>
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Testimonials -->
    <section class="section">
      <AppContainer>
        <div class="section-header">
          <p class="eyebrow">Testimonials</p>
          <h2 class="section-title">Voices from the field</h2>
        </div>

        <div class="testi-track-wrap">
          <button class="testi-arrow" @click="prevSlide" aria-label="Previous">&#8249;</button>
          <div class="testi-track">
            <div class="testi-card" v-for="t in testimonials" :key="t.name">
              <div class="stars">
                <span v-for="s in 5" :key="s">★</span>
              </div>
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

    <!-- Featured quote -->
    <section class="featured-section">
      <AppContainer>
        <div class="featured-card">
          <p class="eyebrow light">Featured story</p>
          <p class="featured-quote">
            "Implementing esBG Reporting across our 14 subsidiaries took weeks, not months. The standardization of reporting frameworks alone saved us significant compliance overhead — and investor confidence in our ESG disclosures has never been higher."
          </p>
          <div class="featured-author">
            <div class="testi-avatar large" style="background: #2a3f8f">SL</div>
            <div>
              <p class="testi-name light">Sarah Lindström</p>
              <p class="testi-role light">Group Head of Sustainability · Nordic Industrial Group</p>
            </div>
          </div>
        </div>
      </AppContainer>
    </section>

  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const activeSlide = ref(0)

const stats = [
  { value: '500+', label: 'Organizations onboarded' },
  { value: '97%', label: 'Client satisfaction rate' },
  { value: '40+', label: 'Countries represented' },
  { value: '12M+', label: 'ESG data points processed' },
]

const testimonials = [
  {
    name: 'Nikolay Dimitrov',
    initials: 'ND',
    role: 'Founder',
    color: '#2a3f8f',
    quote: 'Finally a tool that enables ESG in a way that actually makes sense. The platform is intuitive and the results speak for themselves.',
  },
  {
    name: 'Ivan Petrov',
    initials: 'IP',
    role: 'Real Business Owner',
    color: '#4a7a9b',
    quote: 'We needed an ESG report for a partnership, but had no idea where to start. esBG made the whole process incredibly simple.',
  },
  {
    name: 'Maria Georgieva',
    initials: 'MG',
    role: 'Company Manager',
    color: '#3a5a8a',
    quote: 'I was surprised how fast we got a complete ESG report. It saved us days of work and the quality exceeded our expectations.',
  },
]

function prevSlide() {
  activeSlide.value = (activeSlide.value - 1 + testimonials.length) % testimonials.length
}

function nextSlide() {
  activeSlide.value = (activeSlide.value + 1) % testimonials.length
}
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
  background: url('https://images.unsplash.com/photo-1552664730-d307ca884978?w=1400&q=80') center / cover no-repeat;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(10,22,90,0.92) 0%, rgba(10,22,90,0.65) 55%, rgba(10,22,90,0.25) 100%);
  z-index: 1;
}

.hero-content { position: relative; z-index: 2; }

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
.section { padding: 72px 0; }

.section-header { margin-bottom: 40px; }

.eyebrow {
  font-size: 0.7rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 10px;
}

.eyebrow.light { color: rgba(255,255,255,0.55); }

.section-title {
  font-size: clamp(1.6rem, 3vw, 2.4rem);
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

/* ── Stats ───────────────────────────────────────── */
.stats-section {
  border-bottom: 1px solid #e8e8f0;
  padding: 40px 0;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
}

@media (max-width: 768px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

.stat-item {
  padding: 20px 24px;
  border-right: 1px solid #e8e8f0;
  text-align: center;
}

.stat-item:last-child { border-right: none; }

.stat-value {
  font-size: 2.2rem;
  font-weight: 700;
  color: #11298a;
  letter-spacing: -0.03em;
  line-height: 1;
  margin-bottom: 6px;
}

.stat-label {
  font-size: 0.72rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #8890b0;
}

/* ── Testimonials ────────────────────────────────── */
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
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  padding-bottom: 2px;
  transition: background 0.15s;
}

.testi-arrow:hover { background: #f0f0f8; }

.testi-track {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  flex: 1;
}

@media (max-width: 768px) {
  .testi-track { grid-template-columns: 1fr; }
}

.testi-card {
  background: #fff;
  border: 1px solid #e8e8f0;
  border-radius: 16px;
  padding: 24px 22px 20px;
  text-align: left;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.stars {
  color: #11298a;
  font-size: 0.85rem;
  letter-spacing: 2px;
}

.testi-quote {
  font-size: 0.88rem;
  color: #4a5578;
  line-height: 1.7;
  flex: 1;
}

.testi-author {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-top: 14px;
  border-top: 1px solid #e8e8f0;
}

.testi-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  color: #fff;
  font-size: 0.78rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.testi-avatar.large { width: 48px; height: 48px; font-size: 0.9rem; }

.testi-name {
  font-size: 0.88rem;
  font-weight: 700;
  color: #0f1f5e;
  margin-bottom: 2px;
}

.testi-name.light { color: #fff; }

.testi-role {
  font-size: 0.75rem;
  color: #8890b0;
}

.testi-role.light { color: rgba(255,255,255,0.6); }

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

.dot.active { background: #11298a; }

/* ── Featured ────────────────────────────────────── */
.featured-section {
  background: #f7f7fc;
  padding: 64px 0;
}

.featured-card {
  background: #11298a;
  border-radius: 24px;
  padding: 52px 56px;
}

.featured-quote {
  font-size: clamp(1rem, 1.8vw, 1.2rem);
  color: rgba(255,255,255,0.9);
  line-height: 1.75;
  margin: 16px 0 32px;
  max-width: 800px;
}

.featured-author {
  display: flex;
  align-items: center;
  gap: 16px;
}

/* ── CTA ─────────────────────────────────────────── */
.cta-section {
  background: #11298a;
  padding: 80px 0;
}

.cta-content { text-align: center; }

.cta-title {
  font-size: clamp(1.8rem, 3vw, 2.6rem);
  font-weight: 700;
  color: #fff;
  letter-spacing: -0.02em;
  margin-bottom: 12px;
}

.cta-sub {
  color: rgba(255,255,255,0.7);
  font-size: 1rem;
  margin-bottom: 32px;
}

.pill-btn {
  display: inline-block;
  padding: 12px 36px;
  background: #fff;
  color: #11298a;
  font-family: 'DM Sans', sans-serif;
  font-weight: 700;
  font-size: 0.88rem;
  border: none;
  cursor: pointer;
  border-radius: 9999px;
  transition: background 0.15s;
}

.pill-btn:hover { background: #dde1f2; }
</style>