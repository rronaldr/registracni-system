<template>
    <input
        type="checkbox"
        :checked="modelValue"
        @change="$emit('update:modelValue', $event.target.checked)"
        class="form-check-input"
    />
    <label v-if="label" class="form-check-label">{{ label }}</label>
</template>

<script setup>
const props = defineProps({
    label: {type: String, default: ''},
    modelValue: {type: Boolean, default: false},
})

</script>
