<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required } from "vuelidate/lib/validators";
    /*
     * Add Age Group
     */
    export default {
        page: {
            title: "Add Age Group",
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
                name: 'Add Age Group',
                title: "Add Age Group",
                items: [{
                    text: "Age Groups",
                    href: "/age-groups"
                }],
                postLink: "age_groups/add",
                form: {
                    from: "1",
                    to: "1",
                },
                errors: null,
                submitted: false,
                pending: false,
                fromArr: [],
                toArr: [],
            };
        },
        validations: {
            form: {
                from: { required },
                to: { required },
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
                        that.$router.push({ name: 'Age-Groups'});
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
        created(){
            this.fromArr = this._.range(1, 67);
            this.toArr = [...this._.range(1, 67), '+'];
        }
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
                                            <label>From *</label>
                                            <select
                                                v-model="form.from"
                                                class="custom-select form-control" 
                                                :class="{ 'is-invalid': $v.form.from.$error }">
                                                <option
                                                    :value="fromRange"
                                                    v-for="fromRange in fromArr"
                                                    :key="fromRange"
                                                >
                                                    {{ fromRange }}
                                                </option>
                                            </select>
                                            <div v-if="$v.form.from.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.from.required">From is required</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label>To *</label>
                                            <select
                                                v-model="form.to"
                                                class="custom-select form-control" 
                                                :class="{ 'is-invalid': $v.form.to.$error }">
                                                <option
                                                    :value="toRange"
                                                    v-for="toRange in toArr"
                                                    :key="toRange"
                                                >
                                                    {{ toRange }}
                                                </option>
                                            </select>
                                            <div v-if="$v.form.to.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.to.required">To is required</span>
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
