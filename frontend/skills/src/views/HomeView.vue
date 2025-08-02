<template>
  <h1>Расходы</h1>
  <ExpenseForm :categories="categories" @add="addExpense"/>
  <ExpenseList
    :expenses="expenses"
    @delete="deleteExpense"
    @update="updateExpense"
  />


</template>
<script setup>
  import {ref,onMounted } from 'vue';
  import ExpenseList from '@/components/ExpenseList.vue';
  import ExpenseForm from '@/components/ExpenseForm.vue';

  // ТРИ ПЕРЕМЕННЫЕ
  const expenses = ref([])
  // ПЕРМЕННЫЕ ДЛЯ КАТЕГОРИЙ
  const categories = ref([])
  // ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ ДАННЫХ С БЕКА
  const fetchExpenses = async () => {
    const res = await fetch('http://localhost:8000/expenses');
    expenses.value = await res.json()
  }
  // ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЕ КАТЕГРИЙ С БЕКА
  const fetchCategories = async () =>{
    const res = await fetch('http://localhost:8000/categories')
    categories.value = await res.json();
  }
  // ФУНКЦИЯ ДЛЯ ДОБАВЛЕНИЯ ЗАПИСЕЙ
  const addExpense = async (payload) => {
    await fetch("http://localhost:8000/expenses",{
      method: "POST",
      headers:{"Content-type": "application/json"},
      body: JSON.stringify(payload)
    })
    // функция обновляет действие после расходов
   fetchExpenses();
  }
  //  ФУНКЦИЯ ДЯЛ УДЛАЕНИЯ ЗАПИСЕЙ
  const deleteExpense = async (id) => {
    await fetch(`http://localhost:8000/expenses/${id}/delete`,{
      method: 'DELETE'
    })
    fetchExpenses()
  }
  // ФУНКЦИЯ ДЛЯ ОБНОВЛЕНИ ЗАПИСЕЙ
  const updateExpense = async ({id,title,amount}) => {
    await fetch(`http://localhost:8000/expenses/${id}/update`,{
      method: "PUT",
      headers: {
        "Content-type": "application/json"
      },
      body: JSON.stringify({title,amount})
    })
    fetchExpenses()
  }
  // хук жизненого цикла
  // при загрузки страницы получаем полный список расходов
  onMounted(()=>{
        fetchExpenses(),
        fetchCategories()
  })
</script>
