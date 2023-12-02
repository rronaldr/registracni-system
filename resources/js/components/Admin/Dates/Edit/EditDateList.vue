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
                    :date-id="dateId"
                    @sign-out="signOut"
                    @search="getEnrollmentsForDate"
                />
            </template>
            <template v-if="enrollments != null && enrollments.length > 0" #modal-footer>
                <a
                    type="button"
                    class="btn btn-outline-secondary btn-sm mr-1"
                    :href="
                        ADMIN_URL +
                        '/dates/' +
                        enrollments[0].date_id +
                        '/users/export'
                    "
                    ><i class="fas fa-users"></i>
                    {{ $t('event.export_users') }}</a
                >
                <a
                    type="button"
                    class="btn btn-outline-secondary btn-sm mr-1"
                    :href="
                        ADMIN_URL +
                        '/dates/' +
                        enrollments[0].date_id +
                        '/users/export-email'
                    "
                    ><i class="fas fa-envelope"></i>
                    {{ $t('event.export_emails') }}</a
                >
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
let dateId = ref(null)

function editDate(id) {
    emit('editDate', id)
}

function removeDate(id, blockReason) {
    emit('removeDate', id, blockReason)
}

function signOut(dateId, enrollmentId, blockReason) {
    axios.post(ADMIN_URL + '/dates/enrollments/' + enrollmentId + '/signoff', {
        data: blockReason.value
    })
    getEnrollmentsForDate(dateId)
}

async function getEnrollmentsForDate(id, search = null) {
    showModal.value = true
    let response = await axios.get(
        `${ADMIN_URL}/dates/${id}/enrollments${search ? `/${search}` : '/'}`
    )
    enrollments.value = formatEnrollments(response.data.enrollments)
    dateId.value = response.data.date_id

}
</script>
