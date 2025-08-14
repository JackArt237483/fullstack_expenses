<template>
  <header class="header">
    <div class="container">
      <h1 class="logo">💰 ФинТрекер</h1>
      <nav class="nav">
        <RouterLink to="/" class="nav-link">Главная</RouterLink>
        <RouterLink to="/login" class="nav-link">Вход</RouterLink>
        <RouterLink to="/register" class="nav-link">Регистрация</RouterLink>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { RouterLink } from 'vue-router';
</script>

<style scoped>
.header {
  background-color: #1f2937;
  padding: 16px 0;
  color: white;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.container {
  max-width: 960px;
  margin: 0 auto;
  padding: 0 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo {
  font-size: 1.5rem;
  font-weight: 600;
}

.nav {
  display: flex;
  gap: 16px;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s;
}

.nav-link:hover {
  color: #3b82f6;
}
</style>

