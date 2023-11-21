<template>
    <div class="container bg-white my-3 pb-2 px-2 h-auto">
        <div v-if="dates != null && dates.length > 0" class="row">
            <h2 class="px-2">{{ $t('date.upcoming') }}</h2>
            <div class="col-lg-12 mb-2">
                <DateItem v-for="date in dates" :key="date.id" :date="date" :has-user="hasUser" />

                <Bootstrap4Pagination
                    :data="paginationData"
                    @pagination-change-page="getDates"
                />
            </div>
        </div>
        <div v-else>
            <h2 class="px-2">{{ $t('date.no_dates') }}</h2>
        </div>
    </div>
</template>

<script setup>
import DateItem from './DateItem.vue'
import { inject, ref } from 'vue'
import axios from 'axios'
import { Bootstrap4Pagination } from 'laravel-vue-pagination'

const APP_URL = inject('APP_URL')
const props = defineProps({
    eventId: { type: Number, required: true },
    hasUser: { type: Number, required: true }
})

let dates = ref(null)
let paginationData = ref({})

getDates()

async function getDates(page = 1) {
    let response = await axios.get(
        APP_URL + `/events/${props.eventId}/dates?page=${page}`
    )
    paginationData.value = response.data
    dates.value = response.data.data
}
</script>