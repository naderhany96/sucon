<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required, email } from "vuelidate/lib/validators";
    import { permissions_categories } from "./data";
    /*
     * Edit Admin
     */
    export default {
        page: {
            title: "Edit Admin",
            meta: [{
                name: "description"
            }]
        },
        components: {
            Layout,
            PageHeader
        },
        data() {
            return {
                name: 'Edit Admin',
                title: "Edit Admin",
                items: [{
                    text: "Admins",
                    href: "/admins"
                }],
                form: {
                    name: "",
                    email: "",
                    mobile_phone: "",
                    password: "",
                    isActive: 0,
                    permissions: [],
                },
                errors: null,
                submitted: false,
                pending: false,
                permissionsList: [],
                select_all_permissions: false,
                currrentAdmin: {},
                authUser: {},
                permissions_categories: permissions_categories
            };
        },
        validations: {
            form: {
                email: { required, email },
                name: { required },
                mobile_phone: { required },
            }
        },
        methods: {
            async getCurrentAdmin() {
                let that = this;
                await that.axios.get('admins/edit/'+this.$route.params.id)
                .then(function(response){
                    that.currrentAdmin = response.data.admin;
                    that.currrentAdmin['permissions'] = response.data.permissions;
                    that.form = that.currrentAdmin;
                    that.form.password = ''; // don't remove this
                });
            },
            selectAll(){
                let selected = [];
                this.select_all_permissions = !this.select_all_permissions;
                if (this.select_all_permissions == 1 || this.select_all_permissions == true) {
                    this.permissionsList.forEach(function (permission) {
                        selected.push(permission);
                    })
                }
                this.form.permissions = selected;
            },
            unSelectAll(){
                if (this.form.permissions.length === this.permissionsList.length) {
                    this.select_all_permissions = false;
                }
            },
            async getPermissionsList() {
                let that = this;
                await that.axios.get("permissions").then(function (response) {
                    that.permissionsList = response.data.permissions;
                });
            },
            async updateUser(){
                
                let that = this;
                that.$v.$touch();

                if (that.$v.$invalid) {
                    window.scrollTo(0,0);
                    return;
                } else {

                    that.submitted = true;
                    let formData = new FormData();

                    for (const key in that.form) {
                        formData.append(key, that.form[key]);
                    }
                    
                    await that.axios.post( 'admins/update/'+that.$route.params.id, formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Updated Succesfully', position: 'bottomCenter'});
                        that.$router.push({ name: 'Admins'});
                    }).catch(function(error){
                        that.submitted = false;
                        if (error.response) {
                            that.errors = error.response.data.errors;
                            window.scrollTo(0,0);
                        }
                    });
                }
            },
        },
        created() {
            this.authUser = this.$store.getters['auth/user'];
            this.pending = true;
            this.axios.all([
                this.getPermissionsList(),
                this.getCurrentAdmin()
            ]).finally(() => this.pending = false );
        },
    };

</script>

<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-12">
                <div class="card" id="error_area">
                    <div class="card-body">

                        <FormValidation :errors="errors" />

                        <form class="needs-validation" @submit.prevent="updateUser">

                            <fieldset :disabled="submitted || pending">

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="name">Name *</label>
                                            <input type="text" v-model="form.name" class="form-control"
                                                placeholder="Enter Name" :class="{ 'is-invalid': $v.form.name.$error }" />
                                            <div v-if="!$v.form.name.required" class="invalid-feedback">Name is required</div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="email">Email *</label>
                                            <input type="text" v-model="form.email" class="form-control" id="email"
                                                placeholder="Enter Email" :class="{ 'is-invalid': $v.form.email.$error }" />
                                            <div v-if="$v.form.email.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.email.required">Email is required</span>
                                                <span v-if="!$v.form.email.email">Not a valid email address.</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="userpassword">Password *</label>
                                            <input v-model="form.password" type="text" class="form-control" id="userpassword"
                                                placeholder="Enter new Password"/>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="mobile_phone">Mobile *</label>
                                            <input v-model="form.mobile_phone" type="text" class="form-control" id="mobile_phone"
                                                placeholder="Enter Mobile" :class="{ 'is-invalid': $v.form.mobile_phone.$error }" />
                                            <div v-if="!$v.form.mobile_phone.required" class="invalid-feedback">Mobile required</div>
                                        </div>

                                    </div>
                                    
                                    <div class="col-sm-12" v-if="$can('active_admin')">
                                        <div class="custom-control custom-checkbox isActiveCheck">
                                            <input v-model="form.isActive" type="checkbox" class="custom-control-input" id="isActive" />
                                            <label class="custom-control-label" for="isActive">Active</label>
                                        </div>
                                    </div>

                                </div>
                                <!-- row -->

                                <div class="row" v-if="$can('admin_permissions') && permissionsList.length > 0">

                                    <div class="col-lg-12">

                                        <hr>

                                        <h6 class="mt-0"><strong>Permissions</strong></h6>
                                        
                                        <div class="mt-3 custom-control custom-checkbox">
                                            <input 
                                                @click="selectAll" 
                                                type="checkbox" 
                                                class="custom-control-input" 
                                                id="select_all" 
                                                :checked="form.permissions.length === permissionsList.length"  />
                                            <label class="custom-control-label" for="select_all" >All</label>
                                        </div>

                                        <div class="mt-2 admin_permissions">

                                            <b-tabs no-fade content-class="p-3 text-muted">

                                                <div v-for="apermission in permissions_categories" :key="apermission.section_name">

                                                    <b-tab class="border-0" :title="apermission.section_name">

                                                        <div class="row">

                                                            <template v-for="(permission, index) in apermission" >
                                                             
                                                                <div
                                                                    v-if="index != 'section_name'" :key="permission"
                                                                    class="col-md-3 custom-control custom-checkbox mb-2">
                                                                    
                                                                    <input 
                                                                        v-model="form.permissions" 
                                                                        type="checkbox" 
                                                                        class="custom-control-input" 
                                                                        :value="index" :id="index"
                                                                        @click="unSelectAll"  
                                                                    />
                                                                    <label
                                                                        class="custom-control-label" 
                                                                        :for="index"
                                                                    >
                                                                        {{ permission }}
                                                                    </label>
                                                                </div>
                                                              
                                                            </template>

                                                        </div>

                                                    </b-tab>

                                                </div>

                                            </b-tabs>
                                        
                                        </div>
                                    </div>
                                    <!-- col-lg-12 -->
                                </div>

                                <div class="col-lg-12 mt-4 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                        <span v-show="submitted || pending" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span v-show="!submitted && !pending">Update</span>
                                    </button>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </Layout>
</template>

