<template>
    <a :href="route" class="btn btn-outline-danger rounded-0 mb-2"><i class="fas fa-times"></i> {{ $t('app.back') }}</a>
</template>

<script setup>
    const props = defineProps({
        route: {type: String, required: true}
    })
</script>
