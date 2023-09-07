<template>
    <tr>
        <td>{{ dateDuration }}</td>
        <td>{{ date.room }}</td>
        <td>{{ date.capacity }}</td>
        <td>{{ date.unlimited_capacity ? 'Ano' : 'Ne' }}</td>
        <td>{{ date.substitute ? 'Ano' : 'Ne' }}</td>
        <td>
            <button
                @click="editItem"
                :title="$t('app.edit')"
                type="button"
                class="btn btn-outline-info btn-rounded mx-1"
            >
                <i class="fas fa-edit"></i>
            </button>
            <button
                @click="removeItem"
                :title="$t('app.delete')"
                type="button"
                class="btn btn-outline-danger btn-rounded"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script setup>
import moment from "moment";

const emit = defineEmits(['editDate', 'removeDate'])
const props = defineProps({
    date: {type: Object, required: true},
})

let durationFrom = moment(`${props.date.date_from} ${props.date.time_from}`).format('D.M.YYYY HH:mm')
let durationTo = moment(`${props.date.date_to} ${props.date.time_to}`).format('D.M.YYYY HH:mm')
let dateDuration = `${durationFrom} - ${durationTo}`

function editItem() {
    emit('editDate', props.date.id)
}

function removeItem() {
    emit('removeDate', props.date.id)
}
</script>
