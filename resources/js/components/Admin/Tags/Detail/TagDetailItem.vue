<template>
    <tr>
        <td>{{ tag.label }}</td>
        <td>{{ `[${tag.value}]` }}</td>
        <td>{{ $t(`tag.${tag.type}`) }}</td>
        <td>{{ tag.required ? 'Ano' : 'Ne' }}</td>
        <td>{{ tag.default ?? $t('tag.default_not_set') }}</td>
    </tr>
</template>

<script setup>
defineProps({
    tag: { type: Object, required: true }
})
</script>
