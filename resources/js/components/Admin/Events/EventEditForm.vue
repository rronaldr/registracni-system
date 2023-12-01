<template>
    <div class="row mb-3">
        <div class="col-12">
            <h4>{{ $t('event.info') }}</h4>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>{{ $t('app.author') }}</th>
                        <th>{{ $t('app.created_at') }}</th>
                        <th>{{ $t('app.updated_at') }}</th>
                        <th>{{ $t('event.updated_by') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ author }}</td>
                        <td>{{ formatDate(event.created_at) }}</td>
                        <td>{{ formatDate(event.updated_at) }}</td>
                        <td>{{ lastChangeUser }}</td>
                    </tr>
                </tbody>
            </table>
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

    <div class="row mb-3 justify-content-right">
        <div class="col-12 text-right">
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
                class="btn btn-outline-success btn-sm mr-1"
                @click="showCollabModal = true"
            >
                <i class="fas fa-user-plus"></i>
                {{ $t('event.add_collaborator') }}
            </button>
        </div>
    </div>

    <form
        method="post"
        enctype="multipart/form-data"
        @submit.prevent="submitEvent"
    >
        <slot name="csrf"></slot>

        <div class="row mb-3">
            <div class="col">
                <BaseInput
                    v-model="event.name"
                    :label="$t('event.name')"
                    type="text"
                    class="mb-3"
                    :required="true"
                />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <BaseInput
                    v-model="event.subtitle"
                    :label="$t('event.subtitle')"
                    type="text"
                    class="mb-3"
                />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <BaseInput
                    v-model="event.calendar_id"
                    :label="$t('event.calendar')"
                    type="text"
                    class="mb-3"
                />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-5 col-sm-6">
                <BaseInput
                    v-model="event.contact.person"
                    :label="$t('event.contact_person')"
                    type="text"
                    class="mb-3"
                    :required="true"
                />
            </div>
            <div class="col-lg-5 col-sm-6">
                <BaseInput
                    v-model="event.contact.email"
                    :label="$t('event.contact_email')"
                    type="email"
                    class="mb-3"
                    :required="true"
                />
            </div>

            <div class="col-lg-2 col-sm-12">
                <button
                    v-show="
                        event.contact.person === null ||
                        event.contact.person === '' ||
                        event.contact.email === null ||
                        event.contact.email === ''
                    "
                    type="button"
                    class="btn btn-primary form-control align-self-end"
                    name="event-link"
                    @click="fillContactWithCurrentUser"
                >
                    {{ $t('event.fill_user_contact') }}
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <UserGroupSelect v-model="event.user_group" />
            </div>
        </div>

        <div class="line"></div>
        <br />

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.type') }}</label>
            <div class="col-sm-10">
                <BaseRadioGroup
                    v-model="event.type"
                    :options="dateTypeOptions"
                    @change="handleEventTypeSwitch"
                />
            </div>
            <p v-if="eventTypeError" class="text-danger ml-2">
                {{ $t('event.event_type_error') }}
            </p>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2"
                >{{ $t('event.global_blacklist') }}<br
            /></label>
            <div class="col-sm-10">
                <BaseCheckbox
                    v-model="event.global_blacklist"
                    :label="$t('event.global_blacklist_event')"
                />
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2"
                >{{ $t('event.event_blacklist') }}<br
            /></label>
            <div class="col-sm-10">
                <BaseCheckbox
                    v-model="event.event_blacklist"
                    :label="$t('event.enable_event_blacklist')"
                    @change="createBlacklist"
                />
            </div>
        </div>

        <BlacklistEditPage
            v-if="event.event_blacklist"
            :blacklist-id="event.blacklist_id"
        >
            <template #csrf>
                <slot name="csrf"></slot>
            </template>
        </BlacklistEditPage>

        <!-- Custom blacklist modal start -->
        <div id="infoModal" class="modal fade" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $t('event.blacklist_modal_title') }}
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-start">
                        <p>
                            {{ $t('event.blacklist_modal_text') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Custom blacklist modal end -->

        <div class="line"></div>
        <br />

        <EditDateForm
            :event-id="event.id"
            :show-add-date="showAddDate"
            @set-dates="setDates"
            @show-error="showError"
        />

        <div class="line"></div>
        <br />

        <div class="row mb-3">
            <div class="col-md-12">
                <div id="accordion">
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
                                    {{ $t('tag.show_tag') }}
                                </button>
                            </h5>
                        </div>
                        <div
                            id="accordion-tags"
                            class="collapse"
                            aria-labelledby="accordion-tags-header"
                            data-parent="#accordion"
                        >
                            <div class="card-body">
                                <EditTagForm
                                    :tags="tags"
                                    :event-id="event.id"
                                    @get-tags="getEventTags"
                                />
                            </div>
                        </div>
                    </div>
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
                                    {{ $t('event.template') }}
                                </button>
                            </h5>
                        </div>
                        <div
                            id="accordion-template"
                            class="collapse show"
                            aria-labelledby="accordion-template-header"
                            data-parent="#accordion"
                        >
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <TemplateSelect
                                            v-model="event.template.id"
                                            :options="templates"
                                            :label="$t('template.select')"
                                            :required="true"
                                        />
                                    </div>
                                </div>
                                <TemplateTags :tags="tags" />
                                <div
                                    v-if="event.template.id !== 1"
                                    class="row mb-3"
                                >
                                    <div class="col">
                                        <label
                                            for="subtitle"
                                            class="form-label"
                                            >{{
                                                $t('event.template_content')
                                            }}</label
                                        >
                                        <TinyEditor
                                            v-model="event.template.content"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <FormButtons :route="ADMIN_URL + '/events'" />
    </form>

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
import { inject, reactive, ref, watch } from 'vue'
import axios from 'axios'
import { useI18n } from 'vue-i18n'
import FormButtons from '../Form/FormButtons.vue'
import BaseInput from '../Form/BaseInput.vue'
import BaseRadioGroup from '../Form/BaseRadioGroup.vue'
import BaseCheckbox from '../Form/BaseCheckbox.vue'
import TinyEditor from '../../TinyEditor.vue'
import TemplateTags from '../TemplateTags/TemplateTags.vue'
import BlacklistEditPage from '../Blacklist/Edit/BlacklistEditPage.vue'
import UserGroupSelect from './UserGroupSelect.vue'
import EditDateForm from '../Dates/Edit/EditDateForm.vue'
import EditTagForm from '../Tags/Edit/EditTagForm.vue'
import { editEventMap } from '../../../utils/DataMapper'
import EventStatusSelect from './EventStatusSelect.vue'
import { formatDate } from '../../../utils/DateFormat'
import TemplateSelect from '../TemplateTags/TemplateSelect.vue'
import SubmitButton from '../Form/SubmitButton.vue'
import CustomModal from '../CustomModal.vue'
import ErrorMessages from '../../ErrorMessages.vue'

const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    user: { type: Object, required: true },
    event: { type: Object, required: true },
    author: { type: String, required: false, default: null },
    lastChangeUser: { type: String, required: false, default: null }
})

const { t } = useI18n({})
const dateTypeOptions = [
    { label: t('event.type_1'), value: 1 },
    { label: t('event.type_2'), value: 2 }
]

let tags = ref([])
let dates = ref([])
let templates = ref(null)
let event = reactive(editEventMap(props.event))
let errors = ref(null)
let showCollabModal = ref(false)
let showCollabMessage = ref(false)
let collabEmail = ref(null)
let eventTypeError = ref(false)
let showAddDate = ref(true)

getEventTags()
getApprovedTemplates()

function submitEvent() {
    let csrf = document.getElementsByName('_token')[0].value
    let data = {
        event: event,
        _token: csrf
    }

    axios
        .put(ADMIN_URL + '/events/' + event.id + '/update', {
            data
        })
        .then((window.location.href = ADMIN_URL + '/events'))
        .catch((e) => {
            errors.value = e.response.data.errors
            window.scrollTo(0, 0)
        })
}

function showError(error) {
    errors.value = error
    window.scrollTo(0, 0)
}

function fillContactWithCurrentUser() {
    event.contact.person =
        props.user.display_name !== null
            ? props.user.display_name
            : props.user.first_name + ' ' + props.user.last_name
    event.contact.email = props.user.email
}

function addCollaboratorToEvent() {
    let csrf = document.getElementsByName('_token')[0].value
    let data = {
        collaborator: collabEmail.value,
        _token: csrf
    }

    axios
        .post(ADMIN_URL + '/events/' + event.id + '/collaborate', {
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

watch(
    () => [event.type, dates.value.length],
    () => {
        showAddDate.value =
            event.type === 1 || (event.type === 2 && dates.value.length === 0)
    }
)

function handleEventTypeSwitch() {
    if (event.type && dates.value.length > 1) {
        event.type = 1
        eventTypeError.value = true

        setTimeout(() => {
            eventTypeError.value = false
        }, 3000)
    }
}

function setDates(childDates) {
    dates.value = childDates
}

async function createBlacklist() {
    if (event.blacklist_id === null) {
        let response = await axios.post(
            ADMIN_URL + '/events/' + event.id + '/blacklist'
        )
        event.blacklist_id = response.data.blacklist
    }
}

async function getApprovedTemplates() {
    let response = await axios.get(ADMIN_URL + '/templates/approved')
    templates.value = response.data.templates
}

async function getEventTags() {
    let response = await axios.get(
        ADMIN_URL + '/events/' + props.event.id + '/tags'
    )
    tags.value = response.data.tags
}
</script>
