<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    /*
     * View Patient
     */
    export default {
        page: {
            title: "View Patient",
            meta: [{
                name: "description"
            }]
        },
        components: {
            Layout,
            PageHeader,
        },
        data() {
            return {
                name: 'View Patient',
                title: "View Patient",
                items: [{
                    text: "Patients",
                    href: "/patients"
                }],
                editLink: "patients/edit/",
                form: {
                    surname: "",
                    name: "",
                    email: "",
                    gender: "",
                    phone: "",
                    dob: "",
                    password: "",
                    email_verified: 0,
                    avatar: null,
                },
                errors: null,
                submitted: false,
                pending: false,
                currrentEntity: {},
                old_avatar: null,
            };
        },
        methods: {
            
            findInDoctorMedia(attr){             
                this.currrentEntity[attr] = null;
                return this._.find(this.currrentEntity.media, {attribute:attr});
            },

            async getCurrentEntity() {
                let that = this;
                that.pending = true;
                await that.axios.get(that.editLink + this.$route.params.id).then(function(response){
                    
                    that.currrentEntity = response.data;

                    that.currrentEntity.email_verified = that.currrentEntity.email_verified_at?.trim().length > 0 ? 1 : 0;

                    that.old_avatar = that.findInDoctorMedia('avatar');
                    
                    that.form = that.currrentEntity;

                    that.pending = false;
                });
            },

        },
        created() {
            this.pending = true;
            this.axios.all([
                this.getCurrentEntity()
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

                        <form class="needs-validation" >

                            <fieldset :disabled="true">

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="surname">Surname</label>
                                            <input type="text" v-model="form.surname" class="form-control" placeholder="Enter surname" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" v-model="form.name" class="form-control" placeholder="Enter Name" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email">Email *</label>
                                            <input type="text" v-model="form.email" class="form-control" id="email" placeholder="Enter Email" />

                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="phone">Phone *</label>
                                            <input 
                                                id="phone" type="text" v-model="form.phone" class="form-control" placeholder="Enter phone" />
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_phone">Created at</label>
                                            <input v-model="form.created_at" type="text" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_phone">Updated at</label>
                                            <input v-model="form.updated_at" type="text" class="form-control"/>
                                        </div>

                                        <div class="custom-control custom-checkbox isActiveCheck">
                                            <input v-model="form.email_verified" type="checkbox" class="custom-control-input" id="email_verified" />
                                            <label class="custom-control-label" for="email_verified">Email Verified</label>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        
                                        <div class="form-group mb-3" v-if="old_avatar != null">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a :href="old_avatar.fullpath" target="_blank">
                                                        <b-img :src="old_avatar.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Gender</label>
                                            <select
                                                v-model="form.gender"
                                                class="custom-select form-control">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="datepicker-dateformat2">Date of birth</label>
                                            <b-form-datepicker
                                                id="datepicker-dateformat2"
                                                v-model="form.dob"
                                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                locale="en"
                                                :hide-header="true"
                                            ></b-form-datepicker>
                                        </div>


                                    </div>

                                </div>
                                <!-- row -->

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </Layout>
</template>
