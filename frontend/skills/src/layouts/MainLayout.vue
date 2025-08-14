<script setup>

import Header from "@/components/UI/Header.vue";
import Footer from "@/components/UI/Footer.vue";
</script>

<template>
  <div>
    <Header/>
      <main class="main-container">
        <router-view/>
      </main>
    <Footer/>
  </div>
</template>

<style scoped>

</style>
