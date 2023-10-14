<template>
    <div class="container">
        <div class="row">
            <!-- Main content -->
            <div class="col-lg-12 mb-3">
                <div
                    class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0"
                >
                    <div class="row align-items-center">
                        <div class="col-md-10 mb-3 mb-sm-0">
                            <h5>
                                <p v-if="date.name" class="text-primary">
                                    {{ date.name }}
                                </p>
                                <span
                                    ><i class="fa fa-clock"></i>
                                    {{ formatDate(date.date_start) }} -
                                    {{ formatDate(date.date_end) }}</span
                                >
                            </h5>
                            <p class="text-sm">
                                <i class="fa fa-map-pin"></i>
                                <span class="text-black">{{
                                    date.location
                                }}</span>
                            </p>
                        </div>
                        <div class="col-md-2">
                            <div class="row text-center">
                                <span
                                    >Přihlášeno:
                                    {{
                                        date.enrollments_count +
                                        '/' +
                                        date.capacity
                                    }}</span
                                >
                                <a
                                    :href="APP_URL + '/enrollment/' + date.id"
                                    class="btn btn-primary"
                                    >Přihlásit se</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import moment from 'moment/moment'
import { inject } from 'vue'

defineProps({
    date: { type: Object, required: true }
})

const APP_URL = inject('APP_URL')

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
.text-black,
.text-hover-black:hover {
    color: #000 !important;
}
.font-weight-bold {
    font-weight: 700 !important;
}
</style>
