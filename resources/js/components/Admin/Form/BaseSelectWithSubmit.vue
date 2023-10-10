<template>
    <div class="input-group">
        <select
            :value="modelValue"
            class="form-select"
            v-bind="{
            ...$attrs,
            onChange: ($event) => {$emit('update:modelValue', $event.target.value)}
        }"
        >
            <option v-if="placeholder" value="" selected hidden>{{ placeholderText }}</option>
            <option
                v-for="option in options"
                :value="option.id"
                :key="option.id"
                :selected="option.id === modelValue"
            >{{ option.name }}</option>
        </select>
        <button class="btn btn-outline-secondary" type="submit">{{ $t('app.submit') }}</button>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {type: [String, Number], default: ''},
    options: {type: Array, required: true},
    placeholder: {type: Boolean, required: false},
    placeholderText: {type: String, required: false}
})
</script>
