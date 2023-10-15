<template>
    <div class="container-fluid w-50">
        <div class="form-container bg-white rounded shadow mt-4 py-2 px-4">
            <div class="row p-2">
                <div class="col-12">
                    <h3>Prihlaska na udalost</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing
                        elit. Vivamus ac leo pretium faucibus. Nulla quis diam.
                        Nullam feugiat, turpis at pulvinar vulputate, erat
                        libero tristique tellus, nec bibendum odio risus sit
                        amet ante. Lorem ipsum dolor sit amet, consectetuer
                        adipiscing elit. Duis pulvinar. Sed ac dolor sit amet
                        purus malesuada congue. Class aptent taciti sociosqu ad
                        litora torquent per conubia nostra, per inceptos
                        hymenaeos. Phasellus et lorem id felis nonummy placerat.
                        Pellentesque habitant morbi tristique senectus et netus
                        et malesuada fames ac turpis egestas. Duis bibendum,
                        lectus ut viverra rhoncus, dolor nunc faucibus libero,
                        eget facilisis enim ipsum id lacus.
                    </p>
                </div>
            </div>

            <ErrorMessages :errors="errors" />

            <form @submit.prevent="submitEnrollment">
                <div class="mt-1">
                    <div
                        v-for="field in fields"
                        :key="field.id"
                        class="row p-2"
                    >
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
                            <!--                            <p><input type="checkbox"> Souhlasím s <a class="link-primary" :href="gdprLink">GDPR</a> ....</p>-->
                            <p
                                v-html="
                                    $t('enrollment.gdpr_agree', {
                                        link: gdprLink
                                    })
                                "
                            ></p>
                            <button class="btn btn-primary" type="submit">
                                Odeslat
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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

const props = defineProps({
    dateId: { type: Number, required: true },
    fields: { type: Array, required: true },
    gdprLink: { type: URL, required: false, default: null }
})
const APP_URL = inject('APP_URL')
let form = reactive({})
let errors = ref(null)

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
                window.location.href = APP_URL
            }
        })
        .catch((e) => {
            errors.value = e.response.data.errors
            window.scrollTo(0, 0)
        })
}
</script>
