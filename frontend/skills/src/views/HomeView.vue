<template>
  <h1>Расходы</h1>

  <form>
    <input type="text" placeholder="=Название">
    <input type="number" placeholder="Расходы">
    <button>Нажми</button>
  </form>
</template>

<script>
  import {ref,onMounted } from 'vue';

  // ТРИ ПЕРЕМЕННЫЕ
  const expenses = ref([])
  const title = ref('')
  const amount = ref(0)
  // ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ ДАННЫХ С БЕКА
  const fetchExpenses = async () => {
    const res = await fetch('/expenses');
    expenses.value = await res.json()
  }
  const addExpenses = async () => {
    await fetch("/expenses",{
      method: "POST",
      headers: "Content-type: application/json",
      body: JSON.stringify({"title": title.value , 'amount': amount.value})
    })
  }
</script>
