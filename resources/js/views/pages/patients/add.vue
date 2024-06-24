<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required, email, minLength } from "vuelidate/lib/validators";
    /*
     * Add Patient
     */
    export default {
        page: {
            title: "Add Patient",
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
                name: 'Add Patient',
                title: "Add Patient",
                items: [{
                    text: "Patients",
                    href: "/patients"
                }],
                postLink: "patients/add",
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
            };
        },
        validations: {
            form: {
                email: { required, email },
                phone: { required },
                password: { required, minLength: minLength(6) },
            }
        },
        methods: {
            async create(){
                
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
                    
                    await that.axios.post(that.postLink, formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Created Succesfully', position: 'bottomCenter'});
                        that.$router.push({ name: 'Patients'});
                    })
                    .catch(function(error){
                        that.submitted = false;
                        if (error.response) {
                            that.errors = error.response.data.errors;
                            window.scrollTo(0,0);
                        }
                    });
                }
            },
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

                        <form class="needs-validation" @submit.prevent="create">

                            <fieldset :disabled="submitted || pending">

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
                                            <input type="text" v-model="form.email" class="form-control" id="email"
                                                placeholder="Enter Email" :class="{ 'is-invalid': $v.form.email.$error }" />
                                            <div v-if="$v.form.email.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.email.required">Email is required</span>
                                                <span v-if="!$v.form.email.email">Not a valid email address.</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="phone">Phone *</label>
                                            <input 
                                                id="phone" type="text" v-model="form.phone" 
                                                class="form-control" placeholder="Enter phone" 
                                                :class="{ 'is-invalid': $v.form.phone.$error }" />
                                            <div v-if="!$v.form.phone.required" class="invalid-feedback">Phone is required</div>
                                        </div>

                                        <div class="custom-control custom-checkbox isActiveCheck">
                                            <input v-model="form.email_verified" type="checkbox" class="custom-control-input" id="email_verified" />
                                            <label class="custom-control-label" for="email_verified">Email Verified</label>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                  
                                        <div class="form-group mb-3">
                                            <label for="avatar">Avatar</label>
                                            <b-form-file 
                                                v-model="form.avatar"
                                                accept=".jpeg, .jpg, .png"
                                                placeholder="Choose a image or drop it here..."
                                                drop-placeholder="Drop image here..."
                                            ></b-form-file>
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

                                        <div class="form-group mb-3">
                                            <label for="password">Password</label>
                                            <input 
                                                type="text" v-model="form.password" 
                                                class="form-control" placeholder="Enter password" 
                                                :class="{ 'is-invalid': $v.form.password.$error }" />
                                            <div v-if="$v.form.password.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.password.required">Password is required</span>
                                                <span v-if="!$v.form.password.minLength">Password min length is 6.</span>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- row -->

                                <div class="col-lg-12 mt-4 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                        <span v-show="submitted || pending" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span v-show="!submitted && !pending">Save</span>    
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
