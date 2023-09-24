<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5>
                                {{ $t('date.dates') }} <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" :title="$t('date.date_box_hint')"></i>
                            </h5>
                        </div>
                        <div class="col">
                            <button
                                @click="showDateForm = true"
                                class="btn btn-sm btn-primary float-end"
                                type="button"
                            >
                                <i class="fas fa-plus"></i> {{ $t('date.add_date') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <DateList
                        v-if="dates.length > 0"
                        :dates="dates"
                        @edit-date="editDate"
                        @remove-date="removeDate"
                    />
                    <p v-else class="card-text">{{ $t('date.empty' )}}</p>
                </div>
            </div>

            <form
                class="bg-lighter-grey border rounded p-2"
                v-if="showDateForm"
                @submit.prevent="addDate"
            >
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">{{ $t('date.add_date') }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeForm()"></button>
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
                                    :label="$t('date.unlimited_capacity')"
                                    v-model="date.unlimited_capacity"
                                />
                            </div>
                            <div class="form-check form-check-inline">
                                <BaseCheckbox
                                    id="substitute"
                                    :label="$t('date.substitute')"
                                    v-model="date.substitute"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-3">
                            <BaseInput
                                v-model="date.date_from"
                                :label="$t('date.date_from')"
                                type="date"
                                @change="updateDateTo"
                                :required="true"
                            />
                        </div>
                        <div class="col-3">
                            <BaseInput
                                v-model="date.time_from"
                                :label="$t('date.time_from')"
                                type="time"
                                @change="updateTimeTo"
                                :required="true"
                            />
                        </div>

                        <div class="col-3">
                            <BaseInput
                                v-model="date.date_to"
                                :label="$t('date.date_to')"
                                type="date"
                                :required="true"
                            />
                        </div>
                        <div class="col-3">
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
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_from_time"
                                :label="$t('date.enrollment_from')"
                                type="time"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_to"
                                :label="$t('date.enrollment_to')"
                                type="date"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.enrollment_to_time"
                                :label="$t('date.enrollment_to_time')"
                                type="time"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <BaseInput
                                v-model="date.withdraw_date"
                                :label="$t('date.withdraw_date')"
                                type="date"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.withdraw_time"
                                :label="$t('date.withdraw_time')"
                                type="time"
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
import moment from "moment/moment";
import DateList from "./DateList.vue";

const props = defineProps({
    dates: {type: Array, required: false}
})

let showDateForm = ref(false)
let edit = false
let date = reactive({
    id: null,
    name: null,
    location: null,
    capacity: null,
    unlimited_capacity: false,
    substitute: false,
    date_from: null,
    time_from: null,
    date_to: null,
    time_to: null,
    enrollment_from: null,
    enrollment_from_time: null,
    enrollment_to: null,
    enrollment_to_time: null,
    withdraw_date: null,
    withdraw_time: null
})

// let x = {
//     id: 1,
//     name: null,
//     location: 'RB101',
//     capacity: 20,
//     unlimited_capacity: false,
//     substitute: false,
//     date_from: '2023-08-08',
//     time_from: '14:00',
//     date_to: '2023-09-08',
//     time_to: '16:00',
//     enrollment_from: null,
//     enrollment_from_time: null,
//     enrollment_to: null,
//     enrollment_to_time: null,
//     withdraw_date: null,
//     withdraw_time: null,
// }
// let y = {
//     id: 2,
//     name: null,
//     location: 'SB203',
//     capacity: 20,
//     unlimited_capacity: false,
//     substitute: false,
//     date_from: '2023-09-08',
//     time_from: '14:00',
//     date_to: '2023-09-20',
//     time_to: '16:00',
//     enrollment_from: null,
//     enrollment_from_time: null,
//     enrollment_to: null,
//     enrollment_to_time: null,
//     withdraw_date: null,
//     withdraw_time: null,
// }
// props.dates.push({...x})
// props.dates.push({...y})

setLastDates()

function addDate() {
    if (props.dates.length === 0) {
        date.id = 1
    }

    if (edit) {
        edit = false
        removeDate(date.id)
    }

    props.dates.push({...date})
    showDateForm.value = false

    clearDateObject()
}

function editDate(id) {
    clearDateObject()
    showDateForm.value = true
    edit = true

    date = {...props.dates.find(date => date.id === id)}
}

function removeDate(id) {
    const index = props.dates.findIndex(date => date.id === id)
    if (index !== -1) {
        props.dates.splice(index, 1)
    }
}

function clearDateObject() {
    Object.keys(date).forEach((i) => date[i] = null)
    setLastDates()
}

function updateDateTo() {
    if (date.date_from !== null && date.date_to === null){
        date.date_to = date.date_from
    }
}
function updateTimeTo() {
    if (date.time_from !== null && date.time_to === null){
        let [hour, minute] = date.time_from.split(":")
        let fromTime = moment().hour(parseInt(hour)).minute(parseInt(minute))
        date.time_to = fromTime.add(1, 'h').add(30,'m').format('HH:mm')
    }
}

function closeForm() {
    showDateForm.value = false
    clearDateObject()
}

function setLastDates() {
    if (props.dates.length > 0) {
        let lastDate = props.dates[props.dates.length - 1]
        date.id = lastDate.id + 1
        date.date_from = lastDate.date_from
        date.time_from = lastDate.time_from
        date.date_to = lastDate.date_to
        date.time_to = lastDate.time_to
        date.enrollment_from = lastDate.enrollment_from
        date.enrollment_from_time = lastDate.enrollment_from_time
        date.enrollment_to = lastDate.enrollment_to
        date.enrollment_to_time = lastDate.enrollment_to_time
        date.withdraw_date = lastDate.withdraw_date
        date.withdraw_time = lastDate.withdraw_time
    }
}
</script>
