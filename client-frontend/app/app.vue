<template>
  <NuxtLayout>
    <NuxtLoadingIndicator />
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup>
const config = useRuntimeConfig();

onMounted(async () => {
  try {
    await $fetch("/sanctum/csrf-cookie", {
      baseURL: config.public.apiBaseUrl,
      credentials: "include",
    });
  } catch (error) {
    console.error("Failed to initialize CSRF cookie", error);
  }
});
</script>
