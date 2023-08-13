require('./bootstrap');

import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';

// Translations
import cs from "./locales/cs.json";

import en from "./locales/en.json";
// Admin Components
import FormButtons from "./components/Admin/Form/FormButtons.vue";
import BlacklistPage from "./components/Admin/Blacklist/BlacklistPage.vue";

import EventCreateForm from "./components/Admin/Events/EventCreateForm.vue";
// Components
import EventList from "./components/Event/EventList";
import EventDetail from "./components/Event/EventDetail";
import Enrollment from "./components/Enrollment";
import TinyEditor from './components/TinyEditor.vue'

const i18n = createI18n({
    locale: 'cs',
    fallbackLocale: 'en',
    messages: {cs, en}
})

const app = createApp({
    components: {
        TinyEditor,
        BlacklistPage,
        FormButtons,
        EventCreateForm,
        EventList,
        EventDetail,
        Enrollment,
    }
});

app.provide('ADMIN_URL', 'http://localhost/admin')
app.provide('APP_URL', 'http://localhost')

app.use(i18n)
app.mount("#vueApp");
