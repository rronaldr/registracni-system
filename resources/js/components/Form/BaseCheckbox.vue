<template>
    <input
        type="checkbox"
        :checked="modelValue"
        @change="$emit('update:modelValue', $event.target.checked)"
        class="field"
    />
    <label v-if="label">{{ label }}</label>
</template>

<script setup>
const props = defineProps({
    label: {type: String, default: ''},
    modelValue: {type: Boolean, default: false},
    options: {type: Array, required: true}
})

</script>
