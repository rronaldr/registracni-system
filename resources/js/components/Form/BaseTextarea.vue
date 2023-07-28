<template>
    <label>{{ label }}</label>
    <textarea
        v-bind="$attrs"
        :placeholder="label"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="form-control"
    >

    </textarea>
</template>

<script setup>
const props = defineProps({
    label: { type: String, default: ''},
    modelValue: { type: [String, Number], default: ''},
})
</script>
