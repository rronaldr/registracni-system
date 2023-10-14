<template>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>{{ $t('tag.label') }}</td>
                    <td>{{ $t('tag.value') }}</td>
                    <td>{{ $t('tag.type') }}</td>
                    <td>{{ $t('tag.required') }}</td>
                    <td>{{ $t('tag.default') }}</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <TagItem
                    v-for="tag in tags"
                    :key="tag.id"
                    :tag="tag"
                    @edit-tag="editTag"
                    @remove-tag="removeTag"
                />
            </tbody>
        </table>
    </div>
</template>

<script setup>
import TagItem from './TagItem.vue'

const emit = defineEmits(['editTag', 'removeTag'])
defineProps({
    tags: { type: Array, required: true }
})

function editTag(id) {
    emit('editTag', id)
}

function removeTag(id) {
    emit('removeTag', id)
}
</script>
