<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <span>
                                {{ $t('tag.tag') }}
                                <i
                                    class="fas fa-info-circle"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    :title="$t('tag.tag_box_hint')"
                                ></i>
                            </span>
                        </div>
                        <div class="col">
                            <button
                                class="btn btn-sm btn-primary float-right"
                                type="button"
                                @click="showTagForm = true"
                            >
                                <i class="fas fa-plus"></i>
                                {{ $t('tag.add_tag') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <TagList
                        v-if="tags.length > 0"
                        :tags="tags"
                        @edit-tag="editTag"
                        @remove-tag="removeTag"
                    />
                    <p v-else class="card-text">{{ $t('tag.empty') }}</p>
                </div>
            </div>

            <form
                v-if="showTagForm"
                class="bg-lighter-grey border p-2"
                @submit.prevent="addDate"
            >
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">{{ $t('tag.add_tag') }}</h5>
                    <button type="button" class="close" @click="closeForm()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="text-start">
                    <div class="row mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="tag.label"
                                :label="$t('tag.label')"
                                type="text"
                                :required="true"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="tag.value"
                                :label="$t('tag.value')"
                                type="text"
                                :required="true"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div v-if="showRequired" class="col">
                            <BaseCheckbox
                                id="required"
                                v-model="tag.required"
                                :label="$t('tag.required')"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseSelect
                                v-model="tag.type"
                                :label="$t('tag.type')"
                                :options="typeOptions"
                                :required="true"
                                :placeholder="true"
                                :placeholder-text="$t('tag.type_select')"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div v-if="showOptions" class="col">
                            <BaseTextarea
                                v-model="tag.options"
                                :label="$t('tag.options')"
                                :required="true"
                            />
                            <span v-html="$t('tag.options_tip')"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div v-if="showDefault" class="col">
                            <BaseInput
                                v-model="tag.default"
                                :label="$t('tag.default')"
                                :type="tag.type"
                            />
                        </div>
                    </div>

                    <SubmitButton />
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import SubmitButton from '../Form/SubmitButton.vue'
import BaseInput from '../Form/BaseInput.vue'
import BaseCheckbox from '../Form/BaseCheckbox.vue'
import BaseTextarea from '../Form/BaseTextarea.vue'
import { useI18n } from 'vue-i18n'
import BaseSelect from '../Form/BaseSelect.vue'
import TagList from './TagList.vue'

const props = defineProps({
    tags: { type: Array, required: false, default: null }
})
const { t } = useI18n({})

let showTagForm = ref(false)
let showOptions = ref(false)
let showDefault = ref(false)
let showRequired = ref(false)
let edit = false
let tag = reactive({
    id: null,
    label: null,
    value: null,
    required: false,
    type: null,
    options: null,
    default: null
})

let typeOptions = [
    { name: t('tag.text'), id: 'text' },
    { name: t('tag.number'), id: 'number' },
    { name: t('tag.checkbox'), id: 'checkbox' },
    { name: t('tag.radio'), id: 'radio' },
    { name: t('tag.select'), id: 'select' },
    { name: t('tag.email'), id: 'email' },
    { name: t('tag.tel'), id: 'tel' },
    { name: t('tag.date'), id: 'date' },
    { name: t('tag.url'), id: 'url' },
    { name: t('tag.textarea'), id: 'textarea' }
]

function addDate() {
    if (props.tags.length === 0) {
        tag.id = 1
    }

    if (edit) {
        removeTag(tag.id)
        edit = false
    }

    props.tags.push({ ...tag })
    showTagForm.value = false

    clearTagObject()
}

function editTag(id) {
    clearTagObject()
    showTagForm.value = true
    edit = true

    let tagToEdit = props.tags.find((date) => date.id === id)
    assignEditValue(tagToEdit)
}

function removeTag(id) {
    const index = props.tags.findIndex((date) => date.id === id)
    if (index !== -1) {
        props.tags.splice(index, 1)
    }
}

function closeForm() {
    showTagForm.value = false
    clearTagObject()
}

function clearTagObject() {
    Object.keys(tag).forEach((i) => (tag[i] = null))
}

function assignEditValue(tagToEdit) {
    tag.id = tagToEdit.id
    tag.label = tagToEdit.label
    tag.value = tagToEdit.value
    tag.required = tagToEdit.required
    tag.type = tagToEdit.type
    tag.options = tagToEdit.options
    tag.default = tagToEdit.default
}

watch(
    () => tag.type,
    () => {
        showOptions.value =
            tag.type !== null && (tag.type === 'select' || tag.type === 'radio')
        showDefault.value =
            tag.type !== null &&
            tag.type !== 'checkbox' &&
            tag.type !== 'radio' &&
            tag.type !== 'select'
        showRequired.value = tag.type !== null && tag.type !== 'checkbox'
    }
)
</script>
