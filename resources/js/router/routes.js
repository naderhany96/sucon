export default [
    {
        path: "/login",
        name: "login",
        meta: { middleware: "guest" },
        component: () => import("../views/pages/auth/login.vue"),
    },

    {
        path: "/",
        name: "home",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/dashboard/index.vue"),
    },

    {
        path: "/admins",
        name: "Admins",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/admin/index.vue"),
    },
    {
        path: "/add-admin",
        name: "Add-Admin",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/admin/add-admin.vue"),
    },
    {
        path: "/edit-admin/:id/",
        name: "Edit-Admin",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/admin/edit-admin.vue"),
    },
    {
        path: "/view-admin/:id/",
        name: "View-Admin",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/admin/view-admin.vue"),
    },

    {
        path: "/doctors",
        name: "Doctors",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/index.vue"),
    },
    {
        path: "/add-doctor",
        name: "Add-Doctor",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/add.vue"),
    },
    {
        path: "/edit-slot/:id/",
        name: "Edit-Slot",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/edit-slot.vue"),
    },
    {
        path: "/edit-doctor/:id/",
        name: "Edit-Doctor",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/edit.vue"),
    },
    {
        path: "/view-doctor/:id/",
        name: "View-Doctor",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/view.vue"),
    },

    //doctor groups
    {
        path: "/doctor/groups/:id/",
        name: "DoctorGroups",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/groups/index.vue"),
    },
    {
        path: "/doctor/groups/add/:id",
        name: "Add-Doctor-Group",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/groups/add.vue"),
    },
    {
        path: "/doctor/groups/edit/:id/",
        name: "Edit-Doctor-Group",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/groups/edit.vue"),
    },
    {
        path: "/doctor/groups/view/:id/",
        name: "View-Doctor-Group",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/doctors/groups/view.vue"),
    },

    {
        path: "/patients",
        name: "Patients",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/patients/index.vue"),
    },
    {
        path: "/add-patient",
        name: "Add-Patient",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/patients/add.vue"),
    },
    {
        path: "/edit-patient/:id/",
        name: "Edit-Patient",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/patients/edit.vue"),
    },
    {
        path: "/view-patient/:id/",
        name: "View-Patient",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/patients/view.vue"),
    },

    {
        path: "/qualifications",
        name: "Qualifications",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/qualifications/index.vue"),
    },
    {
        path: "/add-qualification",
        name: "Add-Qualification",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/qualifications/add.vue"),
    },
    {
        path: "/edit-qualification/:id/",
        name: "Edit-Qualification",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/qualifications/edit.vue"),
    },
    {
        path: "/view-qualification/:id/",
        name: "View-Qualification",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/qualifications/view.vue"),
    },

    {
        path: "/specialties",
        name: "Specialties",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/specialties/index.vue"),
    },
    {
        path: "/add-specialty",
        name: "Add-Specialty",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/specialties/add.vue"),
    },
    {
        path: "/edit-specialty/:id/",
        name: "Edit-Specialty",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/specialties/edit.vue"),
    },
    {
        path: "/view-specialty/:id/",
        name: "View-Specialty",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/specialties/view.vue"),
    },

    {
        path: "/age-groups",
        name: "Age-Groups",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/age_groups/index.vue"),
    },
    {
        path: "/add-age-group",
        name: "Add-Age-Group",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/age_groups/add.vue"),
    },
    {
        path: "/edit-age-group/:id/",
        name: "Edit-Age-Group",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/age_groups/edit.vue"),
    },
    {
        path: "/view-age-group/:id/",
        name: "View-Age-Group",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/age_groups/view.vue"),
    },

    {
        path: "/working-styles",
        name: "Working-Styles",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/working_styles/index.vue"),
    },
    {
        path: "/add-working-style",
        name: "Add-Working-Style",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/working_styles/add.vue"),
    },
    {
        path: "/edit-working-style/:id/",
        name: "Edit-Working-Style",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/working_styles/edit.vue"),
    },
    {
        path: "/view-working-style/:id/",
        name: "View-Working-Style",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/working_styles/view.vue"),
    },

    {
        path: "/speaking-languages",
        name: "Speaking-Languages",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/speaking_languages/index.vue"),
    },
    {
        path: "/add-speaking-language",
        name: "Add-Speaking-Language",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/speaking_languages/add.vue"),
    },
    {
        path: "/edit-speaking-language/:id/",
        name: "Edit-Speaking-Language",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/speaking_languages/edit.vue"),
    },
    {
        path: "/view-speaking-language/:id/",
        name: "View-Speaking-Language",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/speaking_languages/view.vue"),
    },
    {
        path: "/sessions",
        name: "Sessions",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/sessions/index.vue"),
    },
    {
        path: "/add-session",
        name: "Add-Session",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/sessions/add.vue"),
    },
    {
        path: "/edit-session/:id/",
        name: "Edit-Session",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/sessions/edit.vue"),
    },
    {
        path: "/view-session/:id/",
        name: "View-Session",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/sessions/view.vue"),
    },

    {
        path: "/categories",
        name: "Categories",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/categories/index.vue"),
    },
    {
        path: "/add-category",
        name: "Add-Category",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/categories/add.vue"),
    },
    {
        path: "/edit-category/:id/",
        name: "Edit-Category",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/categories/edit.vue"),
    },
    {
        path: "/view-category/:id/",
        name: "View-Category",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/categories/view.vue"),
    },

    // Settings
    {
        path: "/app_settings",
        name: "App Settings",
        meta: { middleware: "auth" },
        component: () => import("../views/pages/app_settings/index.vue"),
    },
];
