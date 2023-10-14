<template>
    <button
        type="button"
        class="btn btn-sm mb-1 mx-1"
        @click="$emit('setContent', `[${value}]`)"
    >
        {{ label }}
    </button>
</template>

<script setup>
defineEmits(['setContent'])
defineProps({
    label: { type: String, required: true },
    value: { type: String, required: true }
})
</script>
