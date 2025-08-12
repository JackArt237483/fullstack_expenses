<script setup>
import { ref, onMounted } from 'vue';
import ExpenseList from '@/components/ExpenseList.vue';
import ExpenseForm from '@/components/ExpenseForm.vue';

const expenses = ref([]);
const categories = ref([]);
const API = "/api"

const fetchExpenses = async () => {
  const res = await fetch(`${API}/expenses`);
  if (!res.ok) throw new Error(`Ошибка запроса: ${res.status}`);
  expenses.value = await res.json();
};

const fetchCategories = async () => {
  const res = await fetch(`${API}/categories`);
  if (!res.ok) throw new Error(`Ошибка запроса: ${res.status}`);
  categories.value = await res.json();
};

const addExpense = async (payload) => {
  await fetch(`${API}/expenses`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  });
  fetchExpenses();
};

const deleteExpense = async (id) => {
  await fetch(`${API}/expenses/${id}/delete`, { method: "DELETE" });
  fetchExpenses();
};

const updateExpense = async ({ id, title, amount }) => {
  await fetch(`${API}/expenses/${id}/update`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ title, amount })
  });
  fetchExpenses();
};

onMounted(() => {
  fetchExpenses();
  fetchCategories();
});
</script>

<template>
  <h1>Расходы</h1>
  <ExpenseForm :categories="categories" @add="addExpense" />
  <ExpenseList :expenses="expenses" @delete="deleteExpense" @update="updateExpense" />
</template>
