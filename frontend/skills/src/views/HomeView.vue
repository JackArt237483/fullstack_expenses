<template>
  <h1>Расходы</h1>

  <form @submit.prevent="addExpense">
    <input v-model="title" :class="{error: errorTitle}" type="text" placeholder="Название">
    <div class="error-message" v-if="errorTitle">{{ errorTitle }}</div>
    <input v-model.number="amount" :class="{error: errorAmount}" type="number" placeholder="Расходы">
    <div class="error-message" v-if="errorAmount">{{ errorAmount }}</div>
    <button>Нажми</button>
  </form>

  <ul>
    <li v-for="e in expenses" :key="e.id">

    <div v-if="editingId === e.id">
      <input v-model="editingTitle" type="text">
      <input v-model.number="editingAmount" type="number">
      <button @click="updateExpense(e.id)">Save</button>
      <button @click="stopEdit(e)">Cancel</button>
    </div>

    
    <div v-else>
      {{ e.title}} - {{e.amount}} руб
        <small>Добавлено: {{ new Date(e.created_at).toLocaleString() }}</small><br>
      <button @click="deleteExpense(e.id)">Delete</button>
      <button @click="startEdit(e)">Edit</button>  
    </div>
    </li>
  </ul>
</template>
<script setup>
  import {ref,onMounted } from 'vue';

  // ТРИ ПЕРЕМЕННЫЕ
  const expenses = ref([])
  const title = ref('')
  const amount = ref(0)
  // ПЕРЕМЕННЫЕ ДЛЯ РЕАДАКТИРОВАНИЯ
  const editingId = ref(null)
  const editingTitle = ref('')
  const editingAmount = ref(0)
  // ПЕРЕМЕННЫЕ ДЛЯ ошибок 
  const errorTitle = ref("")
  const errorAmount = ref("")
  // ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ ДАННЫХ С БЕКА
  const fetchExpenses = async () => {
    const res = await fetch('http://localhost:8000/expenses');
    expenses.value = await res.json()
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
      body: JSON.stringify({"title": title.value , 'amount': amount.value})
    })
    // очищение всех необходмивых данных опсле отправки на сервак
    title.value = ''
    amount.value = 0
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
    errorTitle.value = ""
    errorAmount.value = ""
    // проверка на заголовок
    if(!title.value.trim()){
      errorTitle.value = "Бро поле заполни must have"
    }
    // проверка на значения суммы
    if(!amount.value || amount.value <= 0){
      errorAmount.value = "Бо что то веди"
    }
    // ЕСЛИ ВСЕ НОРМАЛЬНО
    return !errorTitle.value && !errorAmount.value
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
  onMounted(fetchExpenses)
</script>
