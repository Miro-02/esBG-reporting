<template>
  <div class="esg-page">

    <!-- Hero -->
    <section class="hero">
      <div class="hero-img-bg" />
      <div class="hero-overlay" />
      <AppContainer>
        <div class="hero-content col-7">
          <p class="eyebrow">About us</p>
          <h1 class="hero-title">About esBG Reporting</h1>
          <p class="hero-subtitle">
            Leading the ESG reporting revolution with transparency, precision, and real-world action.
          </p>
        </div>
      </AppContainer>
    </section>

    <!-- Mission -->
    <section class="section">
      <AppContainer>
        <div class="section-header">
          <p class="eyebrow">Our Mission</p>
          <h2 class="section-title">Why we exist</h2>
        </div>
        <div class="cards-grid">
          <div class="mission-card" v-for="item in missionItems" :key="item.title">
            <div class="card-icon">{{ item.icon }}</div>
            <h3 class="card-title">{{ item.title }}</h3>
            <p class="card-text">{{ item.text }}</p>
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Values -->
    <section class="section values-section">
      <AppContainer>
        <div class="values-layout">
          <div class="values-left">
            <p class="eyebrow">Our Values</p>
            <h2 class="section-title">What drives us</h2>
            <p class="body-text mt">
              We believe environmental and social responsibility is the foundation of sustainable business growth.
              Our commitment to these values drives every decision — from how we build our platform to the standards we help clients achieve.
            </p>
            <p class="body-text mt">
              Accountability, transparency, and measurable impact aren't just buzzwords. They're the principles we embed into every feature we ship.
            </p>
          </div>
          <div class="values-right">
            <div class="value-item" v-for="val in values" :key="val.title">
              <div class="value-number">{{ val.num }}</div>
              <div>
                <p class="value-title">{{ val.title }}</p>
                <p class="value-desc">{{ val.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </AppContainer>
    </section>

  </div>
</template>

<script setup lang="ts">
const missionItems = [
  {
    icon: '◎',
    title: 'Transparent',
    text: 'esBG Reporting gives companies a comprehensive platform to track, manage, and disclose their ESG metrics with full traceability and auditability.',
  },
  {
    icon: '◈',
    title: 'Accessible',
    text: 'We remove the barriers to ESG compliance — making structured reporting simple and approachable for businesses of all sizes and sectors.',
  },
  {
    icon: '◆',
    title: 'Actionable',
    text: 'Our tools transform raw ESG data into strategic insight, helping organizations act on their commitments rather than just report them.',
  },
]

const values = [
  { num: '01', title: 'Sustainability at every step', desc: 'We hold ourselves to the same standards we help our clients achieve.' },
  { num: '02', title: 'Data integrity first', desc: 'Every metric is traceable, auditable, and built on verified sources.' },
  { num: '03', title: 'Impact over optics', desc: 'We measure what matters — real environmental and social outcomes.' },
  { num: '04', title: 'Partnership mindset', desc: 'Your ESG goals become our mission. We grow together.' },
]
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
  max-width: 480px;
  line-height: 1.65;
}

/* ── Shared ──────────────────────────────────────── */
.section { padding: 80px 0; }

.section-header { margin-bottom: 48px; }

.eyebrow {
  font-size: 0.7rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 10px;
}

.section-title {
  font-size: clamp(1.6rem, 3vw, 2.4rem);
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

.body-text {
  font-size: 0.95rem;
  color: #4a5578;
  line-height: 1.75;
}

.mt { margin-top: 16px; }

/* ── Mission cards ───────────────────────────────── */
.cards-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

@media (max-width: 768px) {
  .cards-grid { grid-template-columns: 1fr; }
}

.mission-card {
  background: #f7f7fc;
  border: 1px solid #e8e8f0;
  border-radius: 16px;
  padding: 36px 30px;
  transition: box-shadow 0.2s;
}

.mission-card:hover {
  box-shadow: 0 8px 32px rgba(17,41,138,0.08);
}

.card-icon {
  font-size: 1.5rem;
  color: #11298a;
  margin-bottom: 18px;
}

.card-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #0f1f5e;
  margin-bottom: 10px;
}

.card-text {
  font-size: 0.88rem;
  color: #4a5578;
  line-height: 1.7;
}

/* ── Values ──────────────────────────────────────── */
.values-section { background: #f7f7fc; }

.values-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: start;
}

@media (max-width: 768px) {
  .values-layout { grid-template-columns: 1fr; gap: 40px; }
}

.values-right { display: flex; flex-direction: column; }

.value-item {
  display: flex;
  gap: 20px;
  align-items: flex-start;
  padding: 22px 0;
  border-bottom: 1px solid #e0e0ee;
}

.value-item:last-child { border-bottom: none; }

.value-number {
  font-size: 0.7rem;
  letter-spacing: 0.15em;
  color: #8890b0;
  padding-top: 3px;
  flex-shrink: 0;
  width: 28px;
}

.value-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: #0f1f5e;
  margin-bottom: 4px;
}

.value-desc {
  font-size: 0.85rem;
  color: #6a7099;
  line-height: 1.55;
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
  min-height: 44px;
  min-width: 44px;
  outline: none;
}

.pill-btn:hover { background: #dde1f2; }

.pill-btn:focus-visible {
  outline: 2px solid white;
  outline-offset: 2px;
}

@media (max-width: 768px) {
  .section {
    padding: 48px 0;
  }
  
  .hero {
    height: auto;
    min-height: 500px;
  }
  
  .section-title {
    font-size: 1.5rem;
  }
  
  .cards-grid {
    grid-template-columns: 1fr;
  }
  
  .values-layout {
    gap: 32px;
  }
}
</style>