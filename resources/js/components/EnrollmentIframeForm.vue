<template>
    <div class="bg-white rounded shadow px-1 pt-0 pb-2 m-0">
        <div class="row p-2">
            <div class="col-12">
                <a :href="APP_URL + `/external/${props.info.event_id}`">{{ $t('app.back') }}</a>
                <h3>{{ $t('enrollment.form') }}</h3>
                <h5>{{ props.info.event }}</h5>
                <sub>{{
                    `${formatDate(props.info.date_start)} - ${formatDate(
                        props.info.date_end
                    )}`
                }}</sub>
            </div>
        </div>

        <ErrorMessages :errors="errors" />

        <form v-if="showForm" @submit.prevent="submitEnrollment">
            <div class="mt-1">
                <div v-for="field in fields" :key="field.id" class="row p-2">
                    <label
                        v-if="['radio'].includes(field.type)"
                        class="col-1"
                        >{{
                            field.required ? `${field.label}*` : field.label
                        }}</label
                    >
                    <div class="col">
                        <Component
                            :is="BaseInput"
                            v-if="
                                [
                                    'text',
                                    'number',
                                    'email',
                                    'tel',
                                    'date',
                                    'url'
                                ].includes(field.type)
                            "
                            v-model="form[field.value].value"
                            :type="field.type"
                            :label="field.label"
                            :required="field.required"
                            :name="field.value"
                        />
                        <Component
                            :is="BaseTextarea"
                            v-else-if="['textarea'].includes(field.type)"
                            v-model="form[field.value].value"
                            :label="field.label"
                            :required="field.required"
                            :name="field.value"
                        />
                        <Component
                            :is="BaseSelect"
                            v-else-if="['select'].includes(field.type)"
                            v-model="form[field.value].value"
                            :label="field.label"
                            :required="field.required"
                            :name="field.value"
                            :options="getFieldOptions(field)"
                            :placeholder="true"
                            :placeholder-text="
                                $t('enrollment.form_select_placeholder')
                            "
                        />

                        <Component
                            :is="BaseRadioGroup"
                            v-else-if="['radio'].includes(field.type)"
                            v-model="form[field.value].value"
                            :required="field.required"
                            :name="field.value"
                            :options="getFieldOptions(field)"
                        />
                        <Component
                            :is="BaseCheckbox"
                            v-else-if="['checkbox'].includes(field.type)"
                            :id="field.value"
                            v-model="form[field.value].value"
                            :name="field.value"
                            :label="field.label"
                        />
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-12">
                        <p
                            v-html="
                                $t('enrollment.gdpr_agree', {
                                    link: gdprLink
                                })
                            "
                        ></p>
                        <button class="btn btn-primary" type="submit">
                            {{ $t('app.submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div v-else class="bg-light mx-2 my-1 p-1">
            <span class="font-weight-bold">{{ formMessage }}</span>
        </div>
    </div>
</template>

<script setup>
import { inject, reactive, ref } from 'vue'
import axios from 'axios'
import BaseInput from './Admin/Form/BaseInput.vue'
import BaseSelect from './Admin/Form/BaseSelect.vue'
import BaseCheckbox from './Admin/Form/BaseCheckbox.vue'
import BaseRadioGroup from './Admin/Form/BaseRadioGroup.vue'
import BaseTextarea from './Admin/Form/BaseTextarea.vue'
import ErrorMessages from './ErrorMessages.vue'
import { formatDate } from '../utils/DateFormat'
import { useI18n } from 'vue-i18n'

const { t } = useI18n({})
const props = defineProps({
    dateId: { type: Number, required: true },
    fields: { type: Array, required: true },
    info: { type: Object, required: true },
    canEnroll: { type: Number, required: true },
    gdprLink: { type: URL, required: false, default: null }
})
let enroll = Boolean(props.canEnroll)

const APP_URL = inject('APP_URL')
let form = reactive({})
let errors = ref(null)
let showForm = ref(enroll)
let formMessage = !enroll
    ? ref(t('enrollment.cannot_enroll'))
    : ref(t('enrollment.enroll_success'))

createFormBinding()
function createFormBinding() {
    props.fields.map(function (field) {
        form[field.value] = {
            name: field.value,
            value: field.default != null ? field.default : null,
            label: field.label
        }

        if (field.type === 'checkbox') {
            form[field.value].value = false
        }
    })
}

function getFieldOptions(field) {
    let options = field.options.split(',')
    let optionsArray = []
    let i = 0
    options.map(function (value) {
        if (['radio'].includes(field.type)) {
            optionsArray.push({ label: value, value: ++i })
        }
        if (['select'].includes(field.type)) {
            optionsArray.push({ name: value, id: ++i })
        }
    })
    return optionsArray
}

async function submitEnrollment() {
    axios
        .post(APP_URL + '/enrollment/' + props.dateId, {
            data: form
        })
        .then((response) => {
            if (response.status === 204) {
                showForm.value = false
                formMessage.value = t('enrollment.enroll_success')
            }
        })
        .catch((e) => {
            errors.value = e.response.data.errors
            window.scrollTo(0, 0)
        })
}
</script>
