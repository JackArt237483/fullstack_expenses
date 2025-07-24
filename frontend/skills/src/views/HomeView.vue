<template>
  <h1>Расходы</h1>

  <form @submit.prevent="addExpense">
    <input v-model="title" type="text" placeholder="Название">
    <input v-model.number="amount" type="number" placeholder="Расходы">
    <button>Нажми</button>
  </form>

  <ul>
    <li v-for="e in expenses" :key="e.id">
      {{ e.title}} - {{e.amount}} руб
    </li>
  </ul>
</template>
// SETUP ЧТО VUE ПОНИМАЛ ЧТО ОН ХОЧЕТ
<script setup>
  import {ref,onMounted } from 'vue';

  // ТРИ ПЕРЕМЕННЫЕ
  const expenses = ref([])
  const title = ref('')
  const amount = ref(0)
  // ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ ДАННЫХ С БЕКА
  const fetchExpenses = async () => {
    const res = await fetch('http://localhost:8000/expenses');
    expenses.value = await res.json()
  }
  const addExpense = async () => {
    await fetch("http://localhost:8000/expenses",{
      method: "POST",
      headers:{
        "Content-type": "application/json"
      },
      body: JSON.stringify({"title": title.value , 'amount': amount.value})
    })
    // очищение всех необходмивых данных опсле отправки на сервак
    title.value = ''
    amount.value = 0
    // функция обновляет действие после расходов
    fetchExpenses();
  }
  // хук жизненого цикла
  // при загрузки страницы получаем полный список расходов
  onMounted(fetchExpenses)
</script>
