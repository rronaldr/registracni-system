<template>
    <tr>
        <td>{{ dateDuration }}</td>
        <td>{{ date.location }}</td>
        <td>{{ date.unlimited_capacity ? '∞' : date.capacity }}</td>
        <td>{{ date.unlimited_capacity ? 'Ano' : 'Ne' }}</td>
        <td>{{ date.substitute ? 'Ano' : 'Ne' }}</td>
        <td>
            <button
                :title="$t('app.edit')"
                type="button"
                class="btn-link text-info border-0 mx-1"
                @click="editItem"
            >
                <i class="fas fa-edit"></i>
            </button>
            <button
                :title="$t('app.delete')"
                type="button"
                class="btn-link text-danger border-0"
                @click="removeItem"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script setup>
import moment from 'moment'

const emit = defineEmits(['editDate', 'removeDate'])
const props = defineProps({
    date: { type: Object, required: true }
})

let durationFrom = moment(
    `${props.date.date_from} ${props.date.time_from}`,
    'YYYY-MM-DD HH:mm'
).format('D.M.YYYY HH:mm')
let durationTo = moment(
    `${props.date.date_to} ${props.date.time_to}`,
    'YYYY-MM-DD HH:mm'
).format('D.M.YYYY HH:mm')
let dateDuration = `${durationFrom} - ${durationTo}`

function editItem() {
    emit('editDate', props.date.id)
}

function removeItem() {
    emit('removeDate', props.date.id)
}
</script>
