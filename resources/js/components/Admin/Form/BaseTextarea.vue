<template>
    <label>{{ inputLabel }}</label>
    <textarea
        v-bind="$attrs"
        :placeholder="label"
        :value="modelValue"
        class="form-control rounded-0"
        @input="$emit('update:modelValue', $event.target.value)"
    >
    </textarea>
</template>

<script setup>
import { useAttrs } from 'vue'

const props = defineProps({
    label: { type: String, default: '' },
    modelValue: { type: [String, Number], default: '' }
})

const attrs = useAttrs()

let inputLabel =
    attrs.required != null && attrs.required === true
        ? props.label + '*'
        : props.label
</script>
