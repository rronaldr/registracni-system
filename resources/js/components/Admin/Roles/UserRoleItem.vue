<template>
    <tr>
        <td>{{ role.name }}</td>
        <td>
            <button
                @click="revokeRole"
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
const emit = defineEmits(['revokeRole'])
const props = defineProps({
    role: {type: Object, required: true},
})


function revokeRole() {
    emit('revokeRole', props.role.id)
}
</script>
