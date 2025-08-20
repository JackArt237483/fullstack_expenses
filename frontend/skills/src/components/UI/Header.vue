<template>
  <header class="header">
    <div class="container">
      <h1 class="logo">💰 ФинТрекер</h1>
      <nav v-if="isAuth" class="nav">
        <RouterLink to="/home" class="nav-link">Главная</RouterLink>
        <button @click="handleLogout">Выйти</button>
      </nav>
    </div>
  </header>
</template>

<script setup>
import {RouterLink, useRouter} from 'vue-router';
import { useAuthStore } from "../../stores/auth.js";
// переменная для отслеживания состояния
import { computed} from "vue";
// обьект для редиректа юзера
const router = useRouter();
// обьект для доступа к методам store для проверки токена
const auth = useAuthStore()
// переменная которая будут отслеживать изменения состояния токена
const isAuth = computed(() => auth.isAntificated)
const handleLogout = () => {
  auth.logout()
  router.push('/')
}
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

