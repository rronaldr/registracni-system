<template>
    <div class="table-responsive overflow-scroll">
        <input
            type="text"
            class="mb-1"
            :placeholder="$t('enrollment.search_user')"
            @keyup="search($event.target.value)"
        />
        <table class="table table-striped border-1">
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
                <DetailEnrollmentItem
                    v-for="enrollment in enrollments"
                    v-if="enrollments != null && enrollments.length > 0"
                    :key="enrollment.id"
                    :enrollment="enrollment"
                />
                <p v-else>No enrollments</p>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import DetailEnrollmentItem from './DetailEnrollmentItem.vue'

const emit = defineEmits(['signOut', 'search'])
let props = defineProps({
    enrollments: { type: [Array, null], required: true },
    dateId: { type: Number, required: true }
})

function search(query) {
    setTimeout(() => {
        emit('search', props.dateId, query)
    }, 1000)
}

function signOut(dateId, enrollmentId, blockReason) {
    emit('signOut', dateId, enrollmentId, blockReason)
}
</script>
