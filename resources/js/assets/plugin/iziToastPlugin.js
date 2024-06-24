import Vue from 'vue'
import iziToast from 'izitoast'
import 'izitoast/dist/css/iziToast.min.css'

// Here you can include some "default" settings
iziToast.settings({
  close: true,
  pauseOnHover: false,
  timeout: 5000,
  progressBar: true,
  layout: 2
})
// and export it
export default function install () {
  Object.defineProperties(Vue.prototype, {
    $iziToast: {
      get () {
        return iziToast
      }
    }
  })
}