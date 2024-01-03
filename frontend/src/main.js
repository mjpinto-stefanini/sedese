import { createApp } from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";
import store from "./store";
import globalMixin from "./mixins/globalMixin";
import { Quasar } from "quasar";
import quasarUserOptions from "./quasar-user-options";
import VueTheMask from 'vue-the-mask';
import axios from "@/plugins/axios";

// principal do fontawesome
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon, FontAwesomeLayers, FontAwesomeLayersText } from '@fortawesome/vue-fontawesome'
// imports necessários para utilizar os icones
import { faUserSecret, faUnlockKeyhole } from '@fortawesome/free-solid-svg-icons';
import { faUser, faPenToSquare } from "@fortawesome/free-regular-svg-icons";

// carrega os icones selecionados
library.add(faUserSecret, faUser, faPenToSquare, faUnlockKeyhole);

createApp(App)
  .use(Quasar, quasarUserOptions)
  .component('font-awesome-icon', FontAwesomeIcon)
  .component('font-awesome-layers', FontAwesomeLayers)
  .component('font-awesome-layer-text', FontAwesomeLayersText)
  .use(store)
  .use(axios)
  .use(VueTheMask)
  .mixin(globalMixin)
  .use(router)
  .mount("#app");
