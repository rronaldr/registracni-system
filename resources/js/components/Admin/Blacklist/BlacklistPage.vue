<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <BlacklistUsers ref="listRef" :blacklist-id="blacklistId" />
        </div>
    </div>

    <div class="line"></div>
    <br />

    <div class="row mb-3">
        <div class="col">
            <BlacklistForm
                :blacklist-id="blacklistId"
                @refresh-users="refreshUsers()"
            >
                <template #csrf>
                    <slot name="csrf"></slot>
                </template>
            </BlacklistForm>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import BlacklistForm from './BlacklistForm.vue'
import BlacklistUsers from './BlacklistUsers.vue'

defineProps({
    blacklistId: { type: Number, required: true }
})

const listRef = ref(null)

function refreshUsers() {
    listRef.value.getUsers()
}
</script>
