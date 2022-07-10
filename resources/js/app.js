import { createApp } from "vue";

// Root App
import App from "./components/App.vue";
import init from "./helpers/init.js";
import BootstrapVue3 from 'bootstrap-vue-3';
import money from 'v-money3';


// Import Bootstrap and BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'
import SmartTable from 'vuejs-smart-table'

// Vue Router
import router from "./router";

// Vuex Store
import store from "./store";

// Initial Setup -> You can emit an actions from store to load the data
init();

// root app instance
const app = createApp(App);

// Mountin an app
app.use(SmartTable).use(money).use(BootstrapVue3).use(store).use(router).mount("#app");

