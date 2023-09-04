<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5>
                                Vlastní pole <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Zde vytvořte vlastní pole"></i>
                            </h5>
                        </div>
                        <div class="col">
                            <button
                                @click="showTagForm = true"
                                class="btn btn-sm btn-primary float-end"
                                type="button"
                            >
                                <i class="fas fa-plus"></i> {{ $t('tag.add_tag') }}
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
                    <p v-else class="card-text">{{ $t('tag.empty' )}}</p>
                </div>
            </div>

            <form
                class="bg-lighter-grey border rounded p-2"
                v-if="showTagForm"
                @submit.prevent="addDate"
            >
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">{{ $t('tag.add_tag') }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="showTagForm = false"></button>
                </div>
                <div class="text-start">
                    <div class="row mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="tag.label"
                                :label="$t('tag.label')"
                                type="text"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="tag.value"
                                :label="$t('tag.value')"
                                type="text"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <BaseCheckbox
                                id="required"
                                :label="$t('tag.required')"
                                v-model="tag.required"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseSelect
                                :label="$t('tag.type')"
                                :options="typeOptions"
                                v-model="tag.type"
                                :required="true"
                                :placeholder="true"
                                :placeholder-text="$t('tag.type_select')"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseTextarea
                                v-model="tag.options"
                                :label="$t('tag.options')"
                                required="required"
                            />
                            <small class="form-text">Jednotlivé hodnoty oddělte pomocí znaku <code>,</code></small><br>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="tag.default"
                                :label="$t('tag.default')"
                                type="text"
                            />
                        </div>
                    </div>

                    <SubmitButton/>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import {reactive, ref} from "vue";
import SubmitButton from "../Form/SubmitButton.vue";
import BaseInput from "../Form/BaseInput.vue";
import BaseCheckbox from "../Form/BaseCheckbox.vue";
import BaseTextarea from "../Form/BaseTextarea.vue";
import {useI18n} from "vue-i18n";
import BaseSelect from "../Form/BaseSelect.vue";
import TagList from "./TagList.vue";

const props = defineProps({
    tags: {type: Array, required: false}
})
const {t} = useI18n({})

let showTagForm = ref(false)
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
    {name: t('tag.text'), id: 'text'},
    {name: t('tag.number'), id: 'number'},
    {name: t('tag.checkbox'), id: 'checkbox'},
    {name: t('tag.select'), id: 'select'},
    {name: t('tag.email'), id: 'email'},
    {name: t('tag.tel'), id: 'tel'},
    {name: t('tag.date'), id: 'date'},
    {name: t('tag.url'), id: 'url'},
    {name: t('tag.textarea'), id: 'textarea'},
]

function addDate() {
    if (props.tags.length === 0) {
        tag.id = 1
    }

    if (edit) {
        edit = false
        removeTag(tag.id)
    }

    props.tags.push({...tag})
    showTagForm.value = false

    clearDateObject()
}

function editTag(id) {
    showTagForm.value = true
    edit = true
    tag = {...props.tags.find(date => date.id === id)}
}

function removeTag(id) {
    const index = props.tags.findIndex(date => date.id === id)
    if (index !== -1) {
        props.tags.splice(index, 1)
    }
}

function clearDateObject() {
    Object.keys(tag).forEach((i) => tag[i] = null)
}

</script>
