<template>
    <form method="post" enctype="multipart/form-data" @submit.prevent="submitEvent">
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
                    @click="fillContactWithCurrentUser"
                    v-show="(event.contact.person === null || event.contact.person === '') || (event.contact.email === null || event.contact.email === '')"
                    type="button"
                    class="btn btn-primary form-control align-self-end"
                    name="event-link">{{ $t('event.fill_user_contact') }}</button>
            </div>
        </div>

        <div class="line"></div><br>

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.settings') }}</label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <BaseCheckbox
                        id="external_login"
                        :label="$t('event.external_login')"
                        v-model="event.external_login"
                    />
                </div>
                <div class="form-check form-check-inline">
                    <BaseCheckbox
                        id="notifications"
                        :label="$t('event.notifications')"
                        v-model="event.notifications"
                    />
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.type') }}</label>
            <div class="col-sm-10">
                <BaseRadioGroup
                    v-model="event.type"
                    :options="dateTypeOptions"/>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.blacklist') }}<br></label>
            <div class="col-sm-10">
                <div class="form-check form-switch mb-3">
                    <input v-model="event.global_blacklist" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="col-sm-2 d-inline">Zapnout systémový
                        <a class="link-primary"
                           :href="ADMIN_URL +'/blacklist'" target="_blank">blacklist</a>
                    </label>
                </div>
            </div>
        </div>

        <div v-if="!event.global_blacklist" class="row mb-3">
            <div class="col">
                <a class="link-secondary float-end" data-bs-toggle="modal" data-bs-target="#infoModal">
                    <i class="fas fa-info-circle"></i> {{ $t('app.show-hint') }}
                </a>
                <BaseTextarea
                    v-model="event.blacklist_users"
                    label="Xname uživatelů, které chcete zablokovat"
                    :required="true"
                />
            </div>
        </div>

        <!-- Custom blacklist modal start -->
        <div class="modal fade" id="infoModal" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('event.blacklist_modal_title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

        <div class="line"></div><br>

        <DateForm
            :dates="dates"
        />

        <div class="line"></div><br>

        <TagForm
            :tags="tags"
        />

        <div class="line"></div><br>

        <div class="row mb-3">
            <div class="col">
                <BaseSelect
                    v-model="event.template.id"
                    :options="templates"
                    :label="$t('template.select')"
                    :placeholder="true"
                    :placeholder-text="$t('template.select')"
                />
            </div>
        </div>

        <TemplateTags
            :tags="tags"
        />
        <div class="row mb-3">
            <div class="col">
                <label for="subtitle" class="form-label">Textarea šablony content</label>
                <TinyEditor
                    v-model="event.template.content"
                />
            </div>
        </div>

        <FormButtons :route="ADMIN_URL +'/events'" />
    </form>
</template>

<script setup>
import {inject, reactive, ref} from "vue";
import FormButtons from "../Form/FormButtons.vue";
import axios from "axios";
import BaseInput from "../Form/BaseInput.vue";
import BaseCheckbox from "../Form/BaseCheckbox.vue";
import BaseTextarea from "../Form/BaseTextarea.vue";
import BaseRadioGroup from "../Form/BaseRadioGroup.vue";
import BaseSelect from "../Form/BaseSelect.vue";
import {useI18n} from "vue-i18n";
import TinyEditor from "../../TinyEditor.vue";
import TemplateTags from "../TemplateTags/TemplateTags.vue";
import DateForm from "../Dates/DateForm.vue";
import TagForm from "../Tags/TagForm.vue";

const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    user: {type: Object, required: true}
})

const {t} = useI18n({})
const dateTypeOptions = [
    {label: t('event.type_1'), value: 1},
    {label: t('event.type_2'), value: 2}
]

let event = reactive({
    name: null,
    subtitle: null,
    calendar_id: null,
    contact: {
        person: null,
        email: null
    },
    external_login: false,
    notifications: false,
    type: 1,
    global_blacklist: true,
    blacklist_users: null,
    template: {
        id: null,
        content: null,
    }
})

let tags = ref([])
let dates = ref([])
let templates = ref(null)

getApprovedTemplates()

function submitEvent() {
    let csrf = document.getElementsByName('_token')[0].value
    let data = {
        event: event,
        dates: dates.value,
        tags: tags.value,
        _token: csrf
    }

    console.log('test',data)
    axios.post(
        ADMIN_URL+'/events/store',
        data
    ).catch(error => {
        console.log(error)
    })
}

function fillContactWithCurrentUser() {
    event.contact.person = props.user.display_name !== null
        ? props.user.display_name
        : props.user.first_name+' '+ props.user.last_name
    event.contact.email = props.user.email
}

async function getApprovedTemplates() {
    let response = await axios.get(ADMIN_URL+'/templates/approved')
    templates.value = response.data.templates
}
</script>
