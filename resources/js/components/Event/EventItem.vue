<template>
    <tr>
        <td>
            <a class="hover-reverse" :href="APP_URL + '/events/' + event.id">{{ props.event.name }}</a><br />
            <small>{{ props.event.subtitle }}</small>
        </td>
        <td>
            {{ formatDate(props.event.date_start_cache) }} -
            {{ formatDate(props.event.date_end_cache) }}
        </td>
        <td>{{ props.event.contact_person }}</td>
        <td>{{ $t('user_group.' + props.event.user_group) }}</td>
        <td>
            <a
                :href="APP_URL + '/events/' + event.id"
                class="btn btn-sm btn-primary"
                >Zobrazit</a
            >
        </td>
    </tr>
</template>

<script setup>
import { inject } from 'vue'
import { formatDate } from '../../utils/DateFormat'

const props = defineProps({
    event: { type: Object, required: true }
})

const APP_URL = inject('APP_URL')
</script>
