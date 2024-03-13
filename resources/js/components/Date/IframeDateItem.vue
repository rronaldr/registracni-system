<template>
    <div
        :style="{
            opacity:
                Boolean(hasUser) &&
                date.can_sign_off != null &&
                date.can_sign_off
                    ? '70%'
                    : '100%'
        }"
        class="card"
    >
        <div class="row px-1 mx-1 mb-1 align-items-center">
            <div class="col-md-9 mb-sm-0 pt-1 align-self-start">
                <h5>
                    <span>
                        {{ formatDate(date.date_start) }} -
                        {{ formatDate(date.date_end) }}</span
                    >
                </h5>
                <p class="text-sm">
                    <span class="font-weight-bold">{{
                        date.location === 'online'
                            ? $t('date.form')
                            : $t('date.location')
                    }}</span>
                    {{ date.location }}
                </p>
                <p>
                    <span class="font-weight-bold"
                        >{{ $t('date.registration') }}:</span
                    ><br />
                    {{ formatDate(date.enrollment_start) }} -
                    {{ formatDate(date.enrollment_end) }}
                </p>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div v-if="date.capacity === -1">
                        {{ $t('date.unlimited_registration') }}
                    </div>
                    <div v-else>
                        {{ $t('enrollment.enrolled_count') }}:
                        {{ date.enrollments_count + '/' + date.capacity }}
                    </div>
                </div>
                <div class="row">
                    <a
                        v-if="date.can_enroll"
                        :href="APP_URL + '/external/enrollment/' + date.id"
                        class="btn btn-sm btn-primary"
                        >{{ enrollText }}</a
                    >
                    <a
                        v-else-if="hasUser === 0"
                        class="btn btn-sm btn-primary text-white"
                        @click="openLoginPopup"
                    >
                        {{ $t('app.app_login') }}
                    </a>
                    <button
                        v-else-if="
                            date.can_sign_off != null && date.can_sign_off
                        "
                        class="btn btn-primary btn-sm"
                        @click="signOffUser()"
                    >
                        {{ $t('enrollment.sign_off') }}
                    </button>
                    <p v-else class="text-danger text-left">
                        {{ $t('enrollment.cant_enroll') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import moment from 'moment/moment'
import { inject } from 'vue'
import { useI18n } from 'vue-i18n'
import axios from 'axios'

const { t } = useI18n({})
let props = defineProps({
    date: { type: Object, required: true },
    hasUser: { type: Number, required: true }
})

const APP_URL = inject('APP_URL')

let enrollText =
    props.date.capacity === -1 ||
    props.date.enrollments_count < props.date.capacity
        ? t('enrollment.enroll')
        : t('enrollment.enroll_substitute')

const formatDate = function (date) {
    if (date) {
        return moment(String(date)).format('DD.MM.YYYY HH:mm')
    }
}

const openLoginPopup = () => {
    window.open(
        `${APP_URL}/external/auth/login`,
        '_blank',
        'width=800,height=600,status=0,toolbar=0'
    )
}

async function signOffUser() {
    if (props.date.enrollment_id != null) {
        let enrollmentId = props.date.enrollment_id
        await axios
            .post(`${APP_URL}/enrollment/${enrollmentId}/signoff/json`)
            .then(() => {
                location.reload()
            })
    }
}
</script>

<style scoped>
body {
    margin-top: 20px;
    background: #eee;
    color: #708090;
}
a {
    text-decoration: none;
}
.text-primary,
a.text-primary:focus,
a.text-primary:hover {
    color: #00adbb !important;
}
</style>
