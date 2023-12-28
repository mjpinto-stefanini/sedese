import "./styles/quasar.scss";
import lang from "quasar/lang/pt-BR.js";
import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/material-icons-outlined/material-icons-outlined.css";
import "@quasar/extras/material-icons-round/material-icons-round.css";
import "@quasar/extras/material-icons-sharp/material-icons-sharp.css";
import "@quasar/extras/material-symbols-outlined/material-symbols-outlined.css";
import "@quasar/extras/mdi-v6/mdi-v6.css";
import { Notify, Loading } from 'quasar';
// To be used on app.use(Quasar, { ... })
export default {
  config: {},
  plugins: [Notify, Loading],
  lang: lang,
};
