<template>
    <div v-if="events.length > 0" class="row">
        <EventItem v-for="event in events" :key="event.id" :event="event" />
    </div>
    <p v-else>{{ $t('event.no_events') }}</p>
</template>

<script setup>
import EventItem from './EventItem.vue'

defineProps({
    events: { type: Object, required: true }
})
</script>
