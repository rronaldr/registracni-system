<template>
    <div class="container-fluid w-50">
        <div class="form-container bg-white rounded shadow mt-4 py-2 px-4">
            <div class="row p-2">
                <div class="col-12">
                    <h3>Prihlaska na udalost</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus ac leo pretium faucibus. Nulla quis diam. Nullam feugiat, turpis at pulvinar vulputate, erat libero tristique tellus, nec bibendum odio risus sit amet ante. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis pulvinar. Sed ac dolor sit amet purus malesuada congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Phasellus et lorem id felis nonummy placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus.
                    </p>
                </div>
            </div>

            <form @submit.prevent="submitEnrollment">
                <div class="mt-2">
                    <div
                        v-for="field in fields"
                        :key="field.id"
                        class="row p-2"
                    >
                        <div class="col">
                            <Component
                                v-if="['text', 'number', 'email', 'tel', 'date', 'url'].includes(field.type)"
                                :is="BaseInput"
                                v-model="form[field.value]"
                                :type="field.type"
                                :label="field.label"
                                :required="field.required"
                                :name="field.value"
                            />
                            <Component
                                v-else-if="['textarea'].includes(field.type)"
                                :is="BaseTextarea"
                                v-model="form[field.value]"
                                :label="field.label"
                                :required="field.required"
                                :name="field.value"
                            />
                            <Component
                                v-else-if="['select'].includes(field.type)"
                                :is="BaseSelect"
                                v-model="form[field.value]"
                                :label="field.label"
                                :required="field.required"
                                :name="field.value"
                                :options="getFieldOptions(field)"
                                :placeholder="true"
                                :placeholder-text="$t('enrollment.form_select_placeholder')"
                            />
                            <Component
                                v-else-if="['radio'].includes(field.type)"
                                :is="BaseRadioGroup"
                                v-model="form[field.value]"
                                :required="field.required"
                                :name="field.value"
                                :options="getFieldOptions(field)"
                            />
                            <Component
                                v-else-if="['checkbox'].includes(field.type)"
                                :is="BaseCheckbox"
                                v-model="form[field.value]"
                                :id="field.value"
                                :required="field.required"
                                :name="field.value"
                                :label="field.label"
                            />
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12">
                            <p><input type="checkbox"> Souhlasím s <a class="link-primary" href="#">GDPR</a> ....</p>
                            <button class="btn btn-primary" type="submit">Odeslat</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import {inject, reactive} from "vue";
import axios from "axios";
import BaseInput from "./Admin/Form/BaseInput.vue";
import BaseSelect from "./Admin/Form/BaseSelect.vue";
import BaseCheckbox from "./Admin/Form/BaseCheckbox.vue";
import BaseRadioGroup from "./Admin/Form/BaseRadioGroup.vue";
import BaseTextarea from "./Admin/Form/BaseTextarea.vue";

const props = defineProps({
    dateId: {type: Number, required: true},
    fields: {type: Array, required: true},
})
const APP_URL = inject('APP_URL')
let form = reactive({})

createFormBinding()
function createFormBinding() {
  props.fields.map(function(field) {
    form[field.value] = field.default != null
        ? field.default
        : null
  })
}

function getFieldOptions(field) {
    let options = field.options.split(',')
    let optionsArray = []
    let i = 0
    options.map(function(value) {
        if (['radio'].includes(field.type)) {
            optionsArray.push({label: value, value: ++i})
        }
        if (['select'].includes(field.type)) {
            optionsArray.push({name: value, id: ++i})
        }
    })
    return optionsArray
}

function submitEnrollment(event) {
    console.log(event)
    // axios.post(APP_URL +'/enrollment/' + 1,
    //     {
    //         enrollment: {name: "Ronald", gender: "Muž"}
    //     }
    // )
}
</script>
