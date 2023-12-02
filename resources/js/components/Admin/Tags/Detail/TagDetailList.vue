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
                </tr>
            </thead>
            <tbody>
                <TagDetailItem v-for="tag in tags" :key="tag.id" :tag="tag" />
            </tbody>
        </table>
    </div>
</template>

<script setup>
import TagDetailItem from './TagDetailItem.vue'

defineProps({
    tags: { type: Array, required: false, default: null }
})
</script>
