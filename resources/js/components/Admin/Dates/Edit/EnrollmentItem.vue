<template>
    <tr>
        <td>{{ enrollment.xname }}</td>
        <td>{{ enrollment.email }}</td>
        <td>{{ enrollment.enrolled }}</td>
        <td>{{ $t('enrollment.statuses.' + enrollment.state) }}</td>
        <td>{{ enrollment.custom_fields }}</td>
        <td>
            <button
                :title="$t('enrollment.sign_out')"
                type="button"
                class="btn-link text-danger border-0"
                @click="removeItem()"
            >
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </td>
    </tr>
</template>

<script setup>
const emit = defineEmits(['signOut'])
const props = defineProps({
    enrollment: { type: Object, required: true }
})

function removeItem() {
    emit('signOut', props.enrollment.date_id, props.enrollment.enrollment_id)
}
</script>
