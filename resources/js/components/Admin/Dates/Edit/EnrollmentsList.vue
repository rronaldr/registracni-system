<template>
    <div class="table-responsive overflow-scroll">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>{{ $t('enrollment.xname') }}</td>
                    <td>{{ $t('enrollment.email') }}</td>
                    <td>{{ $t('enrollment.enrolled') }}</td>
                    <td>{{ $t('user.name') }}</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <EnrollmentItem
                    v-for="enrollment in enrollments"
                    :key="enrollment.id"
                    :enrollment="enrollment"
                    @sign-out="signOut"
                />
            </tbody>
        </table>
    </div>
</template>

<script setup>
import EnrollmentItem from './EnrollmentItem.vue'

const emit = defineEmits(['signOut'])
defineProps({
    enrollments: { type: [Array, null], required: true }
})

function signOut(dateId, enrollmentId, blockReason) {
    emit('signOut', dateId, enrollmentId, blockReason)
}
</script>
