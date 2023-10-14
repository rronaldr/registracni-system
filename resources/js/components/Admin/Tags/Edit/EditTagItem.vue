<template>
    <tr>
        <td>{{ tag.label }}</td>
        <td>{{ `[${tag.value}]` }}</td>
        <td>{{ $t(`tag.${tag.type}`) }}</td>
        <td>{{ tag.required ? 'Ano' : 'Ne' }}</td>
        <td>{{ tag.default ?? $t('tag.default_not_set') }}</td>
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
const emit = defineEmits(['editTag', 'removeTag'])
const props = defineProps({
    tag: { type: Object, required: true }
})

function editItem() {
    emit('editTag', props.tag.id)
}

function removeItem() {
    emit('removeTag', props.tag.id)
}
</script>
