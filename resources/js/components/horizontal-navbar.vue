<script>
import { layoutMethods } from "@/state/helpers";
import { menuItems } from "./horizontal-menu";

export default {
  data() {
    return {
      menuItems: menuItems
    };
  },
  methods: {
    ...layoutMethods,

    /**
     * Menu clicked show the submenu
     */
    onMenuClick(event) {
      event.preventDefault();
      const nextEl = event.target.nextSibling;
      if (nextEl && !nextEl.classList.contains("show")) {
        const parentEl = event.target.parentNode;
        if (parentEl) {
          parentEl.classList.remove("show");
        }
        nextEl.classList.add("show");
      } else if (nextEl) {
        nextEl.classList.remove("show");
      }
      return false;
    },
    /**
     * Returns true or false if given menu item has child or not
     * @param item menuItem
     */
    hasItems(item) {
      return item.subItems !== undefined ? item.subItems.length > 0 : false;
    },
    change_layout(layout) {
      return this.changeLayoutType({ layoutType: layout });
    },
    topbarLight() {
      document.body.setAttribute("data-topbar", "light");
      document.body.removeAttribute("data-layout-size", "boxed");
    },
    boxedWidth() {
      document.body.setAttribute("data-layout-size", "boxed");
      document.body.removeAttribute("data-topbar", "light");
      document.body.setAttribute("data-topbar", "dark");
    }
  },
  mounted() {
    var links = document.getElementsByClassName("side-nav-link-ref");
    var matchingMenuItem = null;
    for (var i = 0; i < links.length; i++) {
      if (window.location.pathname === links[i].pathname) {
        matchingMenuItem = links[i];
        break;
      }
    }
    if (matchingMenuItem) {
      matchingMenuItem.classList.add("active");
      var parent = matchingMenuItem.parentElement;

      /**
       * TODO: This is hard coded way of expading/activating parent menu dropdown and working till level 3.
       * We should come up with non hard coded approach
       */
      if (parent) {
        parent.classList.add("active");
        const parent2 = parent.parentElement;
        if (parent2) {
          parent2.classList.add("active");
        }
        const parent3 = parent2.parentElement;
        if (parent3) {
          parent3.classList.add("active");
          var childAnchor = parent3.querySelector(".has-dropdown");
          if (childAnchor) childAnchor.classList.add("active");
        }

        const parent4 = parent3.parentElement;
        if (parent4) parent4.classList.add("active");
        const parent5 = parent4.parentElement;
        if (parent5) parent5.classList.add("active");
      }
    }
  },
};
</script>

<template>
  <div class="topnav">
    <div class="container-fluid">
      <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div class="collapse navbar-collapse" id="topnav-menu-content">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link to="/" class="nav-link side-nav-link-ref">
                  <i class="mdi mdi-chart-bar"></i>
                  <span>Dashboard</span>
              </router-link>
            </li>
            <li class="nav-item dropdown" 
              v-if="$can('access_admin') || 
                  $can('access_doctor') ||
                  $can('access_patient') 
              ">
              <a
                href="javascript: void(0);"
                aria-current="page"
                class="nav-link dropdown-toggle arrow-none"
              >
              <i class="mdi mdi-account-group-outline"></i>
                <span>Users</span>
              </a>
              <div aria-labelledby="topnav-dashboard" class="dropdown-menu row">
                <span v-if="$can('access_admin')">
                  <router-link to="/admins" class="col dropdown-item side-nav-link-ref">Admins</router-link>
                </span>
                <span v-if="$can('access_doctor')">
                  <router-link to="/doctors" class="col dropdown-item side-nav-link-ref">Doctors</router-link>
                </span>
                <span v-if="$can('access_patient')">
                  <router-link to="/patients" class="col dropdown-item side-nav-link-ref">Patients</router-link>
                </span>
              </div>
            </li>
            <li class="nav-item dropdown" 
              v-if="
                  $can('access_qualification') ||
                  $can('access_specialty') ||
                  $can('access_age_group') ||
                  $can('access_working_style') ||
                  $can('access_speaking_language') ||
                  $can('access_category')
              ">
              <a
                href="javascript: void(0);"
                aria-current="page"
                class="nav-link dropdown-toggle arrow-none"
              >
                <i class="mdi mdi-medical-bag"></i>
                <span>Doctor Options</span>
              </a>
              <div aria-labelledby="topnav-dashboard" class="dropdown-menu row">
                <span v-if="$can('access_category')">
                  <router-link to="/categories" class="col dropdown-item side-nav-link-ref">Categories</router-link>
                </span>
                <span v-if="$can('access_qualification')">
                  <router-link to="/qualifications" class="col dropdown-item side-nav-link-ref">Qualifications</router-link>
                </span>
                <span v-if="$can('access_specialty')">
                  <router-link to="/specialties" class="col dropdown-item side-nav-link-ref">Specialties</router-link>
                </span>
                <span v-if="$can('access_age_group')">
                  <router-link to="/age-groups" class="col dropdown-item side-nav-link-ref">Age Groups</router-link>
                </span>
                <span v-if="$can('access_working_style')">
                  <router-link to="/working-styles" class="col dropdown-item side-nav-link-ref">Working Styles</router-link>
                </span>
                <span v-if="$can('access_speaking_language')">
                  <router-link to="/speaking-languages" class="col dropdown-item side-nav-link-ref">Speaking Languages</router-link>
                </span>
              </div>
            </li>
            <li class="nav-item dropdown" v-if="$can('access_app')">
              <a
                href="javascript: void(0);"
                aria-current="page"
                class="nav-link dropdown-toggle arrow-none"
              >
                <i class="ri-settings-4-line"></i>
                <span>Settings</span>
              </a>
              <div aria-labelledby="topnav-dashboard" class="dropdown-menu row">
                <span v-if="$can('access_app')">
                  <router-link to="/app_settings" class="col dropdown-item side-nav-link-ref">App</router-link>
                </span>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>