<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { permissions_categories } from "./data";
    /*
     * View Admin
     */
    export default {
        page: {
            title: "View Admin",
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
                name: 'View Admin',
                title: "View Admin",
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
                permissions_categories: permissions_categories
            };
        },
        methods: {
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
            async getCurrentAdmin() {
                let that = this;
                await that.axios.get('admins/edit/'+this.$route.params.id).then(function(response){
                    that.currrentAdmin = response.data.admin;
                    that.currrentAdmin['permissions'] = response.data.permissions;
                    that.form = that.currrentAdmin;
                    that.form.password = ''; // don't remove this
                });
            },
            async getPermissionsList() {
                let that = this;
                await that.axios.get("permissions").then(function (response) {
                    that.permissionsList = response.data.permissions;
                });
            }
        },
        created() {            
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

                        <form class="needs-validation">

                            <fieldset disabled="true">

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" v-model="form.name" class="form-control" id="name" />
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" v-model="form.email" class="form-control" id="email" />
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="mobile_phone">Created at</label>
                                            <input v-model="form.created_at" type="text" class="form-control"/>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="mobile_phone">Mobile</label>
                                            <input v-model="form.mobile_phone" type="text" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_phone">Updated at</label>
                                            <input v-model="form.updated_at" type="text" class="form-control"/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
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
                                        
                                        <div class="custom-control custom-checkbox">
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

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </Layout>
</template>
