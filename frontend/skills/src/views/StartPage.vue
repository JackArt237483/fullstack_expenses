// Start page
<template>
  <div class="start-page">
    <h1>Добро пожаловать в ФинТрекер 💸</h1>
    <p>Следи за своими расходами. Управляй баблом. Живи красиво.</p>
    <div class="hero-buttons">
      <RouterLink to="/login" class="btn">Войти</RouterLink>
      <RouterLink to="/register" class="btn-outline">Зарегистрироваться</RouterLink>
    </div>
  </div>
</template>

<style scoped>
.start-page {
  text-align: center;
  padding: 40px;
}
.hero-buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 20px;
}
.btn {
  background: #00ffe7;
  padding: 12px 24px;
  border-radius: 12px;
  color: #000;
  font-weight: bold;
  text-decoration: none;
}
.btn-outline {
  border: 2px solid #00ffe7;
  padding: 12px 24px;
  border-radius: 12px;
  color: #00ffe7;
  text-decoration: none;
}
</style>

