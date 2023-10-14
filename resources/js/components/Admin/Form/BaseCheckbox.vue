<template>
    <input
        :id="id"
        type="checkbox"
        :checked="modelValue"
        class="form-check-inline"
        v-bind="$attrs"
        @change="$emit('update:modelValue', $event.target.checked)"
    />
    <label v-if="label" :for="id" class="form-check-label">{{
        inputLabel
    }}</label>
</template>

<script setup>
import { useAttrs } from 'vue'

const props = defineProps({
    id: { type: String, required: false, default: null },
    label: { type: String, default: '' },
    modelValue: { type: Boolean, default: false }
})

const attrs = useAttrs()

let inputLabel =
    attrs.required != null && attrs.required === true
        ? props.label + '*'
        : props.label
</script>
