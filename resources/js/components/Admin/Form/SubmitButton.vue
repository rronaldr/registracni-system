<template>
    <button type="submit" class="btn btn-outline-primary mb-2 text-center">
        <i class="fas fa-save"></i> {{ $t(label) }}
    </button>
</template>

<script setup>
defineProps({
    label: { type: String, required: false, default: 'app.save' }
})
</script>
