<template>
    <div class="form-check form-check-inline">
        <input
            type="radio"
            :checked="modelValue === value"
            :value="value"
            @change="$emit('update:modelValue', value)"
            v-bind="$attrs"
            class="form-check-input"
        />
        <label v-if="label" class="form-check-label">{{ label }}</label>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {type: String, default: ''},
    modelValue: {type: [String, Number], default: ''},
    value: {type: [String, Number], required: true}
})

</script>
