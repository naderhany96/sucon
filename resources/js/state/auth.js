import router from '../router'
import store from './store'

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {}
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },
        SET_USER(state, value) {
            state.user = value
        }
    },
    actions:{
        login({commit}, userData){
            commit('SET_USER', userData)
            commit('SET_AUTHENTICATED',true)
            window.axios.defaults.headers.common['Authorization'] = userData.token != undefined ? userData.token : '';
            window.Permissions = userData.permissions != undefined ? userData.permissions : [];
            router.push({name:'home'})
        },
        logout({commit}){
            // window.Echo.leave('laravel_database_notification.' + store.state.auth.user.id);
            store.dispatch('notifications/setFetched', false);
            commit('SET_USER',{});
            commit('SET_AUTHENTICATED',false);
        },
        refresh({commit}, userData){
            commit('SET_USER', userData)
            window.axios.defaults.headers.common['Authorization'] = userData.token != undefined ? userData.token : '';
            window.Permissions = userData.permissions != undefined ? userData.permissions : [];
        },
    },
}
