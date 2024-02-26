<template>
    <ErrorMessages :errors="errors" />

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
                <a
                    class="link-secondary float-end"
                    data-toggle="modal"
                    data-target="#calendarModal"
                >
                    <i class="fas fa-info-circle"></i>
                    {{ $t('app.show-hint') }} </a
                ><br />
                <BaseInput
                    v-model="event.calendar_id"
                    :label="$t('event.calendar')"
                    type="text"
                    class="mb-3"
                />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-4 col-sm-6">
                <BaseInput
                    v-model="event.contact.person"
                    :label="$t('event.contact_person')"
                    type="text"
                    class="mb-3"
                    :required="true"
                />
            </div>
            <div class="col-lg-4 col-sm-6">
                <BaseInput
                    v-model="event.contact.email"
                    :label="$t('event.contact_email')"
                    type="email"
                    class="mb-3"
                    :required="true"
                />
            </div>

            <div class="col-lg-4 col-sm-12 d-flex flex-column mt-1">
                <button
                    v-show="
                        event.contact.person === null ||
                        event.contact.person === '' ||
                        event.contact.email === null ||
                        event.contact.email === ''
                    "
                    type="button"
                    class="btn btn-primary rounded-0 form-control mt-3"
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
                >{{ $t('event.global_blacklist') }}
                <span
                    v-html="
                        $t('blacklist.global_users_link', {
                            link: `${ADMIN_URL}/blacklist/users/global`
                        })
                    "
                ></span
                ><br
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
                <div>
                    <BaseCheckbox
                        v-model="event.event_blacklist"
                        :label="$t('event.enable_event_blacklist')"
                    />
                </div>
            </div>
        </div>

        <div v-if="event.event_blacklist" class="row mb-3">
            <div class="col">
                <a
                    class="link-secondary float-end"
                    data-toggle="modal"
                    data-target="#infoModal"
                >
                    <i class="fas fa-info-circle"></i> {{ $t('app.show-hint') }}
                </a>
                <br />
                <BaseTextarea
                    v-model="event.blacklist_users"
                    label="Xname uživatelů, které chcete zablokovat"
                    :required="true"
                />
            </div>
        </div>

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

        <!-- Custom calendar id modal start -->
        <div id="calendarModal" class="modal fade" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $t('event.calendar_modal_title') }}
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
                            {{ $t('event.calendar_modal_text') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Custom calendar id end -->

        <div class="line"></div>
        <br />

        <DateForm :dates="dates" :show-add-date="showAddDate" />

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
                                <TagForm :tags="tags" />
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
                                    {{ $t('event.registration_notification') }}
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
                                <div v-if="parseInt(event.template.id) !== 0">
                                    <TemplateTags :tags="tags" />
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label
                                                for="subtitle"
                                                class="form-label"
                                                >{{
                                                    $t(
                                                        'event.notification_text'
                                                    )
                                                }}</label
                                            >
                                            <TinyEditor
                                                v-model="event.template.content"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-else
                                    class="alert alert-info"
                                    role="alert"
                                >
                                    {{ $t('template.default_hint') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <BackButton :route="ADMIN_URL + '/events'" />
            </div>
            <div class="col text-right">
                <SubmitButton />
                <button
                    type="button"
                    class="btn btn-outline-primary mx-1 mb-2 text-center"
                    @click="submitEvent(true)"
                >
                    <i class="fas fa-save"></i> {{ $t('event.save_publish') }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { inject, reactive, ref, watch } from 'vue'
import axios from 'axios'
import BaseInput from '../Form/BaseInput.vue'
import BaseTextarea from '../Form/BaseTextarea.vue'
import BaseRadioGroup from '../Form/BaseRadioGroup.vue'
import { useI18n } from 'vue-i18n'
import TinyEditor from '../../TinyEditor.vue'
import TemplateTags from '../TemplateTags/TemplateTags.vue'
import DateForm from '../Dates/DateForm.vue'
import TagForm from '../Tags/TagForm.vue'
import UserGroupSelect from './UserGroupSelect.vue'
import {
    duplicateEventMap,
    eventCreateObject,
    importDatesMap
} from '../../../utils/DataMapper'
import BaseCheckbox from '../Form/BaseCheckbox.vue'
import TemplateSelect from '../TemplateTags/TemplateSelect.vue'
import ErrorMessages from '../../ErrorMessages.vue'
import BackButton from '../Form/BackButton.vue'
import SubmitButton from '../Form/SubmitButton.vue'

const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    user: { type: Object, required: true },
    event: { type: Object, required: false, default: null },
    dates: { type: Object, required: false, default: null }
})

const { t } = useI18n({})
const dateTypeOptions = [
    { label: t('event.type_1'), value: 1 },
    { label: t('event.type_2'), value: 2 }
]

let event =
    props.event == null
        ? reactive(eventCreateObject)
        : reactive(duplicateEventMap(props.event))

let tags = ref([])
let dates = props.dates == null ? ref([]) : ref(importDatesMap(props.dates))
let templates = ref(null)
let errors = ref(null)
let eventTypeError = ref(false)
let showAddDate = ref(true)

getApprovedTemplates()

function submitEvent(publish = false) {
    let csrf = document.getElementsByName('_token')[0].value
    let data = {
        event: event,
        publish: publish,
        dates: dates.value,
        tags: tags.value,
        _token: csrf
    }

    axios
        .post(ADMIN_URL + '/events/store', data)
        .then(() => {
            window.location.href = ADMIN_URL + '/events'
        })
        .catch((e) => {
            errors.value = e.response.data.errors
            window.scrollTo(0, 0)
        })
}

function fillContactWithCurrentUser() {
    event.contact.person =
        props.user.display_name !== null
            ? props.user.display_name
            : props.user.first_name + ' ' + props.user.last_name
    event.contact.email = props.user.email
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

async function getApprovedTemplates() {
    let response = await axios.get(ADMIN_URL + '/templates/approved')
    templates.value = response.data.templates
}
</script>
