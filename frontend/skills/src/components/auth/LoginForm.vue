<script setup>
  import {ref} from "vue";
  import axios from "axios";
  import {useRouter} from "vue-router";
  import { useAuthStore } from "@/stores/auth.js";
  // перменные дял связки
  // дефолтные значения
  const email = ref('')
  const password = ref('')
  // установка то что ошибка пока нет
  const error = ref(null)
  const router = useRouter()
  const auth = useAuthStore()

  const login = async () =>{
    try{
      // данные для отправки на сервер
      const res = await axios.post('http://localhost:8080/auth/login',{
        email: email.value,
        password: password.value
      })
      // произошел логин пускает юзера
      auth.login(res.data.token)
      router.push('/home')
    } catch (err){
        error.value = err.res?.data?.error || "MEN MISTAKE LOGIN"
    }
  }
</script>

<template>
  <form @submit.prevent="login">
    <input type="text" placeholder="email" v-model="email" required>
    <input type="password" placeholder="password man" v-model="password" required>
    <div v-if="error">{error}</div>
    <button type="submit">Login man</button>
  </form>
</template>

<style scoped>

</style>
