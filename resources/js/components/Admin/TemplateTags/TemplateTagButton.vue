<template>
    <button @click="$emit('setContent', value)"
            type="button" class="btn btn-light mx-2">{{ label }}</button>
</template>

<script setup>
const emits = defineEmits(['setContent'])
const props = defineProps({
    label: {type: String, required: true},
    value: {type: String, required: true}
})

</script>
