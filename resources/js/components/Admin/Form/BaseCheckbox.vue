<template>
    <input
        type="checkbox"
        :checked="modelValue"
        :id="id"
        @change="$emit('update:modelValue', $event.target.checked)"
        class="form-check-input field mr-1"
        v-bind="$attrs"
    />
    <label v-if="label" :for="id" class="form-check-label">{{ inputLabel }}</label>
</template>

<script setup>
import {useAttrs} from "vue";

const props = defineProps({
    id: {type: String, required: false},
    label: {type: String, default: ''},
    modelValue: {type: Boolean, default: false},
})

const attrs = useAttrs()

let inputLabel = attrs.required != null && attrs.required === true
    ? props.label+'*'
    : props.label
</script>
