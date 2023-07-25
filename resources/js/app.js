import './bootstrap';

import { createApp } from "vue/dist/vue.esm-bundler.js";

// Components
import ExampleComponent from "./components/ExampleComponent.vue";

const app = createApp({
    components: {
        ExampleComponent,
    }
});

app.mount("#vueApp");
