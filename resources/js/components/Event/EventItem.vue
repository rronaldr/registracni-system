<template>
    <div class="col-lg-4">
        <div class="card card-margin">
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-primary">
                            <span class="widget-49-date-day">2</span>
                            <span class="widget-49-date-month">čvc</span>
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title">RB 101</span>
                            <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span>
                        </div>
                    </div>
                    <ol class="widget-49-meeting-points">
                        <li class="widget-49-meeting-item"><span>{{ props.event.description }}</span></li>
                    </ol>
                    <div class="widget-49-meeting-action">
                        <a :href="APP_URL +'/events/' +event.id" class="btn btn-sm btn-flash-border-primary">Více informací</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {inject} from "vue";

const props = defineProps({
  event: {type: Object, required: true}
})

const APP_URL = inject('APP_URL')
</script>
