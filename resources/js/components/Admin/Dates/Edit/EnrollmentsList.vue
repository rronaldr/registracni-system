<template>
    <div class="table-responsive">
        <table class="table table table-striped">
            <thead>
            <tr>
                <td>{{ $t('enrollment.xname') }}</td>
                <td>{{ $t('enrollment.email') }}</td>
                <td>{{ $t('enrollment.enrolled') }}</td>
                <td>{{ $t('enrollment.state') }}</td>
                <td>{{ $t('enrollment.c_fields') }}</td>
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
import {inject, ref} from "vue";
import EnrollmentItem from "./EnrollmentItem.vue";

const ADMIN_URL = inject('ADMIN_URL')
const emit = defineEmits(['signOut'])
const props = defineProps({
    enrollments: {required: true}
})

function signOut(dateId, enrollmentId) {
    emit('signOut', dateId, enrollmentId)
}
</script>
