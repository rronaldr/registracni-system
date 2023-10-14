<template>
    <label v-if="label">{{ inputLabel }}</label>
    <select
        :value="modelValue"
        class="form-control rounded-0"
        v-bind="{
            ...$attrs,
            onChange: ($event) => {
                $emit('update:modelValue', $event.target.value)
            }
        }"
    >
        <option :value="0" :selected="true">
            {{ $t('template.default') }}
        </option>
        <option v-for="option in options" :key="option.id" :value="option.id">
            {{ option.name }}
        </option>
    </select>
</template>

<script setup>
import { useAttrs } from 'vue'

const props = defineProps({
    label: { type: String, default: '' },
    modelValue: { type: [String, Number], default: '' },
    options: { type: [Array, null], required: true }
})

const attrs = useAttrs()

let inputLabel =
    attrs.required != null && attrs.required === true
        ? props.label + '*'
        : props.label
</script>
