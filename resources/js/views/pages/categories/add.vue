<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required } from "vuelidate/lib/validators";
    /*
     * Add Category
     */
    export default {
        page: {
            title: "Add Category",
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
                name: 'Add Category',
                title: "Add Category",
                items: [{
                    text: "Categories",
                    href: "/categories"
                }],
                postLink: "categories/add",
                form: {
                    name: "",
                    parent: "",
                },
                errors: null,
                submitted: false,
                pending: false,
                parentCategries: [],
                image: null,
            };
        },
        validations: {
            form: {
                name: { required },
            }
        },
        methods: {
            async getExtra() {
                let that = this;
                that.pending = true;
                await that.axios.get("categories/extra")
                .then(function (response) {
                    that.pending = false;
                    that.parentCategries = response.data.parent_categries;
                });
            },

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

                    // for files only
                    if(that.image) formData.append('image', that.image);
                    
                    await that.axios.post(that.postLink, formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Created Succesfully', position: 'bottomCenter'});
                        that.$router.push({ name: 'Categories'});
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
            this.pending = true;
            this.axios.all([
                this.getExtra(),
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

                        <form class="needs-validation" @submit.prevent="create">

                            <fieldset :disabled="submitted || pending">

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="name">Name *</label>
                                            <input type="text" v-model="form.name" class="form-control"
                                                placeholder="Enter Name" :class="{ 'is-invalid': $v.form.name.$error }" />
                                            <div v-if="!$v.form.name.required" class="invalid-feedback">Name is required</div>
                                        </div>

                                        <div class="form-group mb-3" v-if="form.parent.length === 0">
                                            <label for="image">Image</label>
                                            <b-form-file 
                                                v-model="image"
                                                accept=".jpeg, .jpg, .png"
                                                placeholder="Choose a image or drop it here..."
                                                drop-placeholder="Drop image here..."
                                            ></b-form-file>
                                        </div>
                                        
                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label>Parent</label>
                                            <select
                                                v-model="form.parent"
                                                class="custom-select form-control">
                                                <option value="">No Parent</option>
                                                <option
                                                    :value="category.id"
                                                    v-for="category in parentCategries"
                                                    :key="category.id"
                                                >
                                                    {{ category.name }}
                                                </option>
                                            </select>
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
