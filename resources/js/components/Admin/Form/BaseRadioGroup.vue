<template>
    <BaseRadio
        v-for="option in options"
        :key="option.value"
        :label="option.label"
        :value="option.value"
        :name="name"
        :modelValue="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    />
</template>

<script setup>
import BaseRadio from "./BaseRadio.vue";

const props = defineProps({
    options: {type: Array, required: true},
    name: {type: String, required: true},
    modelValue: {type: [String, Number], required: true},
})
</script>
