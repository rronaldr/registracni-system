<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5>
                                {{ $t('date.dates') }}
                                <i
                                    class="fas fa-info-circle"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    :title="$t('date.date_box_hint')"
                                ></i>
                            </h5>
                        </div>
                        <div class="col">
                            <button
                                v-if="showAddDate"
                                class="btn btn-sm btn-primary float-right"
                                type="button"
                                @click="showDateForm = true"
                            >
                                <i class="fas fa-plus"></i>
                                {{ $t('date.add_date') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <EditDateList
                        v-if="dates.length > 0"
                        :dates="dates"
                        @edit-date="setEditForm"
                        @remove-date="removeDate"
                    />
                    <p v-else class="card-text">{{ $t('date.empty') }}</p>

                    <Bootstrap4Pagination
                        :data="datesResponse"
                        @pagination-change-page="getEventDates"
                    />
                </div>
            </div>

            <form
                v-if="showDateForm"
                class="bg-lighter-grey border p-2"
                @submit.prevent="addDate"
            >
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">{{ $t('date.add_date') }}</h5>
                    <button type="button" class="close" @click="closeForm()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="text-start">
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="date.name"
                                :label="$t('date.name')"
                                type="text"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <BaseInput
                                v-if="!date.online"
                                v-model="date.location"
                                :label="$t('date.location')"
                                type="text"
                                :required="true"
                            />
                        </div>
                        <div class="col-6">
                            <BaseInput
                                v-if="!date.unlimited_capacity"
                                v-model="date.capacity"
                                :label="$t('date.capacity')"
                                type="number"
                                :required="true"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-sm-12">
                            <div class="form-check form-check-inline">
                                <BaseCheckbox
                                    id="unlimited_capacity"
                                    v-model="date.unlimited_capacity"
                                    :label="$t('date.unlimited_capacity')"
                                />
                            </div>
                            <div class="form-check form-check-inline">
                                <BaseCheckbox
                                    id="substitute"
                                    v-model="date.substitute"
                                    :label="$t('date.substitute')"
                                />
                            </div>
                            <div class="form-check form-check-inline">
                                <BaseCheckbox
                                    id="online"
                                    v-model="date.online"
                                    :label="$t('date.online')"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-lg-3 col-sm-6">
                            <BaseInput
                                v-model="date.date_from"
                                :label="$t('date.date_from')"
                                type="date"
                                :required="true"
                                @change="updateDateTo"
                            />
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <BaseInput
                                v-model="date.time_from"
                                :label="$t('date.time_from')"
                                type="time"
                                :required="true"
                                @change="updateTimeTo"
                            />
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <BaseInput
                                v-model="date.date_to"
                                :label="$t('date.date_to')"
                                type="date"
                                :required="true"
                            />
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <BaseInput
                                v-model="date.time_to"
                                :label="$t('date.time_to')"
                                type="time"
                                :required="true"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_from"
                                :label="$t('date.enrollment_from')"
                                type="date"
                                :required="true"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_from_time"
                                :label="$t('date.enrollment_from')"
                                type="time"
                                :required="true"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_to"
                                :label="$t('date.enrollment_to')"
                                type="date"
                                :required="true"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_to_time"
                                :label="$t('date.enrollment_to_time')"
                                type="time"
                                :required="true"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="date.withdraw_date"
                                :label="$t('date.withdraw_date')"
                                type="date"
                                :required="true"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.withdraw_time"
                                :label="$t('date.withdraw_time')"
                                type="time"
                                :required="true"
                            />
                        </div>
                    </div>

                    <SubmitButton label="date.save" />
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { inject, reactive, ref } from 'vue'
import SubmitButton from '../../Form/SubmitButton.vue'
import BaseInput from '../../Form/BaseInput.vue'
import BaseCheckbox from '../../Form/BaseCheckbox.vue'
import moment from 'moment/moment'
import EditDateList from './EditDateList.vue'
import {
    dateObject,
    formatEventDates,
    mapLastDateObject
} from '../../../../utils/DataMapper'
import axios from 'axios'
import { Bootstrap4Pagination } from 'laravel-vue-pagination'

const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    eventId: { type: Number, required: true },
    showAddDate: { type: Boolean, required: true }
})
const emit = defineEmits(['setDates', 'showError'])

let showDateForm = ref(false)
let edit = false
let dates = ref([])
let datesResponse = ref({})
let date = reactive(dateObject)

getEventDates()

async function addDate() {
    if (dates.value.length === 0) {
        date.id = 1
    }

    edit ? await editDate() : await createDate()

    showDateForm.value = false
    getEventDates()
    clearDateObject()
}

async function removeDate(id, blockReason) {
    await axios.post(ADMIN_URL + '/dates/' + id + '/delete', {
        data: blockReason
    })
    getEventDates()
}

async function createDate() {
    await axios
        .post(ADMIN_URL + '/dates/' + props.eventId + '/create', {
            date: date
        })
        .catch((e) => {
            emit('showError', e.response.data.errors)
        })
}

async function editDate() {
    edit = false

    await axios
        .put(ADMIN_URL + '/dates/' + date.id + '/update', {
            date: date
        })
        .catch((e) => {
            emit('showError', e.response.data.errors)
        })
}

function setEditForm(id) {
    clearDateObject()
    showDateForm.value = true
    edit = true
    date = Object.assign(date, {
        ...dates.value.find((date) => date.id === id)
    })
}

function clearDateObject() {
    edit = false
    Object.keys(date).forEach(function (i) {
        date[i] =
            i === 'substitute' || i === 'unlimited_capacity'
                ? (date[i] = false)
                : (date[i] = null)
    })
    setLastDates()
}

function updateDateTo() {
    if (date.date_from !== null && date.date_to === null) {
        date.date_to = date.date_from
    }
}
function updateTimeTo() {
    if (date.time_from !== null && date.time_to === null) {
        let [hour, minute] = date.time_from.split(':')
        let fromTime = moment().hour(parseInt(hour)).minute(parseInt(minute))
        date.time_to = fromTime.add(1, 'h').add(30, 'm').format('HH:mm')
    }
}

function closeForm() {
    showDateForm.value = false
    clearDateObject()
}

function setLastDates() {
    if (dates.value.length > 0) {
        let lastDate = dates.value[dates.value.length - 1]
        mapLastDateObject(date, lastDate)
    }
}

async function getEventDates(page = 1) {
    let response = await axios.get(
        ADMIN_URL + '/dates/' + props.eventId + `?page=${page}`
    )
    datesResponse.value = response.data
    dates.value = formatEventDates(response.data.data)

    emit('setDates', dates.value)
}
</script>
