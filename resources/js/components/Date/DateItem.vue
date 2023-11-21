<template>
    <div class="card py-1 px-1 mb-2">
        <div class="row align-items-center">
            <div class="col-md-4 mb-sm-0 pt-1 align-self-start">
                <h5>
                    <p v-if="date.name != null" class="text-primary">
                        {{ date.name }}
                    </p>
                    <span>
                        {{ formatDate(date.date_start) }} -
                        {{ formatDate(date.date_end) }}</span
                    >
                </h5>
                <p class="text-sm">
                    <span class="font-weight-bold">Místnost:</span>
                    {{ date.location }}
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    <span class="font-weight-bold"
                        >{{ $t('date.registration') }}:</span
                    ><br />
                    {{ formatDate(date.enrollment_start) }} -
                    {{ formatDate(date.enrollment_end) }}
                </p>
                <p>
                    <span class="font-weight-bold"
                        >{{ $t('date.withdraw_to') }}:</span
                    ><br />
                    {{ formatDate(date.withdraw_end) }}
                </p>
            </div>
            <div class="col-md-2">
                <div class="row text-center">
                    <span
                        >{{ $t('enrollment.enrolled_count') }}:
                        {{ date.enrollments_count + '/' + date.capacity }}</span
                    >
                    <a
                        v-if="date.can_enroll"
                        :href="APP_URL + '/enrollment/' + date.id"
                        class="btn btn-primary"
                        >{{ enrollText }}</a
                    >
                    <a
                        v-else-if="hasUser === 0"
                        :href="APP_URL + '/login'"
                        class="btn btn-sm btn-primary"
                    >
                        {{ $t('app.app_login') }}
                    </a>
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

const { t } = useI18n({})
let props = defineProps({
    date: { type: Object, required: true },
    hasUser: { type: Number, required: true }
})

const APP_URL = inject('APP_URL')

let enrollText =
    props.date.enrollments_count < props.date.capacity
        ? t('enrollment.enroll')
        : t('enrollment.enroll_substitute')

const formatDate = function (date) {
    if (date) {
        return moment(String(date)).format('DD.MM.YYYY HH:mm')
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
