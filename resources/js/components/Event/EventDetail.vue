<template>
    <div id="calendar-content" class="container bg-white py-4 px-2 h-auto">
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
                                <th scope="row">
                                    {{ $t('event.first_date') }}:
                                </th>
                                <td>
                                    {{
                                        formatDate(props.event.date_start_cache)
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    {{ $t('event.last_date') }}:
                                </th>
                                <td>
                                    {{ formatDate(props.event.date_end_cache) }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    {{ $t('event.contact_person') }}:
                                </th>
                                <td>
                                    <a
                                        :href="
                                            'mailto:' + props.event.author.email
                                        "
                                    >
                                        {{
                                            props.event.author.first_name +
                                            ' ' +
                                            props.event.author.last_name
                                        }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-5 col-xl-4 pl-lg-0">
                    <div class="text-center mb-1 event-detail-image">
                        <img
                            class="mw-100 mx-auto"
                            src="https://picsum.photos/450/300"
                            alt="Alumni Homecoming VŠE"
                        />
                    </div>

                    <div class="mb-4 event-share-links">
                        <div class="btn-group mr-1">
                            <button
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                                class="btn btn-outline-primary border-0 px-1 mt-1 dropdown-toggle rounded-0 text-left"
                            >
                                <i class="fa fa-calendar mr-1"></i>Přidat do
                                kalendáře
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    href="/event/ical?date=4701&amp;period=202310"
                                    class="dropdown-item"
                                    ><i class="icon icon-calendar mr-1"></i>
                                    Kalendářová událost (iCal)</a
                                >
                                <a
                                    href="/event/add-to-google-calendar?date=4701&amp;period=202310"
                                    class="dropdown-item"
                                    target="_blank"
                                    ><i class="icon icon-google mr-1"></i>
                                    Google Kalendář</a
                                >
                            </div>
                        </div>
                        <div class="btn-group">
                            <button
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                                class="btn btn-outline-primary border-0 px-1 mt-1 dropdown-toggle rounded-0 text-left"
                            >
                                <i class="fa fa-share mr-1"></i> Sdílet...
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    href="/event/share?network=facebook&amp;date=4701&amp;period=202310"
                                    class="dropdown-item"
                                    target="_blank"
                                    ><i class="icon icon-facebook mr-1"></i
                                    >Facebook</a
                                >
                                <a
                                    href="/event/share?network=twitter&amp;date=4701&amp;period=202310"
                                    class="dropdown-item"
                                    target="_blank"
                                    ><i class="icon icon-twitter mr-1"></i>
                                    Twitter</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center">{{ props.event.description }}</p>
        </section>
    </div>

    <DateList :dates="event.dates" />
</template>

<script setup>
import { formatDate } from '../../utils/DateFormat'
import DateList from '../Date/DateList.vue'

const props = defineProps({
    event: { type: Object, required: true }
})
</script>
