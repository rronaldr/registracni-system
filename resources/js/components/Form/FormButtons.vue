<template>
    <div class="mb-3 row">
        <div class="col">
            <BackButton route="route" />
        </div>
        <div class="col text-end">
            <SubmitButton :route="route"/>
        </div>
    </div>
</template>

<script setup>
import SubmitButton from "./SubmitButton.vue";
import BackButton from "./BackButton.vue";

const props = defineProps({
    route: {type: String, required: true}
})
</script>
