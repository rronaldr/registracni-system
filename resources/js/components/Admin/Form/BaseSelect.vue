<template>
    <label v-if="label">{{ inputLabel }}</label>
    <select
        :value="modelValue"
        class="form-control rounded-0"
        v-bind="{
            ...$attrs,
            onChange: ($event) => {$emit('update:modelValue', $event.target.value)}
        }"
    >
        <option v-if="placeholder" value="" disabled selected hidden>{{ placeholderText }}</option>
        <option
            v-for="option in options"
            :value="option.id"
            :key="option.id"
            :selected="option.id === modelValue"
        >{{ option.name }}</option>
    </select>
</template>

<script setup>
    import {useAttrs} from "vue";

    const props = defineProps({
        label: {type: String, default: ''},
        modelValue: {type: [String, Number], default: ''},
        options: {type: Array, required: true},
        placeholder: {type: Boolean, required: false},
        placeholderText: {type: String, required: false}
    })

    const attrs = useAttrs()

    let inputLabel = attrs.required != null && attrs.required === true
        ? props.label+'*'
        : props.label
</script>
