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

    <!-- Custom blacklist modal start -->
    <div id="infoModal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $t('event.blacklist_modal_title') }}
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-start">
                    <p>
                        {{ $t('event.blacklist_modal_text') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom blacklist modal end -->
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
