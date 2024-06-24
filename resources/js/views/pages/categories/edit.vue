<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required } from "vuelidate/lib/validators";
    /*
     * Edit Category
     */
    export default {
        page: {
            title: "Edit Category",
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
                name: 'Edit Category',
                title: "Edit Category",
                items: [{
                    text: "Categories",
                    href: "/categories"
                }],
                postLink: "categories/update/",
                editLink: "categories/edit/",
                form: {
                    name: "",
                    parent_id: "",
                },
                errors: null,
                submitted: false,
                pending: false,
                currrentEntity: {},
                image: null,
                old_image: ''
            };
        },
        validations: {
            form: {
                name: { required },
            }
        },
        methods: {

            findInMedia(attr){
                return this._.find(this.currrentEntity.media, {attribute:attr});
            },

            askBeforDelete(id, attr){
                let that = this;
                that.$swal.fire({
                    title: 'Confirm Delete',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#34c38f',
                    confirmButtonColor: '#f46a6a',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        that.deleteItem(id, attr);
                    }
                })
            },

            async deleteItem(id, attr){
                let that = this;
                that.pending = true;
                await that.axios.post("categories/delete-media/" + id)
                .then(function () {
                    that['old_' + attr] = null;
                    that.$iziToast.success({message: 'Deleted Succesfully', position: 'bottomCenter', timeout: 3000});
                    that.pending = false;
                });
            },

            async getCurrentEntity() {
                let that = this;
                await that.axios.get(that.editLink + this.$route.params.id).then(function(response){
                    that.currrentEntity = response.data;
                    that.form.name = that.currrentEntity.name;
                    that.form.parent_id = that.currrentEntity.parent_id;
         
                    if(that.currrentEntity.image != null ) that.old_image = that.findInMedia('image');
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
                    
                    // for files only
                    if(that.image != null && that.image != '') formData.append('image', that.image);
                    
                    await that.axios.post(that.postLink + that.$route.params.id, formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Updated Succesfully', position: 'bottomCenter'});
                        that.$router.push({ name: 'Categories'});
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
                                        
                                        <div class="form-group mb-3" v-if="form.parent_id == null && form.parent_id != ''">
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

                                        <div class="form-group mb-3" v-if="old_image != null && old_image != ''">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <a :href="old_image.fullpath" target="_blank">
                                                        <b-img :src="old_image.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3 d-flex">
                                                    <b-button 
                                                        @click="askBeforDelete(old_image.id, 'image')" 
                                                        class="mt-auto" variant="outline-primary"
                                                    >Delete</b-button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

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

