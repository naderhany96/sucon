<script>
import { VueSimplebar } from "vue-simplebar";
import {
    layoutComputed
} from "@/state/helpers";

import MetisMenu from "metismenujs/dist/metismenujs";

import {
    menuItems
} from "./menu";

export default {
    components: {
        VueSimplebar,
    },
    props: {
        isCondensed: {
            type: Boolean,
            default: false,
        },
        type: {
            type: String,
            required: true,
        },
        width: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            menuItems: menuItems,
        };
    },
    computed: {
        ...layoutComputed,
    },
    mounted: function () {
        // eslint-disable-next-line no-unused-vars
        var menuRef = new MetisMenu("#side-menu");
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
                parent.classList.add("mm-active");
                const parent2 = parent.parentElement.closest("ul");
                if (parent2 && parent2.id !== "side-menu") {
                    parent2.classList.add("mm-show");

                    const parent3 = parent2.parentElement;
                    if (parent3) {
                        parent3.classList.add("mm-active");
                        var childAnchor = parent3.querySelector(".has-arrow");
                        var childDropdown = parent3.querySelector(".has-dropdown");
                        if (childAnchor) childAnchor.classList.add("mm-active");
                        if (childDropdown) childDropdown.classList.add("mm-active");

                        const parent4 = parent3.parentElement;
                        if (parent4 && parent4.id !== "side-menu") {
                            parent4.classList.add("mm-show");
                            const parent5 = parent4.parentElement;
                            if (parent5 && parent5.id !== "side-menu") {
                                parent5.classList.add("mm-active");
                                const childanchor = parent5.querySelector(".is-parent");
                                if (childanchor && parent5.id !== "side-menu") {
                                    childanchor.classList.add("mm-active");
                                }
                            }
                        }
                    }
                }
            }
        }
    },
    methods: {
        /**
         * Returns true or false if given menu item has child or not
         * @param item menuItem
         */
        hasItems(item) {
            return item.subItems !== undefined ? item.subItems.length > 0 : false;
        },
        onRoutechange() {
            setTimeout(() => {
                let currentPositionEle = document.getElementsByClassName("mm-active")[0];
                const currentPosition = currentPositionEle !== undefined ? currentPositionEle.offsetTo : 0;
                if (currentPosition > 400)
                    this.$refs.currentMenu.SimpleBar.getScrollElement().scrollTop =
                        currentPosition + 200;
            }, 300);
        },
    },
    watch: {
        $route: {
            handler: "onRoutechange",
            immediate: true,
            deep: true,
        },
        type: {
            immediate: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "dark":
                            document.body.setAttribute("data-sidebar", "dark");
                            document.body.removeAttribute("data-topbar");
                            document.body.removeAttribute("data-sidebar-size");
                            break;
                        case "light":
                            document.body.setAttribute("data-topbar", "dark");
                            document.body.removeAttribute("data-sidebar");
                            document.body.removeAttribute("data-sidebar-size");
                            document.body.classList.remove("vertical-collpsed");
                            break;
                        case "compact":
                            document.body.setAttribute("data-sidebar-size", "small");
                            document.body.setAttribute("data-sidebar", "dark");
                            document.body.classList.remove("vertical-collpsed");
                            document.body.removeAttribute("data-topbar", "dark");
                            break;
                        case "icon":
                            document.body.setAttribute("data-keep-enlarged", "true");
                            document.body.classList.add("vertical-collpsed");
                            document.body.setAttribute("data-sidebar", "dark");
                            document.body.removeAttribute("data-topbar", "dark");
                            break;
                        case "colored":
                            document.body.setAttribute("data-sidebar", "colored");
                            document.body.removeAttribute("data-keep-enlarged");
                            document.body.classList.remove("vertical-collpsed");
                            document.body.removeAttribute("data-sidebar-size");
                            break;
                        default:
                            document.body.setAttribute("data-sidebar", "dark");
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
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
        <vue-simplebar @scroll-y-reach-end="100" class="h-100" id="my-element">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul id="side-menu" class="metismenu list-unstyled">
                    <li class="menu-title">Menu</li>
                    <li>
                        <router-link to="/" class="side-nav-link-ref">
                            <i class="mdi mdi-chart-bar"></i>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li v-if="$can('access_admin')">
                        <router-link to="/admins" class="side-nav-link-ref">
                            <i class="mdi mdi-account-group-outline"></i>
                            <span>Admins</span>
                        </router-link>
                    </li>
                    <li v-if="$can('access_doctor')">
                        <router-link to="/doctors" class="side-nav-link-ref">
                            <i class="mdi mdi-medical-bag"></i>
                            <span>Doctors</span>
                        </router-link>
                    </li>
                    <li v-if="$can('access_patient')">
                        <router-link to="/patients" class="side-nav-link-ref">
                            <i class="mdi mdi-account-group-outline"></i>
                            <span>Patients</span>
                        </router-link>
                    </li>

                    <li v-if="$can('access_qualification') ||
                        $can('access_specialty') ||
                        $can('access_age_group') ||
                        $can('access_working_style') ||
                        $can('access_speaking_language') ||
                        $can('access_category')
                        ">
                        <a href="javascript:void(0);" class="is-parent has-arrow" aria-expanded="false">
                            <i class="mdi mdi-account-cog-outline"></i>
                            <span>App Settings</span>
                        </a>
                        <ul aria-expanded="false" class="sub-menu mm-collapse">
                            <li v-if="$can('access_category')">
                                <router-link to="/categories" class="side-nav-link-ref">Categories</router-link>
                            </li>
                            <li v-if="$can('access_qualification')">
                                <router-link to="/qualifications" class="side-nav-link-ref">Qualifications</router-link>
                            </li>
                            <li v-if="$can('access_specialty')">
                                <router-link to="/specialties" class="side-nav-link-ref">Specialties</router-link>
                            </li>
                            <li v-if="$can('access_age_group')">
                                <router-link to="/age-groups" class="side-nav-link-ref">Age Groups</router-link>
                            </li>
                            <li v-if="$can('access_working_style')">
                                <router-link to="/working-styles" class="side-nav-link-ref">Working Styles</router-link>
                            </li>
                            <li v-if="$can('access_speaking_language')">
                                <router-link to="/speaking-languages" class="side-nav-link-ref">Speaking
                                    Languages</router-link>
                            </li>
                            <li v-if="$can('access_session')">
                                <router-link to="/sessions" class="side-nav-link-ref">Sessions</router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="$can('access_app')">
                        <a href="javascript:void(0);" class="is-parent has-arrow" aria-expanded="false">
                            <i class="ri-settings-4-line"></i>
                            <span>Settings</span>
                        </a>
                        <ul aria-expanded="false" class="sub-menu mm-collapse">
                            <li v-if="$can('access_app')">
                                <router-link to="/app_settings" class="side-nav-link-ref">App</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </vue-simplebar>
    </div>
    <!-- Left Sidebar End -->
</template>
