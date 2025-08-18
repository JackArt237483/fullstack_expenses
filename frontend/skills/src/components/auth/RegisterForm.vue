<script setup>
  // импорт всего необходимого
  import {ref} from "vue";
  import axios from "axios";
  import  {useRouter} from "vue-router";
  // импортируем перменные реактивные
  const name = ref('')
  const email = ref('')
  const password = ref('')
  const error = ref(null)
  const router = useRouter()
  // функция регистрации
  const register = async () => {
    try{
      const res = await axios.post("http://localhost:8080/auth/register",{
        name: name.value,
        email: email.value,
        password: password.value
      })
      localStorage.setItem('token',res.data.token)
      router.push("/login");
    } catch (err) {
      // если сервер вернул ошибку покажи ошибку
      error.value = err.res?.data?.error || 'MEN MISTAKE REGISTRATION'
    }
  }
</script>

<template>
  <form @submit.prevent="register">
    <input v-model="name" type="text" placeholder="Имя" required>
    <input v-model="email" type="text" placeholder="Email" required>
    <input v-model="password" type="password" placeholder="Пароль" required>
    <div v-if="error" class="error-message">{error}</div>
    <button type="submit">Register man</button>
  </form>
</template>

<style scoped>

</style>
