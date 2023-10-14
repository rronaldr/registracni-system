<template>
    <div class="table-responsive">
        <table class="table table table-striped">
            <thead>
                <tr>
                    <td>{{ $t('date.duration') }}</td>
                    <td>{{ $t('date.location') }}</td>
                    <td>{{ $t('date.capacity') }}</td>
                    <td>{{ $t('date.unlimited_capacity') }}</td>
                    <td>{{ $t('date.substitute') }}</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <DateItem
                    v-for="date in dates"
                    :key="date.id"
                    :date="date"
                    @edit-date="editDate"
                    @remove-date="removeDate"
                />
            </tbody>
        </table>
    </div>
</template>

<script setup>
import DateItem from './DateItem.vue'

const emit = defineEmits(['editDate', 'removeDate'])
defineProps({
    dates: { type: Array, required: true }
})

function editDate(id) {
    emit('editDate', id)
}

function removeDate(id) {
    emit('removeDate', id)
}
</script>
