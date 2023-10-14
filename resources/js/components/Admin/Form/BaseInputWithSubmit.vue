<template>
    <div class="input-group mb-3">
        <input
            v-bind="$attrs"
            :placeholder="inputLabel"
            :value="modelValue"
            class="form-control rounded-0"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <button class="btn btn-outline-secondary rounded-0" type="submit">
            {{ $t('app.submit') }}
        </button>
    </div>
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
