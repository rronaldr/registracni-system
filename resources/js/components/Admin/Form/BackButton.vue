<template>
    <a :href="route" class="btn btn-primary mb-2">{{ $t('app.back') }}</a>
</template>

<script setup>
defineProps({
    route: { type: String, required: true }
})
</script>
