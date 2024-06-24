<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required } from "vuelidate/lib/validators";
    /*
     * Edit Tags
     */
    export default {
        page: {
            title: "Edit Tags",
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
                name: 'Edit Tags',
                title: "Edit Tags",
                items: [{
                    text: "Tags",
                    href: "/tags"
                }],
                postLink: "tags/update/",
                editLink: "tags/edit/",
                form: {
                    name: "",
                    type: "",
                },
                errors: null,
                submitted: false,
                pending: false,
                currrentEntity: {},
                typeOptions: ['creative_account','business_account'],
            };
        },
        validations: {
            form: {
                name: { required },
                type: { required },
            }
        },
        methods: {

            async getCurrentEntity() {
                let that = this;
                await that.axios.get(that.editLink + this.$route.params.id).then(function(response){
                    that.currrentEntity = response.data;
                    that.form = that.currrentEntity;
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
                    
                    await that.axios.post(that.postLink + that.$route.params.id, formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Updated Succesfully', position: 'bottomCenter'});
                        that.$router.push({ name: 'Tags'});
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
            this.pending = true;
            this.axios.all([
                this.getCurrentEntity(),
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

                        <form class="needs-validation" @submit.prevent="updateEntity">

                            <fieldset :disabled="submitted || pending">

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="name">Name *</label>
                                            <input type="text" v-model="form.name" class="form-control"
                                                placeholder="Enter Name" :class="{ 'is-invalid': $v.form.name.$error }" />
                                            <div v-if="!$v.form.name.required" class="invalid-feedback">Name is required</div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="type">Type *</label>
                                            <select
                                                v-model="form.type"
                                                class="custom-select form-control" 
                                                :class="{ 'is-invalid': $v.form.type.$error }">
                                                <option disabled selected>Select Type</option>
                                                <option
                                                    :value="option"
                                                    v-for="option in typeOptions"
                                                    :key="option"
                                                >
                                                    {{ _.startCase(option) }}
                                                </option>
                                            </select>
                                            <div v-if="!$v.form.type.required" class="invalid-feedback">Type is required</div>
                                        </div>

                                    </div>
                                    <!-- col-sm-6 -->

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

