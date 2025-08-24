<script setup>
import { ref, onMounted } from 'vue';
import ExpenseList from '@/components/ExpenseList.vue';
import ExpenseForm from '@/components/ExpenseForm.vue';
import { fetchWithAuth } from "@/utills/fetchWithAuth.js";

const expenses = ref([]);
const categories = ref([]);
const API = "/api"

const fetchExpenses = async () => {
  const res = await fetchWithAuth(`${API}/expenses`);
  expenses.value = res
};

const fetchCategories = async () => {
  const res = await fetchWithAuth(`${API}/categories`);
  categories.value = res
};

const addExpense = async (payload) => {
  await fetchWithAuth(`${API}/expenses`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  });
  fetchExpenses();
};

const deleteExpense = async (id) => {
  await fetchWithAuth(`${API}/expenses/${id}/delete`, { method: "DELETE" });
  fetchExpenses();
};

const updateExpense = async ({ id, title, amount }) => {
  await fetchWithAuth(`${API}/expenses/${id}/update`, {
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
