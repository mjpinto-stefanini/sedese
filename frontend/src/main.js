import { createApp } from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";
import store from "./store";
import globalMixin from "./mixins/globalMixin";
import { Quasar } from "quasar";
import quasarUserOptions from "./quasar-user-options";

import axios from "@/plugins/axios";

createApp(App)
  .use(Quasar, quasarUserOptions)
  .use(store)
  .use(axios)
  .mixin(globalMixin)
  .use(router)
  .mount("#app");
