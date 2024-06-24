<script>
import { layoutComputed } from "@/state/helpers";
import {mapActions} from 'vuex';
export default {
  props: {
    type: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: true,
    },
  },
  computed: {
    ...layoutComputed,
    notifications: {
        get() { return this.$store.state.notifications; },
        set(value) { this.$parent.$emit("ReadNotification", value) },
    },
    currentRouteName() {
        return this.$route.name;
    },
    logo_url(){
      return window.location.origin + '/images/logo-light.png';
    }
  },
  data() {
    return {
      layoutColor: 'white',
      userName: '',
    };
  },
  methods: {
    switchLayout(layoutColor){
      localStorage.setItem('layoutColor', layoutColor);
      location.reload();
    },
    initFullScreen() {
      document.body.classList.toggle("fullscreen-enable");
      if (
        !document.fullscreenElement &&
        /* alternative standard method */ !document.mozFullScreenElement &&
        !document.webkitFullscreenElement
      ) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(
            Element.ALLOW_KEYBOARD_INPUT
          );
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    },
    toggleRightSidebar() {
      this.$parent.toggleRightSidebar();
    },
    toggleMenu() {
      let element = document.getElementById("topnav-menu-content");
      element.classList.toggle("show");
    },
    ...mapActions({
        signOut:"auth/logout"
    }),
    async logout(){
        await this.axios.post('/logout').then(({data})=>{
            this.signOut()
            this.$router.push({name:"login"})
        })
    },

  },
  created() {
    this.layoutColor = localStorage.getItem('layoutColor');
    this.userName = this.$store.state.auth.user.name;
  },
  mounted(){

  },
  watch: {
    type: {
      immediate: true,
      handler(newVal, oldVal) {
        if (newVal !== oldVal) {
          switch (newVal) {
            case "dark":
              document.body.setAttribute("data-topbar", "dark");
              break;
            case "light":
              document.body.setAttribute("data-topbar", "light");
              document.body.removeAttribute("data-layout-size", "boxed");
              break;
            case "colored":
              document.body.setAttribute("data-topbar", "colored");
              document.body.removeAttribute("data-layout-size", "boxed");
              break;
            default:
              document.body.setAttribute("data-topbar", "dark");
              break;
          }
        }
      },
    },
    width: {
      immediate: true,
      handler(newVal, oldVal) {
        if (newVal !== oldVal) {
          switch (newVal) {
            case "boxed":
              document.body.setAttribute("data-layout-size", "boxed");
              break;
            case "fluid":
              document.body.setAttribute("data-layout-mode", "fluid");
              document.body.removeAttribute("data-layout-size");
              break;
            default:
              document.body.setAttribute("data-layout-mode", "fluid");
              break;
          }
        }
      },
    },
  },
};
</script>

<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <router-link to="/" class="logo logo-dark">
            <span class="logo-sm">
              <img :src="logo_url" height="22" >
            </span>
            <span class="logo-lg">
              <img :src="logo_url" alt height="35" />
            </span>
          </router-link>

          <router-link to="/" class="logo logo-light">
            <span class="logo-sm">
              <img :src="logo_url"  alt height="22" />
            </span>
            <span class="logo-lg">
              <img :src="logo_url"  alt height="35" />
            </span>
          </router-link>
        </div>

        <button
          type="button"
          class="btn btn-sm px-3 font-size-24 d-lg-none header-item"
          data-toggle="collapse"
          @click="toggleMenu"
        >
          <i class="ri-menu-2-line align-middle"></i>
        </button>

      </div>

      <div class="d-flex">

        <div class="dropdown d-lg-inline-block ml-1" v-if="layoutColor == 'dark'">
          <button
            type="button"
            title="Light Mode"
            class="btn header-item noti-icon waves-effect"
            @click="switchLayout('white')"
          >
             <i class="ri-sun-line"></i>
          </button>
        </div>

        <div class="dropdown d-lg-inline-block ml-1" v-if="layoutColor != 'dark'">
          <button
            title="Dark Mode"
            type="button"
            class="btn header-item noti-icon waves-effect"
            @click="switchLayout('dark')"
          >
             <i class="ri-moon-fill"></i>
          </button>
        </div>

        <div class="dropdown  d-lg-inline-block ml-1">
          <button
            type="button"
            title="fullscreen"
            class="btn header-item noti-icon waves-effect"
            data-toggle="fullscreen"
            @click="initFullScreen"
          >
            <i class="ri-fullscreen-line"></i>
          </button>
        </div>

        <b-dropdown
          right
          variant="black"
          toggle-class="header-item"
          class="d-inline-block user-dropdown"
        >
          <template v-slot:button-content>
            <span class=" d-xl-inline-block ml-1">{{ userName }}</span>
            <i class="mdi mdi-chevron-down  d-xl-inline-block"></i>
          </template>
          <!-- item-->
          <button type="button" class="dropdown-item text-danger"  @click="logout">
            <i class="ri-shut-down-line align-middle mr-1 text-danger"></i>
            logout
          </button>
        </b-dropdown>

<!--
        <div class="dropdown d-inline-block">
          <button
          title="Design Settings"
            type="button"
            class="btn header-item noti-icon right-bar-toggle waves-effect toggle-right"
            @click="toggleRightSidebar"
          >
            <i class="ri-settings-2-line toggle-right"></i>
          </button>
        </div> -->
      </div>
    </div>
  </header>
</template>
