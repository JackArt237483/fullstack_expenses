<template>
  <form @submit.prevent="onSubmit">
    <input v-model="title" :class="{error: !title}" type="text" placeholder="Название">
    <div class="error-message" v-if="errorTitle">{{ errorTitle ?? "Без категории"}}</div>
    <input v-model.number="amount" :class="{error: amount}" type="number" placeholder="Расходы">
    <div class="error-message" v-if="errorAmount">{{ errorAmount }}</div>
    <select v-model="category" :class="{error: errorSelect}">
      <option value="">🔥 Выбери категорию</option>
      <option v-for="cat in categories" :value="cat.id" :key="cat.id">
        {{cat.text}}
      </option>
    </select>
    <div class="error-message" v-if="errorSelect">{{ errorSelect }}</div>
    <button>Нажми</button>
  </form>
</template>

// Форма для добавления
<script setup>
import { ref } from 'vue'

const props = defineProps(['categories']) // переменная с родителя пропс
const emit = defineEmits(['add']) // родитель держи данные с child

// ТРИ ПЕРЕМЕННЫЕ
const title = ref('')
const amount = ref(0)
const category = ref('')
// ПЕРЕМННЫЕ НА ОШИБКИ
const errorTitle = ref('')
const errorAmount = ref('')
const errorSelect = ref('')


const onSubmit = () => {
  errorTitle.value = ''
  errorAmount.value = ''
  errorSelect.value = ''

  if (!title.value.trim()) errorTitle.value = "Бро поле заполни must have"

  if (!amount.value || amount.value <= 0) errorAmount.value = "Бо что-то веди"

  if (!category.value) errorSelect.value = "Брат заполни поля"


  // 💥 Проверяем, есть ли ошибки — если да, то выходим
  if (errorTitle.value || errorAmount.value || errorSelect.value) return

  // 🚀 Всё валидно — шлём
  emit('add', {
    title: title.value,
    amount: amount.value,
    category_id: category.value
  })

  // очищаем поля
  title.value = ''
  amount.value = 0
  category.value = ''
}


</script>

