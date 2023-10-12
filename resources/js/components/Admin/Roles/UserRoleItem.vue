<template>
    <tr>
        <td>{{ role.name }}</td>
        <td>
            <button
                @click="revokeRole"
                :title="$t('app.delete')"
                type="button"
                class="btn-link border-0 text-danger px-1"
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
