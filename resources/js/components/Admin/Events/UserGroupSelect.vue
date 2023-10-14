<template>
    <BaseSelect
        v-model="props.userGroup"
        :options="user_groups"
        :label="$t('event.user_group')"
        :required="true"
        :placeholder="true"
        :placeholder-text="$t('event.user_group_placeholder')"
    />
</template>

<script setup>
import BaseSelect from '../Form/BaseSelect.vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
    userGroup: { type: [String, Number], default: '' }
})

const { t } = useI18n({})

let user_groups = [
    { id: 1, name: t('user_group.1') },
    { id: 2, name: t('user_group.2') },
    { id: 3, name: t('user_group.3') },
    { id: 4, name: t('user_group.4') },
    { id: 5, name: t('user_group.5') }
]
</script>
