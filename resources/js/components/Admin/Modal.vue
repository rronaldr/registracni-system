<template>
    <div v-if="show" @click.self="$emit('close')" class="modal modal-backdrop modal-lg" role="dialog">
        <div class="modal-container">
            <div class="modal-header">
                <slot name="modal-header"></slot>
                <button @click="$emit('close')"  type="button" class="btn-close" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <slot name="modal-body"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    show: {type: Boolean, required: true}
})
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    transition: opacity 0.3s ease;
}

.modal-body {
    padding-left: 0;
    padding-right: 0;
}

.modal-container {
    margin: auto;
    padding: 20px 30px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
}

.modal-header {
    align-items: baseline;
    padding: 0;
    border-bottom: 0;
}
</style>
