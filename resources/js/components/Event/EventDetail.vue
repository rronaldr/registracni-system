<template>
    <div id="calendar-content" class="container bg-white px-2 h-auto">
        <div class="container p-xl-0">
            <header class="row align-items-end pt-lg-2">
                <div class="col">
                    <div class="mb-2">
                        <a href="/" class="font-weight-bold hover-reverse"
                            ><span class="icon icon-arrow-left"></span
                            >&nbsp;&nbsp;Přehled všech událostí</a
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
                <div class="col-lg-5 col-xl-4 pl-lg-0">
                    <div class="text-center mb-1 event-detail-image">
                        <img
                            class="mw-100 mx-auto"
                            src="https://picsum.photos/450/300"
                            alt="Alumni Homecoming VŠE"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <DateList :event-id="event.id" :has-user="hasUser" />
</template>

<script setup>
import { formatDate } from '../../utils/DateFormat'
import DateList from '../Date/DateList.vue'

const props = defineProps({
    event: { type: Object, required: true },
    hasUser: { type: Number, required: true }
})
</script>
