<template>
    <BaseRadio
        v-for="option in options"
        :key="option.value"
        :label="option.label"
        :value="option.value"
        :modelValue="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    />
</template>

<script setup>
import BaseRadio from "./BaseRadio.vue";

const props = defineProps({
    options: {type: Array, required: true},
    modelValue: {type: [String, Number], required: true},
})
</script>
