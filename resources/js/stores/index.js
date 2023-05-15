import axios from 'axios';
import router from '../routers/index'
import VuexPersistence from 'vuex-persist';

const vuexLocal = new VuexPersistence({
    storage: window.localStorage,
});

export default {
    state: {
        // Auth User
        AuthUser: [],
        Authenticated: false,
        Token: null,
        // Admin Check
        IsAdmin: false,

    },
    actions: {},
    mutations: {
        SET_AUTHUSER(state, user) {
            state.AuthUser = user;
        },
        SET_AUTHENTICATED(state, data) {
            state.Authenticated = data;
        },
        SET_ADMIN(state, data) {
            state.IsAdmin = data;
        },
        SET_TOKEN(state, data) {
            state.Token = data;
        },
    },
    getters: {
        AuthUser(state) {
            return state.AuthUser;
        },
        Authenticated(state) {
            return state.Authenticated;
        },
        IsAdmin(state) {
            return state.IsAdmin;
        },
        Token(state) {
            return state.Token;
        },
    },
    plugins: [vuexLocal.plugin],
}
