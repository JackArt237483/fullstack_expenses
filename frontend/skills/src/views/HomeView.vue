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
  const addExpense = async () => {
    // ВАЛИДАЦИЯ С ФРОНТА
    if(!validate()){
      return
    }

    await fetch("http://localhost:8000/expenses",{
      method: "POST",
      headers:{
        "Content-type": "application/json"
      },
      body: JSON.stringify(
        {
              "title": title.value ,
              "amount": amount.value,
              "category_id": selectCategory.value
        })
    })
    // очищение всех необходмивых данных опсле отправки на сервак
    title.value = ''
    amount.value = 0
    selectCategory.value = ''
    // функция обновляет действие после расходов
    await fetchExpenses();
  }
  //  ФУНКЦИЯ ДЯЛ УДЛАЕНИЯ ЗАПИСЕЙ
  const deleteExpense = async (id) => {
    await fetch(`http://localhost:8000/expenses/${id}/delete`,{
      method: 'DELETE'
    })
    fetchExpenses()
  }
  const validate = () => {
    // ЕСЛИ ВСЕ НОРМАЛЬНО
    return !errorTitle.value && !errorAmount.value && !errorSelect.value
  }
  // ФУНКЦИЯ ДЛЯ РЕДАКТИРВАНИЯ РАСХОДОВ
  const startEdit = (expense) => {
    editingId.value = expense.id
    editingTitle.value = expense.title
    editingAmount.value = expense.amount
  }
  // ФУНКЦИЯ ДЛЯ СБРОСА
  const stopEdit = () => {
    editingId.value = null
    editingTitle.value = ''
    editingAmount.value = 0
  }
  // ФУНКЦИЯ ДЛЯ УДАЛЕНИЯ ЗАПИСЕЙ
  const updateExpense = async (id) => {
    await fetch(`http://localhost:8000/expenses/${id}/update`,{
      method: "PUT",
      headers: {
        "Content-type": "application/json"
      },
      body: JSON.stringify({
        "title": editingTitle.value,
        "amount": editingAmount.value
      })
    })
    stopEdit()
    fetchExpenses()
  }
  // хук жизненого цикла
  // при загрузки страницы получаем полный список расходов
  onMounted(()=>{
        fetchExpenses(),
        fetchCategories()
  })
</script>
