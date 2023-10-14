<template>
    <div class="input-group">
        <select
            :value="modelValue"
            class="form-select rounded-0"
            v-bind="{
                ...$attrs,
                onChange: ($event) => {
                    $emit('update:modelValue', $event.target.value)
                }
            }"
        >
            <option v-if="placeholder" value="" selected hidden>
                {{ placeholderText }}
            </option>
            <option
                v-for="option in options"
                :key="option.id"
                :value="option.id"
                :selected="option.id === modelValue"
            >
                {{ option.name }}
            </option>
        </select>
        <button class="btn btn-outline-secondary rounded-0" type="submit">
            {{ $t('app.submit') }}
        </button>
    </div>
</template>

<script setup>
defineProps({
    modelValue: { type: [String, Number], default: '' },
    options: { type: Array, required: true },
    placeholder: { type: Boolean, required: false },
    placeholderText: { type: String, required: false, default: null }
})
</script>
