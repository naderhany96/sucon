import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'
import auth from './auth'
import notifications from './notifications'
import layout from './modules/layout'

Vue.use(Vuex)

const store = new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',

    plugins: [
        createPersistedState()
    ],
    modules: {
        auth,
        layout,
        notifications
    }
})
export default store
