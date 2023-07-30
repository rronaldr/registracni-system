<template>
    <a href="{{ route }}" class="btn btn-danger mb-2"><i class="fas fa-times"></i> {{ $t('app.back') }}</a>
</template>

<script setup>
    const props = defineProps({
        route: {type: String, required: true}
    })
</script>
