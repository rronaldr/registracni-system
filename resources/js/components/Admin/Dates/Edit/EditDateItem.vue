<template>
    <tr>
        <td>{{ formattedDuration }}</td>
        <td>{{ date.location }}</td>
        <td>{{ date.capacity === -1 ? '∞' : date.capacity }}</td>
        <td>{{ date.unlimited_capacity ? 'Ano' : 'Ne' }}</td>
        <td>{{ date.substitute ? 'Ano' : 'Ne' }}</td>
        <td>
            {{
                date.enrollments_count > 0
                    ? date.enrollments_count
                    : $t('date.no_participants')
            }}
        </td>
        <td>
            <button
                v-if="date.enrollments_count > 0"
                :title="$t('date.show_participants')"
                type="button"
                class="btn-link text-primary border-0 mr-1"
                @click="showEnrollments"
            >
                <i class="fas fa-users"></i>
            </button>
            <button
                :title="$t('app.edit')"
                type="button"
                class="btn-link text-info border-0 mr-1"
                @click="editItem"
            >
                <i class="fas fa-edit"></i>
            </button>
            <button
                :title="$t('app.delete')"
                type="button"
                class="btn-link text-danger border-0"
                @click="date.enrollments_count > 0 ? showModal = true : removeItem(null)"
            >
                <i class="fas fa-trash"></i>
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
                        <form @submit.prevent="removeItem(blockReason.value)">
                            <BaseInput
                                v-model="blockReason"
                                :label="$t('enrollment.sign_off_block_reason')"
                                :required="true"
                                class="mb-3"
                                type="text"
                            />
                            <p>
                                <small>{{
                                    $t('enrollment.sign_off_all_block_hint')
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
import moment from 'moment'
import { computed, ref } from 'vue'
import SubmitButton from '../../Form/SubmitButton.vue'
import CustomModal from '../../CustomModal.vue'
import BaseInput from '../../Form/BaseInput.vue'

const emit = defineEmits(['showEnrollments', 'editDate', 'removeDate'])
const props = defineProps({
    date: { type: Object, required: true }
})
let showModal = ref(false)
let blockReason = ref(null)
let durationFrom = ref(
    moment(
        `${props.date.date_from} ${props.date.time_from}`,
        'YYYY-MM-DD HH:mm'
    )
)
let durationTo = ref(
    moment(`${props.date.date_to} ${props.date.time_to}`, 'YYYY-MM-DD HH:mm')
)
const formattedDuration = computed(() => {
    return `${durationFrom.value.format(
        'D.M.YYYY HH:mm'
    )} - ${durationTo.value.format('D.M.YYYY HH:mm')}`
})

function showEnrollments() {
    emit('showEnrollments', props.date.id)
}
function editItem() {
    emit('editDate', props.date.id)
}

function removeItem(blockReason) {
    emit('removeDate', props.date.id, blockReason)
}
</script>
