<template>
  <main>
    <!-- Loading State -->
    <div v-if="isLoad" class="flex items-center justify-center h-screen">
      <img :src="Loading" class="w-12 h-12 animate-spin" alt="loading" />
      <p class="ml-4">Loading, please wait...</p>
    </div>

    <!-- Content Display -->
    <div v-else>
      <Navbar v-if="isAuthenticated" />
      <router-view></router-view>
    </div>
  </main>
</template>

<script setup>
import { computed } from "vue";
import { useAuthStore } from "./stores/authStore";
import Navbar from "./components/layout/Navbar.vue";
import { Loading } from "./assets";
const authStore = useAuthStore();
const isAuthenticated = computed(() => authStore.isAuthenticated);
const isLoad = computed(() => authStore.userLoading);
</script>
