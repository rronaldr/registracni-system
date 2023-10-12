<template>
    <div class="row">
        <EventItem
            v-for="event in events"
            :key="event.id"
            :event="event"
        />
    </div>

</template>

<script setup>
import EventItem from "./EventItem.vue";

const props = defineProps({
    events: {type: Object, required: true}
})
</script>
