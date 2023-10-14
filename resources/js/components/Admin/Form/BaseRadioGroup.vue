<template>
    <BaseRadio
        v-for="option in options"
        v-bind="$attrs"
        :key="option.value"
        :label="option.label"
        :value="option.value"
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    />
</template>

<script setup>
import BaseRadio from './BaseRadio.vue'

defineProps({
    options: { type: Array, required: true },
    modelValue: { type: [String, Number, null], required: true }
})
</script>
