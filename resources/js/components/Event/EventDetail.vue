<template>
    <div id="calendar-content" class="container bg-white px-2 h-auto">
        <div class="container p-xl-0">
            <header class="row align-items-end pt-lg-2">
                <div class="col">
                    <div class="mb-2">
                        <a href="/" class="font-weight-bold hover-reverse"
                            ><span class="icon icon-arrow-left"></span
                            >&nbsp;&nbsp;{{ $t('event.overview') }}</a
                        >
                    </div>
                </div>
            </header>
        </div>
        <section class="event-detail">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="text-primary mb-2">
                        {{ props.event.name }}
                    </h1>
                    <h3>
                        <small class="d-block">{{
                            props.event.subtitle
                        }}</small>
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="event-detail-description col-lg-7 col-xl-8">
                    <table
                        class="table table-borderless event-detail-basic-info"
                    >
                        <tbody>
                            <tr>
                                <th class="pl-0">
                                    {{ $t('event.first_date') }}:
                                </th>
                                <td>
                                    {{
                                        formatDate(props.event.date_start_cache)
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pl-0">
                                    {{ $t('event.last_date') }}:
                                </th>
                                <td>
                                    {{ formatDate(props.event.date_end_cache) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pl-0">
                                    {{ $t('event.can_register') }}:
                                </th>
                                <td>
                                    {{
                                        $t(
                                            'user_group.' +
                                                props.event.user_group
                                        )
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pl-0">
                                    {{ $t('event.contact_person') }}:
                                </th>
                                <td>
                                    <a
                                        :href="
                                            'mailto:' + props.event.author.email
                                        "
                                        >{{ props.event.contact_person }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    v-if="calendarData.thumbnail != null"
                    class="col-lg-5 col-xl-4 pl-lg-0"
                >
                    <div class="text-center mb-1 event-detail-image">
                        <img
                            class="mw-100 mx-auto"
                            :src="calendarData.thumbnail"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div
                    v-if="calendarData.description != null"
                    class="col-lg-12"
                    v-html="calendarData.description"
                ></div>
            </div>
        </section>
    </div>

    <DateList :event-id="event.id" :has-user="hasUser" />
</template>

<script setup>
import { formatDate } from '../../utils/DateFormat'
import DateList from '../Date/DateList.vue'
import axios from 'axios'
import { reactive } from 'vue'

const props = defineProps({
    event: { type: Object, required: true },
    hasUser: { type: Number, required: true }
})
let calendarData = reactive({ description: null, thumbnail: null })

if (props.event.calendar_id != null) {
    getCalendarData()
}

async function getCalendarData() {
    let response = await axios.get(
        `https://kalendar.vse.cz/api/event/${props.event.calendar_id}`
    )

    calendarData.description = response.data.text
    calendarData.thumbnail = response.data.image
}
</script>
