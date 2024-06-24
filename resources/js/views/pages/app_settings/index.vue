<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required, decimal } from "vuelidate/lib/validators";
    /*
     * App Settings
     */
    export default {
        page: {
            title: "Settings",
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
                name: 'App Settings',
                title: "Settings",
                items: [],
                form: {
                    commission: "",
                },
                app_settings: {},
                errors: null,
                submitted: false,
                pending: false,
            };
        },
        validations: {
            form: {
                commission: {required, decimal},
            }
        },
        methods: {
            async getAppSettings() {
                let that = this;
                that.pending = true;
                await that.axios.get("app_settings").then(function (response) {
                    that.pending = false;
                    that.app_settings = response.data;
                    that.form.commission = that.app_settings.commission;
                });
            },
            async updateEntity(){
                
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
                    
                    await that.axios.post('app_settings', formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Updated Succesfully', position: 'bottomCenter'});
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
        created() {
            // this.getAppSettings();
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

                        <form class="needs-validation" @submit.prevent="updateEntity">

                            <fieldset :disabled="submitted || pending">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group mb-3">
                                            <label for="commission">Commission *</label>
                                            <input type="text" v-model="form.commission" class="form-control"
                                                placeholder="Enter Commission" :class="{ 'is-invalid': $v.form.commission.$error }" />
                                            <div v-if="!$v.form.commission.required" class="invalid-feedback">Commission is required</div>
                                            <div v-if="!$v.form.commission.decimal" class="invalid-feedback">Commission must be a decimal value</div>
                                        </div>

                                    </div>
                                    <!-- col-sm-12 -->

                                </div>
                                <!-- row -->

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