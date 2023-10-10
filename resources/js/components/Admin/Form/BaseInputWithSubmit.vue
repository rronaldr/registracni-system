<template>
    <div class="input-group mb-3">
        <input
            v-bind="$attrs"
            :placeholder="inputLabel"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="form-control"
        />
        <button class="btn btn-outline-secondary" type="submit">{{ $t('app.submit') }}</button>
    </div>
</template>

<script setup>
import {useAttrs} from "vue";

const props = defineProps({
    label: { type: String, default: ''},
    modelValue: { type: [String, Number], default: ''},
})
const attrs = useAttrs()

let inputLabel = attrs.required != null && attrs.required === true
    ? props.label+'*'
    : props.label
</script>
