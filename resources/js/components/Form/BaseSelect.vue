<template>
    <label v-if="label">{{ label }}</label>
    <select
        :value="modelValue"
        class="form-control"
        v-bind="{
            ...$attrs,
            onChange: ($event) => {$emit('update:modelValue', $event.target.value)}
        }"
    >
        <option
            v-for="option in options"
            :value="option"
            :key="option"
            :selected="option === modelValue"
        >{{ option }}</option>
    </select>
</template>

<script setup>
    const props = defineProps({
        label: {type: String, default: ''},
        modelValue: {type: [String, Number], default: ''},
        options: {type: Array, required: true}
    })
</script>
