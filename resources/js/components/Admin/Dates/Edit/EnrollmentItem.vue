<template>
    <tr>
        <td>{{ enrollment.xname }}</td>
        <td>{{ enrollment.email }}</td>
        <td>{{ enrollment.enrolled }}</td>
        <td>{{ $t('enrollment.statuses.' + enrollment.state) }}</td>
        <td>{{ enrollment.custom_fields }}</td>
        <td>
            <button
                v-if="enrollment.state !== 3"
                :title="$t('enrollment.sign_out')"
                type="button"
                class="btn-link text-danger border-0"
                @click="showModal = true"
            >
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </td>
    </tr>

    <Teleport to="body">
        <CustomModal :show="showModal" @close="showModal = false">
            <template #modal-header>
                <h5>{{ $t('enrollment.enrollments') }}</h5>
            </template>
            <template #modal-body>
                <div class="row">
                    <div class="col-12">
                        <form @submit.prevent="removeItem">
                            <BaseInput
                                v-model="blockReason"
                                :label="$t('enrollment.sign_off_block_reason')"
                                :required="true"
                                class="mb-3"
                                type="text"
                            />
                            <p>
                                <small>{{
                                    $t('enrollment.sign_off_block_hint')
                                }}</small>
                            </p>

                            <SubmitButton />
                        </form>
                    </div>
                </div>
            </template>
        </CustomModal>
    </Teleport>
</template>

<script setup>
import { ref } from 'vue'
import BaseInput from '../../Form/BaseInput.vue'
import SubmitButton from '../../Form/SubmitButton.vue'
import CustomModal from '../../CustomModal.vue'

const emit = defineEmits(['signOut'])
const props = defineProps({
    enrollment: { type: Object, required: true }
})
let showModal = ref(false)
let blockReason = ref(null)

function removeItem() {
    showModal.value = false
    emit(
        'signOut',
        props.enrollment.date_id,
        props.enrollment.enrollment_id,
        blockReason
    )
}
</script>
