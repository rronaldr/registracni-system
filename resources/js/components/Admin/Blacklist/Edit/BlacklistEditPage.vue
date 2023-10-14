<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <BlacklistEditUsers ref="listRef" :blacklist-id="blacklistId" />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <BlacklistEditForm
                :blacklist-id="blacklistId"
                @refresh-users="refreshUsers()"
            >
                <template #csrf>
                    <slot name="csrf"></slot>
                </template>
            </BlacklistEditForm>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import BlacklistEditForm from './BlacklistEditForm.vue'
import BlacklistEditUsers from './BlacklistEditUsers.vue'

defineProps({
    blacklistId: { type: Number, required: true }
})

const listRef = ref(null)

function refreshUsers() {
    listRef.value.getUsers()
}
</script>
