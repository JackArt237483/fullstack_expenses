// Форма для добавления
<script setup>
  const props = defineProps(['categories']) // переменная с родителя

</script>

<template>
  <form @submit.prevent="addExpense">
    <input v-model="title" :class="{error: errorTitle}" type="text" placeholder="Название">
    <div class="error-message" v-if="errorTitle">{{ errorTitle ?? "Без категории"}}</div>
    <input v-model.number="amount" :class="{error: errorAmount}" type="number" placeholder="Расходы">
    <div class="error-message" v-if="errorAmount">{{ errorAmount }}</div>
    <select v-model="selectCategory" :class="{error: errorSelect}">
      <option value="">🔥 Выбери категорию</option>
      <option v-for="cat in categories" :value="cat.id" :key="cat.id">
        {{cat.text}}
      </option>
    </select>
    <div class="error-message" v-if="errorSelect">{{ errorSelect }}</div>
    <button>Нажми</button>
  </form>
</template>
