// Отображение списка расходов
<script setup>
    import ExpenseItem from "../components/ExpenseItem.vue"
    defineProps(['expenses','update','delete'])
</script>

<template>
    <ul>
        <ExpenseItem
            v-for="e in expenses" 
            :key="e.id"
            :expenses="e"
            @update = "$emit('update',$event)"
            @delete = "$emit('delete',$event)"
        />
    </ul>
</template>

