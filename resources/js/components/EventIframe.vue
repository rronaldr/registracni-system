<template>
    <div class="bg-white rounded shadow px-1 pt-0 pb-2 m-0">
        <div class="row p-2">
            <div class="col-12">
                <h3>{{ $t('event.event_name') }}: {{ event.name }}</h3>
                <h5>{{ $t('date.dates') }}</h5>
            </div>
        </div>

        <IframeDateList :has-user="hasUser" :event-id="event.id" />
    </div>
</template>

<script setup>
import IframeDateList from './Date/IframeDateList.vue'

defineProps({
    event: { type: Object, required: true },
    hasUser: { type: Number, required: true }
})
</script>
