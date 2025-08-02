// Отображение самого расхода
<script setup>
    import { ref } from 'vue'
    const props = defineProps(['expenses'])
    const emit = defineEmits(['update','delete'])

    // ПЕРЕМЕННЫЕ ДЛЯ РЕАДАКТИРОВАНИЯ
    const editing = ref(false)
    const editTitle = ref(props.expenses.title)
    const editAmount = ref(props.expenses.amount)
 
    const save = () =>{
        emit("update",{
            id: props.expenses.id,
            title: editTitle.value,
            amount: editAmount.value           
        })
        editing.value = false
    }

    const cancel = () =>{
        editing.value = false
    }

    const formDate = (dateStr) => new Date(dateStr).toLocaleString()
    // штука полученяи даты
</script>

<template>
    <li>
        <div v-if="editing">
        <input v-model="editTitle" type="text">
        <input v-model.number="editAmount" type="number">
        <button @click="save">💾</button>
        <button @click="cancel">❌</button>
        </div>

        <div v-else>
            {{ expenses.title}}  - {{expenses.amount}} руб
            <small>Категория: {{expenses.category_text}}</small>
            <small>Добавлено: {{ formDate(expenses.created_at)}}</small><br>
            <button @click="editing = true">✏️</button>
            <button @click="$emit('delete', expenses.id)">🗑️</button>
        </div>
    </li>
</template>

<style scoped>

</style>
