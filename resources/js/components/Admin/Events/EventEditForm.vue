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

        <div class="row mb-3">
            <div class="col">
                <BaseSelect
                    v-model="event.user_group"
                    :options="user_groups"
                    :label="$t('event.user_group')"
                    :placeholder="true"
                    :placeholder-text="$t('event.user_group_placeholder')"
                />
            </div>
        </div>

        <div class="line"></div><br>

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.type') }}</label>
            <div class="col-sm-10">
                <BaseRadioGroup
                    v-model="event.type"
                    :options="dateTypeOptions"/>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.global_blacklist') }}<br></label>
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

        <div class="row mb-3">
            <label class="col-sm-2">{{ $t('event.event_blacklist') }}<br></label>
            <div class="col-sm-10">
                <div class="form-check form-switch mb-3">
                    <input v-model="event.event_blacklist" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="col-sm-2 d-inline">{{ $t('event.enable_event_blacklist') }}
                    </label>
                </div>
            </div>
        </div>

        <div v-if="event.event_blacklist" class="row mb-3">
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

        <div class="row mb-3">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion-tags-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-tags" aria-expanded="false" aria-controls="accordion-tags">
                            {{ $t('tag.tag')}}
                        </button>
                    </h2>
                    <div id="accordion-tags" class="accordion-collapse collapse mt-2" aria-labelledby="accordion-tags-header">
                        <TagForm
                            :tags="tags"
                        />
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion-template-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-template" aria-expanded="false" aria-controls="accordion-template">
                            {{ $t('event.template')}}
                        </button>
                    </h2>
                    <div id="accordion-template" class="accordion-collapse collapse show mt-2" aria-labelledby="accordion-template-header">
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
                    </div>
                </div>
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
    user: {type: Object, required: true},
    event: {type: Object, required: true}
})

const {t} = useI18n({})
const dateTypeOptions = [
    {label: t('event.type_1'), value: 1},
    {label: t('event.type_2'), value: 2}
]

let tags = ref([])
let dates = ref([])
let templates = ref(null)
let user_groups = [
    {id: 1, name: t('user_group.1')},
    {id: 2, name: t('user_group.2')},
    {id: 3, name: t('user_group.3')},
    {id: 4, name: t('user_group.4')},
    {id: 5, name: t('user_group.5')},
]

getApprovedTemplates()

function submitEvent() {
    let csrf = document.getElementsByName('_token')[0].value
    let data = {
        event: props.event,
        dates: dates.value,
        tags: tags.value,
        _token: csrf
    }

    axios.post(
        ADMIN_URL+'/events/update',
        data
    )
        .then(
            window.location.href = ADMIN_URL+'/events',
        )
        .catch(error => {
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