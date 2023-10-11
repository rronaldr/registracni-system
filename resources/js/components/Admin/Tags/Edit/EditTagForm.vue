<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <span>
                                {{ $t('tag.tag') }} <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" :title="$t('tag.tag_box_hint')"></i>
                            </span>
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
                    <EditTagList
                        v-if="tags.length > 0"
                        :tags="tags"
                        @edit-tag="setEditForm"
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
                        @click="closeForm()"></button>
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
                            <span v-html="$t('tag.value_hint')"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"
                             v-if="showRequired"
                        >
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
                        <div class="col"
                             v-if="showOptions"
                        >
                            <BaseTextarea
                                v-model="tag.options"
                                :label="$t('tag.options')"
                                :required="true"
                            />
                            <span v-html="$t('tag.options_tip')"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"
                            v-if="showDefault"
                        >
                            <BaseInput
                                v-model="tag.default"
                                :label="$t('tag.default')"
                                :type="tag.type"
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
import {inject, reactive, ref, watch} from "vue";
import SubmitButton from "../../Form/SubmitButton.vue";
import BaseInput from "../../Form/BaseInput.vue";
import BaseCheckbox from "../../Form/BaseCheckbox.vue";
import BaseTextarea from "../../Form/BaseTextarea.vue";
import {useI18n} from "vue-i18n";
import BaseSelect from "../../Form/BaseSelect.vue";
import EditTagList from "./EditTagList.vue";
import axios from "axios";
import {mapLastDateObject} from "../../../../utils/DataMapper";

const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    eventId: {type: Number, required: true},
    tags: {type: Array, required: false}
})
const emit = defineEmits(['getTags'])
const {t} = useI18n({})

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
    {name: t('tag.text'), id: 'text'},
    {name: t('tag.number'), id: 'number'},
    {name: t('tag.checkbox'), id: 'checkbox'},
    {name: t('tag.radio'), id: 'radio'},
    {name: t('tag.select'), id: 'select'},
    {name: t('tag.email'), id: 'email'},
    {name: t('tag.tel'), id: 'tel'},
    {name: t('tag.date'), id: 'date'},
    {name: t('tag.url'), id: 'url'},
    {name: t('tag.textarea'), id: 'textarea'},
]

async function addDate() {
    if (props.tags.length === 0) {
        tag.id = 1
    }

    edit ? await editTag() : await createTag()

    showTagForm.value = false
    emit('getTags')
    clearTagObject()
}

async function createTag() {
    setTagId()

    await axios.post(ADMIN_URL+'/events/'+props.eventId+'/tags/create', {
        tag: tag
    })
}
async function editTag() {
    await axios.put(ADMIN_URL+'/events/'+props.eventId+'/tags/'+tag.id+'/update', {
        tag: tag
    })

    edit = false
}

async function removeTag(id) {
    await axios.delete(ADMIN_URL+'/events/'+props.eventId+'/tags/'+id+'/delete')
    emit('getTags')
}

function setEditForm(id) {
    clearTagObject()
    showTagForm.value = true
    edit = true

    tag = Object.assign(tag, {...props.tags.find(tag => tag.id === id)})
}

function closeForm() {
    showTagForm.value = false
    clearTagObject()
}

function clearTagObject() {
    Object.keys(tag).forEach((i) => tag[i] = i === 'required' ? tag[i] = false : tag[i] = null)
}

function setTagId() {
    if (props.tags.length > 0) {
        let lastTag = props.tags[props.tags.length - 1]
        tag.id = lastTag.id + 1
    }
}

watch(
    () => tag.type,
    (type, prevType) => {
        showOptions = tag.type !== null && (
            tag.type === 'select'
            || tag.type === 'radio'
        )
        showDefault = tag.type !== null && (
            tag.type !== 'checkbox'
            && tag.type !== 'radio'
            && tag.type !== 'select'
        )
        showRequired = tag.type !== null
            && tag.type !== 'checkbox'
    }
)

</script>
