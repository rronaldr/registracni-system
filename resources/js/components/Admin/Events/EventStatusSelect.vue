<template>
    <BaseSelect
        v-model="props.status"
        :options="statuses"
        :label="$t('event.status')"
        :required="true"
    />
</template>

<script setup>
import BaseSelect from '../Form/BaseSelect.vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
    status: { type: [String, Number], default: '' }
})

const { t } = useI18n({})

let statuses = [
    { id: 1, name: t('statuses.1') },
    { id: 2, name: t('statuses.2') }
]
</script>
