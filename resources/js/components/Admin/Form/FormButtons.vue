<template>
    <div class="mb-3 row">
        <div class="col">
            <BackButton :route="route" />
        </div>
        <div class="col text-right">
            <SubmitButton />
        </div>
    </div>
</template>

<script setup>
import SubmitButton from './SubmitButton.vue'
import BackButton from './BackButton.vue'

defineProps({
    route: { type: String, required: true }
})
</script>
