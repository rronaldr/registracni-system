require('./bootstrap');

import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';

// Translations
import cs from "./locales/cs.json";
import en from "./locales/en.json";

// Components
import TinyEditor from "./components/TinyEditor.vue";
import BlacklistPage from "./components/Blacklist/BlacklistPage.vue";
import FormButtons from "./components/Form/FormButtons.vue";

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
    }
});

app.provide('ADMIN_URL', 'http://localhost/admin')
app.provide('APP_URL', 'http://localhost')

app.use(i18n)
app.mount("#vueApp");
