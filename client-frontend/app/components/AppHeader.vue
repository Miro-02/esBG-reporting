<template>
  <v-app-bar>
    <v-toolbar-title>
      <NuxtLink to="/" class="no-underline text-current cursor-pointer text-lg font-semibold">
        esBG reporting
      </NuxtLink>
    </v-toolbar-title>
    <v-spacer />
    <NuxtLink to="/login">
      <v-btn variant="text" color="primary">Login</v-btn>
    </NuxtLink>
    <NuxtLink to="/register">
      <v-btn variant="text" color="primary">Register</v-btn>
    </NuxtLink>
    <v-btn @click="toggleTheme" icon="mdi-theme-light-dark" />
    <slot />
  </v-app-bar>
</template>

<script setup lang="ts">
import { useTheme } from "vuetify";
import { onMounted } from "vue";

const theme = useTheme();

// Load saved theme preference on mount
onMounted(() => {
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme) {
    theme.change(savedTheme);
  }
});

const toggleTheme = () => {
  const newTheme = theme.global.current.value.dark ? "light" : "dark";
  theme.change(newTheme);
  localStorage.setItem("theme", newTheme);
};
</script>
