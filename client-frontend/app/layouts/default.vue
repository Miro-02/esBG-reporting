<template>
  <v-app class="v-app-default">
    <AppHeader />
    
    <!-- Main content area with semantic HTML -->
    <main id="main-content" role="main" class="main-content">
      <v-main>
        <NuxtPage />
      </v-main>
    </main>
    
    <AppFooter />
  </v-app>
</template>

<script setup>
// Import your wrapper components
import AppHeader from "@/components/AppHeader.vue";
import AppFooter from "@/components/AppFooter.vue";
</script>

<style scoped>
.v-app-default {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  outline: none;
  /* Focus visible support for keyboard users */
}

.main-content:focus-visible {
  outline: 2px solid #11298a;
  outline-offset: 2px;
}
</style>
