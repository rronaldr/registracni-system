<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5>
                                Termíny <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Zde vytvořte termíny pro událost"></i>
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
                    <p v-if="dates.length > 0">test</p>
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
                        @click="showDateForm = false"></button>
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
                                v-model="date.room"
                                :label="$t('date.room')"
                                type="text"
                            />
                        </div>
                        <div class="col-6">
                            <BaseInput
                                v-model="date.capacity"
                                :label="$t('date.capacity')"
                                type="number"
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
                        <div class="col-8">
                            <BaseInput
                                v-model="date.date_from"
                                :label="$t('date.date_from')"
                                type="date"
                                @change="updateDateTo"
                            />
                        </div>
                        <div class="col-4">
                            <BaseInput
                                v-model="date.time_from"
                                :label="$t('date.time_from')"
                                type="time"
                                @change="updateTimeTo"
                            />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <BaseInput
                                v-model="date.date_to"
                                :label="$t('date.date_to')"
                                type="date"
                            />
                        </div>
                        <div class="col-4">
                            <BaseInput
                                v-model="date.time_to"
                                :label="$t('date.time_to')"
                                type="time"
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
                                v-model="date.enrollment_to"
                                :label="$t('date.enrollment_to')"
                                type="date"
                            />
                        </div>
                        <div class="col">
                            <BaseInput
                                v-model="date.signoff_to"
                                :label="$t('date.signoff_to')"
                                type="date"
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
import {ref} from "vue";
import SubmitButton from "../Form/SubmitButton.vue";
import BaseInput from "../Form/BaseInput.vue";
import BaseCheckbox from "../Form/BaseCheckbox.vue";
import moment from "moment/moment";

const emit = defineEmits(['createDate'])
const props = defineProps({
    id: {type: String, required: false},
    dates: {type: Array, required: false}
})

let showDateForm = ref(true)
let date = ref({
    name: null,
    room: null,
    capacity: null,
    unlimited_capacity: false,
    substitute: false,
    date_from: null,
    time_from: null,
    date_to: null,
    time_to: null,
    enrollment_from: null,
    enrollment_to: null,
    signoff_to: null
})

function addDate() {
    emit('createDate', date.value)
    clearDateObject()
}

setLastDates()

function clearDateObject() {
    Object.keys(date.value).forEach((i) => date[i] = null)
    setLastDates()
}

function updateDateTo() {
    if (date.value.date_from !== null && date.value.date_to === null){
        date.value.date_to = date.value.date_from
    }
}
function updateTimeTo() {
    if (date.value.time_from !== null && date.value.time_to === null){
        let [hour, minute] = date.value.time_from.split(":")
        let fromTime = moment().hour(parseInt(hour)).minute(parseInt(minute))
        date.value.time_to = fromTime.add(1, 'h').add(30,'m').format('HH:mm')
    }
}

function setLastDates() {
    if (props.dates.length > 0) {
        let lastDate = props.dates.slice(-1)
        date.date_from = lastDate.date_from
        date.time_from = lastDate.time_from
        date.date_to = lastDate.date_to
        date.time_to = lastDate.time_to
        date.enrollment_from = lastDate.enrollment_from
        date.enrollment_to = lastDate.enrollment_to
        date.signoff_to = lastDate.signoff_to
    }
}
</script>
