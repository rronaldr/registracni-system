import axios from 'axios'

require('./bootstrap')
import { createApp } from 'vue'
import { createI18n } from 'vue-i18n'

// Translations
import cs from './locales/cs.json'
import en from './locales/en.json'
// Admin Components
import FormButtons from './components/Admin/Form/FormButtons.vue'
import BlacklistPage from './components/Admin/Blacklist/BlacklistPage.vue'
import EventCreateForm from './components/Admin/Events/EventCreateForm.vue'
import EventEditForm from './components/Admin/Events/EventEditForm.vue'
import RolesPage from './components/Admin/Roles/RolesPage.vue'
// Components
import EventList from './components/Event/EventList'
import EventDetail from './components/Event/EventDetail'
import EnrollmentForm from './components/EnrollmentForm.vue'
import EnrollmentIframeForm from './components/EnrollmentIframeForm.vue'
import EventDetailAdmin from './components/Admin/Events/EventDetailAdmin.vue'
import EventIframe from './components/EventIframe.vue'

const i18n = createI18n({
    locale: 'cs',
    fallbackLocale: 'en',
    messages: { cs, en },
    legacy: false,
    warnHtmlMessage: false
})

const app = createApp({
    components: {
        BlacklistPage,
        FormButtons,
        EventCreateForm,
        EventEditForm,
        EventList,
        EventDetailAdmin,
        EventDetail,
        EventIframe,
        EnrollmentForm,
        EnrollmentIframeForm,
        RolesPage
    }
})

const APP_URL = 'http://127.0.0.1:8080'
const ADMIN_URL = 'http://127.0.0.1:8080/admin'

function loadLocale() {
    return axios
        .get(APP_URL + '/locale/get')
        .then((response) => {
            return response.data.locale
        })
        .catch((error) => {
            console.error(error)
        })
}

i18n.global.locale.value = await loadLocale()

app.provide('ADMIN_URL', ADMIN_URL)
app.provide('APP_URL', APP_URL)

app.use(i18n)
app.mount('#vueApp')
