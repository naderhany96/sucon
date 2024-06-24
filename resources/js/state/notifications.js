export default {
    namespaced: true,
    state: {
        fetched: false,
        notseen: false,
        notifications: []
    },
    getters: {
        fetched(state) {
            return state.fetched
        },
        notseen(state) {
            return state.notseen
        },
        notifications(state) {
            return state.notifications
        }
    },
    mutations: {
        SET_FETCHED(state, value) {
            state.fetched = value
        },
        SET_NOTSEEN(state, value) {
            state.notseen = value
        },
        SET_NOTIFICATIONS(state, value) {
            state.notifications = value
        }
    },
    actions:{
        addNotification({commit}, data){
            commit('SET_FETCHED', true)
            commit('SET_NOTIFICATIONS', data)
        },
        unreadedMSG({commit}){
            commit('SET_NOTSEEN', true)
        },
        allMSGsReaded({commit}){
            commit('SET_NOTSEEN', false)
        },
        setFetched({commit}, data){
            commit('SET_FETCHED', data)
        },
        
    },
}
