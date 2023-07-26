require('./bootstrap');

import { createApp } from "vue/dist/vue.esm-bundler.js";

// Components
import TinyEditor from "./components/TinyEditor.vue";

const app = createApp({
    components: {
        TinyEditor,
    }
});

app.mount("#vueApp");
