<template>
    <input
        type="checkbox"
        :checked="modelValue"
        :id="id"
        @change="$emit('update:modelValue', $event.target.checked)"
        class="form-check-input field"
    />
    <label v-if="label" :for="id" class="form-check-label">{{ label }}</label>
</template>

<script setup>
const props = defineProps({
    id: {type: String, required: false},
    label: {type: String, default: ''},
    modelValue: {type: Boolean, default: false},
})

</script>
