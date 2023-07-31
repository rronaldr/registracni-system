require('./bootstrap');

import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
import moment from "moment";

// Translations
import cs from "./locales/cs.json";
import en from "./locales/en.json";

// Admin Components
import TinyEditor from "./components/Admin/TinyEditor.vue";
import FormButtons from "./components/Admin/Form/FormButtons.vue";
import BlacklistPage from "./components/Admin/Blacklist/BlacklistPage.vue";
import EventCreateForm from "./components/Admin/Events/EventCreateForm.vue";

// Components
import EventList from "./components/Event/EventList.vue";
import EventDetail from "./components/Event/EventDetail.vue";
import Enrollment from "./components/Enrollment.vue";

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
