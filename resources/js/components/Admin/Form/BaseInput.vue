<template>
    <label>{{ inputLabel }}</label>
    <input
        v-bind="$attrs"
        :placeholder="label"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="form-control rounded-0"
    />
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
