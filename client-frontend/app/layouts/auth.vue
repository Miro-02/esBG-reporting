<template>
  <v-app class="v-app-auth">
    <!-- Main content area with semantic HTML -->
    <main id="main-content" role="main" class="main-content">
      <v-main>
        <NuxtPage />
      </v-main>
    </main>
  </v-app>
</template>

<script setup lang="ts">
</script>

<style scoped>
.v-app-auth {
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