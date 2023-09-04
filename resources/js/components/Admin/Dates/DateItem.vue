<template>
    <tr>
        <td>{{ date.date_from}}</td>
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
const emit = defineEmits(['editDate', 'removeDate'])
const props = defineProps({
    date: {type: Object, required: true},
})

function editItem() {
    emit('editDate', props.date.id)
}

function removeItem() {
    emit('removeDate', props.date.id)
}
</script>
