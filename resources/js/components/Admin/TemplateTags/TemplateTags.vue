<template>
    <div class="row mb-3">
        <div class="col">
            <p>{{ $t('event.tag_buttons') }}</p>

            <TemplateTagButton
                v-for="button in buttons"
                :label="button.label"
                :value="button.value"
                @set-content="setContent"
            />
            <TemplateTagButton
                v-for="tag in tags"
                :label="tag.label"
                :value="tag.value"
                @set-content="setContent"
            />
        </div>
    </div>
</template>

<script setup>
import TemplateTagButton from './TemplateTagButton.vue'
import { useI18n } from 'vue-i18n'

defineProps({
    tags: { type: Array, required: false, default: null }
})
const { t } = useI18n({})

let buttons = [
    { label: t('tag.user_fname'), value: 'user.first_name' },
    { label: t('tag.user_lname'), value: 'user.last_name' },
    { label: t('tag.user_xname'), value: 'user.xname' },
    { label: t('tag.user_email'), value: 'user.email' },
    { label: t('tag.event_title'), value: 'event.title' },
    { label: t('tag.date_start'), value: 'date.date_start' },
    { label: t('tag.date_end'), value: 'date.date_end' },
    { label: t('tag.enrollment_created'), value: 'enrollment.created_at' }
]

function setContent(text) {
    tinymce.activeEditor.execCommand('mceInsertContent', false, text)
}
</script>
