<template>
    <div
        v-if="show"
        class="modal modal-backdrop"
        role="dialog"
        v-bind="{
            ...$attrs
        }"
        @click.self="$emit('close')"
    >
        <div class="modal-container overflow-auto">
            <div class="modal-header">
                <slot name="modal-header"></slot>
                <button
                    type="button"
                    class="close"
                    aria-label="Close"
                    @click="$emit('close')"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <slot name="modal-body"></slot>
            </div>

            <div class="modal-footer">
                <slot name="modal-footer"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    show: { type: Boolean, required: true }
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
    min-width: 30%;
    max-height: 100%;
    overflow-y: auto;
}

.modal-header {
    align-items: baseline;
    padding: 0;
    border-bottom: 0;
}
</style>
