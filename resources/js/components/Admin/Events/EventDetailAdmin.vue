<template>
    <div class="row mb-3 justify-content-right">
        <div class="col-12">
            <a
                type="button"
                class="btn btn-outline-secondary btn-sm mr-1"
                :href="ADMIN_URL + '/events/' + event.id + '/duplicate'"
                ><i class="fas fa-copy"></i> {{ $t('event.duplicate') }}</a
            >
            <a
                type="button"
                class="btn btn-outline-secondary btn-sm mr-1"
                :href="ADMIN_URL + '/events/' + event.id + '/export'"
                ><i class="fas fa-file-export"></i> {{ $t('event.export') }}</a
            >
            <a
                type="button"
                class="btn btn-outline-secondary btn-sm mr-1"
                :href="ADMIN_URL + '/events/' + event.id + '/users/export'"
                ><i class="fas fa-users"></i> {{ $t('event.export_users') }}</a
            >
            <a
                type="button"
                class="btn btn-outline-secondary btn-sm mr-1"
                :href="
                    ADMIN_URL + '/events/' + event.id + '/users/export-email'
                "
                ><i class="fas fa-envelope"></i>
                {{ $t('event.export_emails') }}</a
            >
            <button
                type="button"
                class="btn btn-outline-secondary btn-sm mr-1"
                @click="copyIframe"
            >
                <i class="fas fa-copy"></i> {{ $t('event.copy_shortcode') }}
            </button>
            <button
                v-if="canViewEvent"
                type="button"
                class="btn btn-outline-success btn-sm mr-1 mt-md-1"
                @click="showCollabModal = true"
            >
                <i class="fas fa-user-plus"></i>
                {{ $t('event.add_collaborator') }}
            </button>
        </div>
    </div>

    <div
        v-if="showCollabMessage"
        class="bg-success text-white py-1 px-1 pr-0 rounded font-bold mb-2 shadow-lg"
    >
        <p>
            {{ $t('event.collaborator_added') }}
        </p>
    </div>
    <ErrorMessages v-if="errors" :errors="errors" />

    <section class="event-detail">
        <div class="row">
            <div class="event-detail-description col-lg-6 col-xl-6">
                <table class="table table-borderless event-detail-basic-info">
                    <tbody>
                        <tr>
                            <th class="pl-0">{{ $t('event.event_name') }}:</th>
                            <td>
                                {{ event.name }}
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">{{ $t('event.subtitle') }}:</th>
                            <td>
                                {{ event.subtitle ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">{{ $t('event.calendar_id') }}:</th>
                            <td>
                                {{ event.calendar_id ?? $t('app.not_set') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">
                                {{ $t('event.contact_person') }}:
                            </th>
                            <td>
                                <a :href="'mailto:' + event.author.email"
                                    >{{ event.contact_person }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">{{ $t('event.status') }}:</th>
                            <td>
                                {{ $t(`statuses.${event.status}`) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="event-detail-description col-lg-6 col-xl-6">
                <table class="table table-borderless event-detail-basic-info">
                    <tbody>
                        <tr>
                            <th class="pl-0">{{ $t('event.user_group') }}:</th>
                            <td>
                                {{ $t('user_group.' + event.user_group) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">{{ $t('event.type') }}:</th>
                            <td>
                                {{ $t(`event.type_${event.type}`) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">
                                {{ $t('event.global_blacklist') }}:
                            </th>
                            <td>
                                {{
                                    event.global_blacklist
                                        ? $t('event.enabled')
                                        : $t('event.disabled')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <th class="pl-0">
                                {{ $t('event.event_blacklist') }}:
                            </th>
                            <td>
                                {{
                                    event.event_blacklist
                                        ? $t('event.enabled')
                                        : $t('event.disabled')
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="row mb-3">
        <div class="col-md-12">
            <div id="accordion">
                <!-- START Dates -->
                <div class="card">
                    <div
                        id="accordion-tags-header"
                        class="card-header bg-white"
                    >
                        <h5 class="mb-0">
                            <button
                                type="button"
                                class="btn btn-link"
                                data-toggle="collapse"
                                data-target="#accordion-tags"
                                aria-expanded="true"
                                aria-controls="collapseOne"
                            >
                                {{ $t('date.dates') }}
                            </button>
                        </h5>
                    </div>
                    <div
                        id="accordion-tags"
                        class="collapse show"
                        aria-labelledby="accordion-tags-header"
                        data-parent="#accordion"
                    >
                        <div class="card-body">
                            <DateDetailList
                                v-if="dates.length > 0"
                                :dates="dates"
                            />
                            <p v-else class="card-text">
                                {{ $t('date.empty') }}
                            </p>

                            <Bootstrap4Pagination
                                :data="datesResponse"
                                @pagination-change-page="getEventDates"
                            />
                        </div>
                    </div>
                </div>
                <!-- END Dates -->

                <!-- START Custom fields -->
                <div class="card">
                    <div
                        id="accordion-template-header"
                        class="card-header bg-white"
                    >
                        <h5 class="mb-0">
                            <button
                                type="button"
                                class="btn btn-link"
                                data-toggle="collapse"
                                data-target="#accordion-template"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                            >
                                {{ $t('tag.tag') }}
                            </button>
                        </h5>
                    </div>
                    <div
                        id="accordion-template"
                        class="collapse"
                        aria-labelledby="accordion-template-header"
                        data-parent="#accordion"
                    >
                        <div class="card-body">
                            <TagDetailList
                                v-if="tags.length > 0"
                                :tags="tags"
                            />
                            <p v-else class="card-text">
                                {{ $t('tag.empty') }}
                            </p>
                        </div>
                    </div>
                    <!-- END Custom fields -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div v-if="canViewEvent" class="col">
            <button
                v-if="event.status === 1"
                type="button"
                class="btn btn-primary mx-1 mb-2 text-center"
                @click="changeEventStatus(2)"
            >
                {{ $t('event.change_concept') }}
            </button>
            <button
                v-else-if="event.status === 2"
                type="button"
                class="btn btn-primary mx-1 mb-2 text-center"
                @click="changeEventStatus(1)"
            >
                {{ $t('event.publish_event') }}
            </button>
        </div>
    </div>

    <!-- START Collaborator modal -->
    <Teleport to="body">
        <CustomModal :show="showCollabModal" @close="showCollabModal = false">
            <template #modal-header>
                <h5>{{ $t('enrollment.enrollments') }}</h5>
            </template>
            <template #modal-body>
                <div class="row">
                    <div class="col-12">
                        <form @submit.prevent="addCollaboratorToEvent">
                            <BaseInput
                                v-model="collabEmail"
                                :label="$t('event.add_collaborator_hint')"
                                :required="true"
                                class="mb-3"
                                type="email"
                            />

                            <SubmitButton />
                        </form>
                    </div>
                </div>
            </template>
        </CustomModal>
    </Teleport>
    <!-- END Collaborator modal -->
</template>

<script setup>
import { inject, ref } from 'vue'
import CustomModal from '../CustomModal.vue'
import BaseInput from '../Form/BaseInput.vue'
import SubmitButton from '../Form/SubmitButton.vue'
import axios from 'axios'
import ErrorMessages from '../../ErrorMessages.vue'
import { Bootstrap4Pagination } from 'laravel-vue-pagination'
import { formatEventDates } from '../../../utils/DataMapper'
import DateDetailList from '../Dates/Detail/DateDetailList.vue'
import TagDetailList from '../Tags/Detail/TagDetailList.vue'

const APP_URL = inject('APP_URL')
const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    event: { type: Object, required: true },
    author: { type: String, required: false, default: null },
    lastChangeUser: { type: String, required: false, default: null },
    canView: { type: Number, required: true }
})
let canViewEvent = Boolean(props.canView)
let showCollabModal = ref(false)
let showCollabMessage = ref(false)
let collabEmail = ref(null)
let errors = ref(null)
let dates = ref([])
let datesResponse = ref({})
let tags = ref([])

getEventDates()
getEventTags()

function addCollaboratorToEvent() {
    let data = {
        collaborator: collabEmail.value
    }

    axios
        .post(ADMIN_URL + '/events/' + props.event.id + '/collaborate', {
            data
        })
        .then(() => {
            collabEmail.value = null
            showCollabModal.value = false
            showCollabMessage.value = true

            setTimeout(() => {
                showCollabMessage.value = false
            }, 5000)
        })
        .catch((e) => {
            collabEmail.value = null
            showCollabModal.value = false
            errors.value = e.response.data.errors
            window.scrollTo(0, 0)
        })
}

function changeEventStatus(status) {
    let data = {
        status: status
    }

    axios
        .post(ADMIN_URL + '/events/' + props.event.id + '/status', {
            data
        })
        .then(() => {
            location.reload()
        })
}

async function getEventDates(page = 1) {
    let response = await axios.get(
        ADMIN_URL + '/dates/' + props.event.id + `?page=${page}`
    )
    datesResponse.value = response.data
    dates.value = formatEventDates(response.data.data)
}

async function getEventTags() {
    let response = await axios.get(
        ADMIN_URL + '/events/' + props.event.id + '/tags'
    )
    tags.value = response.data.tags
}

function copyIframe() {
    let iframeUrl = `[iframe src="${APP_URL}/external/${props.event.id}" width="800" height="600"]`
    navigator.clipboard.writeText(iframeUrl)
}
</script>
