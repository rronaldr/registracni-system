require('./bootstrap');

import { createApp } from "vue/dist/vue.esm-bundler.js";
import { createI18n } from 'vue-i18n';

// Translations
import cs from "./locales/cs.json";
import en from "./locales/en.json";

// Components
import TinyEditor from "./components/TinyEditor.vue";
import BlacklistForm from "./components/Blacklist/BlacklistForm.vue";

const i18n = createI18n({
    locale: 'cs',
    fallbackLocale: 'en',
    messages: {cs, en}
})

const app = createApp({
    components: {
        TinyEditor,
        BlacklistForm,
    }
});

app.use(i18n)
app.mount("#vueApp");
