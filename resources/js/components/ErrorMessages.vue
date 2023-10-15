<template>
    <div v-if="errors" class="row mb-3">
        <div
            class="bg-danger text-white py-1 px-1 pr-0 rounded font-bold mb-2 shadow-lg"
        >
            <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error.toUpperCase() }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    errors: { type: Array, required: false, default: null}
})
</script>