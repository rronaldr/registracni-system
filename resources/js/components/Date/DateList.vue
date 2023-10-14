<template>
    <div class="container bg-white my-5 py-4 px-2 h-auto">
        <div class="row">
            <h2>Nadcházející termíny</h2>
            <DateItem v-for="date in dates" :key="date.id" :date="date" />
        </div>
    </div>
</template>

<script setup>
import DateItem from './DateItem.vue'

defineProps({
    dates: { type: Array, required: true }
})
</script>
