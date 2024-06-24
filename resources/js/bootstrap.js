import store from './state/store'
import axios from 'axios';
import axiosRetry from 'axios-retry';
import appConfig from "@/app.config";

let originUrl = window.location.origin;
axios.defaults.baseURL = originUrl + '/' + appConfig.api_prefix + '/'; 
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Authorization'] = store.state.auth.user.token != undefined ? store.state.auth.user.token : '';
axios.defaults.withCredentials = true;

axiosRetry(axios, { retries: 3 });
window.axios = require('axios');

function setAxiosInterceptors(){
    window.axios.interceptors.response.use(function (response) {
        return response;
    }, function (error) {
        if (error.response.status == 401) {// Unauthenticated
            store.dispatch('auth/logout');
            window.location.href = '/admin/login';
        }
        if (error.response.status == 403) {
            alert('Permission Denied');
        }
        return Promise.reject(error);
    });
}

window.Permissions = store.state.auth.user.permissions != undefined ? store.state.auth.user.permissions : [];
// this line to fetch permissions each time user reload the page
store.dispatch('notifications/setFetched', false);
setAxiosInterceptors();


// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: "ABCDEFG",
//     cluster: "mt1",
//     forceTLS: false,
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     // wsHost: "josequal.net",
//     // wsPort: 3030,
//     disableStats: true,
//     encrypted: false,
//     auth: {
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//             Authorization: 'Bearer ' + store.state.auth.user.token
//         },
//     },
// });
