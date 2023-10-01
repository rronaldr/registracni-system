<template>
    <tr>
        <td>{{ formattedDuration }}</td>
        <td>{{ date.location }}</td>
        <td>{{ date.capacity === -1 ? '∞' : date.capacity }}</td>
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
import {computed, ref} from "vue";

const emit = defineEmits(['editDate', 'removeDate'])
const props = defineProps({
    date: {type: Object, required: true},
})

let durationFrom = ref(moment(`${props.date.date_from} ${props.date.time_from}`, 'YYYY-MM-DD HH:mm'))
let durationTo = ref(moment(`${props.date.date_to} ${props.date.time_to}`, 'YYYY-MM-DD HH:mm'))
const formattedDuration = computed(() => {
  return `${durationFrom.value.format('D.M.YYYY HH:mm')} - ${durationTo.value.format('D.M.YYYY HH:mm')}`;
});

function editItem() {
    emit('editDate', props.date.id)
}

function removeItem() {
    emit('removeDate', props.date.id)
}
</script>
