<template>
  <div class="esg-page">

    <!-- Hero -->
    <section class="hero">
      <div class="hero-img-bg" />
      <div class="hero-overlay" />
      <AppContainer>
        <div class="hero-content col-7">
          <p class="eyebrow">Legal</p>
          <h1 class="hero-title">Terms &amp; Conditions</h1>
          <p class="hero-subtitle">
            Please read these terms carefully before using the esBG Reporting platform.
          </p>
          <p class="hero-meta">Last updated: 1 January 2025</p>
        </div>
      </AppContainer>
    </section>

    <!-- Body -->
    <section class="section">
      <AppContainer>
        <div class="terms-layout">

          <!-- TOC -->
          <aside class="toc">
            <p class="toc-title">Contents</p>
            <nav>
              <a
                v-for="item in sections"
                :key="item.id"
                :href="`#${item.id}`"
                class="toc-link"
                :class="{ active: activeSection === item.id }"
                @click.prevent="scrollTo(item.id)"
              >
                <span class="toc-num">{{ item.num }}</span>
                {{ item.title }}
              </a>
            </nav>
          </aside>

          <!-- Content -->
          <div class="terms-body">
            <div v-for="sec in sections" :key="sec.id" :id="sec.id" class="terms-section">
              <div class="section-heading">
                <span class="sec-num">{{ sec.num }}</span>
                <h2 class="sec-title">{{ sec.title }}</h2>
              </div>
              <div class="sec-content" v-html="sec.content" />
            </div>

            <!-- Acceptance -->
            <div class="acceptance-card">
              <p class="ac-title">By using esBG Reporting, you agree to these terms.</p>
              <p class="ac-sub">
                If you have questions, contact our legal team at
                <a href="mailto:legal@esbg-reporting.com" class="ac-link">legal@esbg-reporting.com</a>
              </p>
            </div>
          </div>

        </div>
      </AppContainer>
    </section>

  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const activeSection = ref('acceptance')

function scrollTo(id: string) {
  activeSection.value = id
  document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

const sections = [
  {
    id: 'acceptance',
    num: '01',
    title: 'Acceptance of Terms',
    content: `
      <p>By accessing or using the esBG Reporting platform ("Service"), you agree to be bound by these Terms and Conditions ("Terms"). If you do not agree to all of these Terms, you may not access or use the Service.</p>
      <p>These Terms apply to all users of the Service, including without limitation users who are browsers, clients, merchants, and contributors of content.</p>
      <p>We reserve the right to update and change these Terms at any time without prior notice. Continued use of the Service after any such changes constitutes your acceptance of the new Terms.</p>
    `,
  },
  {
    id: 'use',
    num: '02',
    title: 'Use of the Service',
    content: `
      <p>You may use the Service only for lawful purposes and in accordance with these Terms. You agree not to use the Service:</p>
      <ul>
        <li>In any way that violates any applicable national or international law or regulation.</li>
        <li>To transmit, or procure the sending of, any unsolicited or unauthorized advertising or promotional material.</li>
        <li>To impersonate or attempt to impersonate esBG Reporting, an esBG employee, another user, or any other person or entity.</li>
        <li>To engage in any conduct that restricts or inhibits anyone's use or enjoyment of the Service.</li>
      </ul>
      <p>We reserve the right to terminate or suspend your access immediately, without prior notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties.</p>
    `,
  },
  {
    id: 'accounts',
    num: '03',
    title: 'Accounts & Registration',
    content: `
      <p>When you create an account with us, you guarantee that the information you provide is accurate, complete, and current at all times. Inaccurate or incomplete information may result in the immediate termination of your account.</p>
      <p>You are responsible for maintaining the confidentiality of your account and password, including restriction of access to your computer and account. You agree to accept responsibility for any and all activities that occur under your account.</p>
      <p>You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>
    `,
  },
  {
    id: 'data',
    num: '04',
    title: 'Data & Privacy',
    content: `
      <p>Your use of the Service is also governed by our Privacy Policy, which is incorporated into these Terms by reference. Please review our Privacy Policy, which describes our practices regarding data collection, use, and disclosure.</p>
      <p>You retain ownership of all ESG data, reports, and content you submit to the platform ("Your Content"). By submitting Your Content, you grant esBG Reporting a non-exclusive, worldwide, royalty-free licence to use, reproduce, and display Your Content solely to the extent necessary to provide the Service.</p>
      <p>We implement industry-standard security measures to protect your data. However, no method of transmission over the Internet is 100% secure.</p>
    `,
  },
  {
    id: 'ip',
    num: '05',
    title: 'Intellectual Property',
    content: `
      <p>The Service and its original content (excluding Your Content), features, and functionality are and will remain the exclusive property of esBG Reporting and its licensors. The Service is protected by copyright, trademark, and other laws.</p>
      <p>Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of esBG Reporting.</p>
      <p>You may not reproduce, distribute, modify, create derivative works of, publicly display, or transmit any of the material on our Service without our express written consent.</p>
    `,
  },
  {
    id: 'liability',
    num: '06',
    title: 'Limitation of Liability',
    content: `
      <p>In no event shall esBG Reporting, its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, goodwill, or other intangible losses, resulting from:</p>
      <ul>
        <li>Your access to or use of (or inability to access or use) the Service.</li>
        <li>Any conduct or content of any third party on the Service.</li>
        <li>Any content obtained from the Service.</li>
        <li>Unauthorized access, use, or alteration of your transmissions or content.</li>
      </ul>
    `,
  },
  {
    id: 'termination',
    num: '07',
    title: 'Termination',
    content: `
      <p>We may terminate or suspend your account and access to the Service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever, including but not limited to a breach of the Terms.</p>
      <p>Upon termination, your right to use the Service will immediately cease. All provisions of the Terms which by their nature should survive termination shall survive termination.</p>
    `,
  },
  {
    id: 'governing',
    num: '08',
    title: 'Governing Law',
    content: `
      <p>These Terms shall be governed and construed in accordance with the laws of the applicable jurisdiction, without regard to its conflict of law provisions.</p>
      <p>These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have had between us regarding the Service.</p>
    `,
  },
  {
    id: 'contact',
    num: '09',
    title: 'Contact',
    content: `
      <p>If you have any questions about these Terms, please contact us:</p>
      <ul>
        <li><strong>Email:</strong> legal@esbg-reporting.com</li>
        <li><strong>Address:</strong> 123 Business St, City, State 12345</li>
        <li><strong>Phone:</strong> +1 (555) 123-4567</li>
      </ul>
    `,
  },
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
  background: url('https://images.unsplash.com/photo-1552693938-9f0c6c54d980?w=1400&q=80') center / cover no-repeat;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(10,22,90,0.95) 0%, rgba(10,22,90,0.75) 55%, rgba(10,22,90,0.35) 100%);
  z-index: 1;
}

.hero-content { position: relative; z-index: 2; }

.eyebrow {
  font-size: 0.7rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.55);
  margin-bottom: 12px;
}

.hero-title {
  font-size: clamp(2rem, 5vw, 3.4rem);
  font-weight: 700;
  color: #fff;
  line-height: 1.1;
  letter-spacing: -0.02em;
  margin-bottom: 16px;
}

.hero-subtitle {
  font-size: 1rem;
  color: rgba(255,255,255,0.75);
  max-width: 460px;
  line-height: 1.65;
  margin-bottom: 20px;
}

.hero-meta {
  font-size: 0.72rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.35);
}

/* ── Section ─────────────────────────────────────── */
.section { padding: 72px 0 96px; }

/* ── Layout ──────────────────────────────────────── */
.terms-layout {
  display: grid;
  grid-template-columns: 210px 1fr;
  gap: 64px;
  align-items: start;
}

@media (max-width: 768px) {
  .terms-layout { grid-template-columns: 1fr; gap: 40px; }
}

/* ── TOC ─────────────────────────────────────────── */
.toc { position: sticky; top: 32px; }

.toc-title {
  font-size: 0.68rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #8890b0;
  margin-bottom: 16px;
}

.toc-link {
  display: flex;
  align-items: baseline;
  gap: 10px;
  padding: 9px 0;
  border-bottom: 1px solid #eeeef6;
  text-decoration: none;
  font-size: 0.82rem;
  color: #6a7099;
  transition: color 0.15s;
}

.toc-link:hover,
.toc-link.active { color: #11298a; }

.toc-link.active { font-weight: 700; }

.toc-num {
  font-size: 0.65rem;
  letter-spacing: 0.1em;
  color: #8890b0;
  flex-shrink: 0;
}

/* ── Terms content ───────────────────────────────── */
.terms-body { display: flex; flex-direction: column; }

.terms-section {
  padding: 44px 0;
  border-bottom: 1px solid #e8e8f0;
}

.terms-section:first-child { padding-top: 0; }

.section-heading {
  display: flex;
  align-items: baseline;
  gap: 16px;
  margin-bottom: 20px;
}

.sec-num {
  font-size: 0.7rem;
  letter-spacing: 0.15em;
  color: #8890b0;
  flex-shrink: 0;
}

.sec-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #0f1f5e;
  letter-spacing: -0.01em;
}

.sec-content :deep(p) {
  font-size: 0.9rem;
  color: #4a5578;
  line-height: 1.8;
  margin-bottom: 12px;
}

.sec-content :deep(p:last-child) { margin-bottom: 0; }

.sec-content :deep(ul) {
  font-size: 0.9rem;
  color: #4a5578;
  line-height: 1.8;
  padding-left: 20px;
  margin: 10px 0;
}

.sec-content :deep(li) { margin-bottom: 6px; }

.sec-content :deep(strong) { color: #0f1f5e; font-weight: 700; }

/* ── Acceptance card ─────────────────────────────── */
.acceptance-card {
  background: #11298a;
  border-radius: 20px;
  padding: 40px 44px;
  margin-top: 48px;
}

.ac-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #fff;
  margin-bottom: 10px;
}

.ac-sub {
  font-size: 0.88rem;
  color: rgba(255,255,255,0.65);
}

.ac-link {
  color: rgba(255,255,255,0.9);
  text-decoration: underline;
}

.ac-link:hover { color: #fff; }
</style>