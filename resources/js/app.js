require("./bootstrap");

window.Vue = require("vue").default;

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue) 

// main component
Vue.component("main-component", require("./App.vue").default);
Vue.component("auth-data-component", require("./components/AuthData.vue").default);

// DETAIL COMPONENT
Vue.component("detail-participant", require("./pages/DetailParticipant.vue"));

// BOOTSTRAP COMPONENT
import { BPagination, BDropdown, BDropdownItemButton, BModal } from "bootstrap-vue";
Vue.component('b-pagination', BPagination);
Vue.component('b-dropdown', BDropdown);
Vue.component('b-dropdown-item-button', BDropdownItemButton);
Vue.component('b-modal', BModal);

// FONT AWESOME
import '@fortawesome/fontawesome-free/js/all.js'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon)

// Vue Router
import router from "./routers/index";

//  Vuex
import Vuex from "vuex";
Vue.use(Vuex);
import StoreVuex from "./stores/index";
const store = new Vuex.Store(StoreVuex);

// Vue Meta
import VueMeta from 'vue-meta'
Vue.use(VueMeta, {
  // optional pluginOptions
  refreshOnceOnNavigation: true
})

// SWEET ALERT
import VueSweetalert2 from "vue-sweetalert2";
import Vue from "vue";
Vue.use(VueSweetalert2);

// mixin
Vue.mixin({
    computed: {
        Authenticated() {
            return this.$store.getters.Authenticated;
        },
        AuthUser() {
            return this.$store.getters.AuthUser;
        },
        CurrentRoute() {
            return this.$route.name;
        },
    },
});


new Vue({
    metaInfo: {
        titleTemplate: (title) =>
            title ? `${title}` - 'Test' : "Talentlytica-Fullstack-Test",
    },
    store,
    router,
    el: "#app",
});
