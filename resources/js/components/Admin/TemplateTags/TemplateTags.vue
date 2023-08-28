<template>
    <div class="row mb-3">
        <div class="col">
            <p>{{  $t('event.template_tag_buttons') }}</p>

            <TemplateTagButton
                v-for="button in buttons"
                :label="button.label"
                :value="button.value"
                @set-content="setContent"
            />
        </div>
    </div>
</template>

<script setup>
import TemplateTagButton from "./TemplateTagButton.vue";

const props = defineProps({
    tags: {type: Array, required: false}
})

let buttons = [
    {label: 'Jméno', value: '[user.first_name]'},
    {label: 'Přijmeni', value: '[user.last_name]'},
    {label: 'Xname', value: '[user.xname]'},
    {label: 'Email', value: '[user.email]'},
    {label: 'Název události', value: '[event.title]'},
    {label: 'Datum termínu', value: '[date.date_start]'},
    {label: 'Datum registrace', value: '[enrollment.created_at]'},
]

function setContent(text) {
    tinymce.activeEditor.execCommand('mceInsertContent', false, text);
}
</script>
