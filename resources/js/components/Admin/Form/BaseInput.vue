<template>
    <label>{{ label }}</label>
    <input
        v-bind="$attrs"
        :placeholder="label"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="form-control"
    />
</template>

<script setup>
    const props = defineProps({
        label: { type: String, default: ''},
        modelValue: { type: [String, Number], default: ''},
    })
</script>
