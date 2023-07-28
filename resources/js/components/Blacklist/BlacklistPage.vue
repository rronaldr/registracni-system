<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <BlacklistUsers
                :blacklist-id="blacklistId"
                ref="listRef"
            />
        </div>
    </div>

    <div class="line"></div><br>

    <div class="row mb-3">
        <div class="col">
            <BlacklistForm
                :blacklist-id="blacklistId"
                @refresh-users="refreshUsers()"
            >
                <template v-slot:csrf>
                    <slot name="csrf"></slot>
                </template>
            </BlacklistForm>
        </div>
    </div>
</template>

<script setup>
import {onMounted, onUnmounted, onUpdated, ref} from "vue";
import BlacklistForm from "./BlacklistForm.vue";
import BlacklistUsers from "./BlacklistUsers.vue";

const props = defineProps({
    blacklistId: {type: Number, required: true}
})

const listRef = ref(null)
// refreshUsers()

function refreshUsers() {
    listRef.value.getUsers()
}


</script>
