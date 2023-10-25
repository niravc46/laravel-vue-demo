import "./bootstrap";

import { createApp } from "vue";
import { createPinia } from "pinia";
import router from './router/index.js';
import App from "./layouts/App.vue";

const app = createApp(App).use(router);
app.use(createPinia());
app.mount("#app");
