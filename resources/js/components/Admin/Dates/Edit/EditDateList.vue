<template>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>{{ $t('date.duration') }}</td>
                    <td>{{ $t('date.location') }}</td>
                    <td>{{ $t('date.capacity') }}</td>
                    <td>{{ $t('date.unlimited_capacity') }}</td>
                    <td>{{ $t('date.substitute') }}</td>
                    <td>{{ $t('date.participants_count') }}</td>
                    <td class="w-10"></td>
                </tr>
            </thead>
            <tbody>
                <EditDateItem
                    v-for="date in dates"
                    :key="date.id"
                    :date="date"
                    @edit-date="editDate"
                    @remove-date="removeDate"
                    @show-enrollments="getEnrollmentsForDate"
                />
            </tbody>
        </table>
    </div>

    <Teleport to="body">
        <CustomModal :show="showModal" @close="showModal = false">
            <template #modal-header>
                <h5>{{ $t('enrollment.enrollments') }}</h5>
            </template>
            <template #modal-body>
                <EnrollmentsList
                    :enrollments="enrollments"
                    @sign-out="signOut"
                />
            </template>
        </CustomModal>
    </Teleport>
</template>

<script setup>
import { inject, ref } from 'vue'
import EditDateItem from './EditDateItem.vue'
import CustomModal from '../../CustomModal.vue'
import axios from 'axios'
import { formatEnrollments } from '../../../../utils/DataMapper'
import EnrollmentsList from './EnrollmentsList.vue'

const ADMIN_URL = inject('ADMIN_URL')
const emit = defineEmits(['editDate', 'removeDate'])
defineProps({
    dates: { type: Array, required: true }
})
let showModal = ref(false)
let enrollments = ref(null)

function editDate(id) {
    emit('editDate', id)
}

function removeDate(id) {
    emit('removeDate', id)
}

function signOut(dateId, enrollmentId) {
    axios.post(ADMIN_URL + '/dates/enrollments/' + enrollmentId + '/signoff')
    getEnrollmentsForDate(dateId)
}

async function getEnrollmentsForDate(id) {
    showModal.value = true
    let response = await axios.get(ADMIN_URL + '/dates/' + id + '/enrollments')
    enrollments.value = formatEnrollments(response.data)
}
</script>
