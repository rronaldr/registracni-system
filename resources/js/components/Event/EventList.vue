<template>
    <div v-if="events != null && events.length > 0" class="row">
        <div class="table table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ $t('event.event_name') }}</th>
                        <th scope="col">{{ $t('date.dates') }}</th>
                        <th scope="col">{{ $t('event.contact_person') }}</th>
                        <th scope="col">{{ $t('event.can_register') }}</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <EventItem
                        v-for="event in events"
                        :key="event.id"
                        :event="event"
                    />
                </tbody>
            </table>
        </div>

        <Bootstrap4Pagination
            :data="paginationData"
            @pagination-change-page="getEvents"
        />
    </div>
    <p v-else>{{ $t('event.no_events') }}</p>
</template>

<script setup>
import EventItem from './EventItem.vue'
import { Bootstrap4Pagination } from 'laravel-vue-pagination'
import axios from 'axios'
import { inject, ref } from 'vue'

const APP_URL = inject('APP_URL')
let events = ref(null)
let paginationData = ref({})

getEvents()

async function getEvents(page = 1) {
    let response = await axios.get(APP_URL + `/events?page=${page}`)
    paginationData.value = response.data
    events.value = response.data.data
}
</script>
