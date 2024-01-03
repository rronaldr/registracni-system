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
        </td>
    </tr>
</template>

<script setup>
import moment from 'moment'
import { computed, inject, ref } from 'vue'

const APP_URL = inject('APP_URL')
const emit = defineEmits(['showEnrollments', 'editDate', 'removeDate'])
const props = defineProps({
    date: { type: Object, required: true }
})
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
</script>
