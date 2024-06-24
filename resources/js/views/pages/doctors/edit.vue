<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import { required, email, numeric } from "vuelidate/lib/validators";
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    /*
     * Edit Doctor
     */
    export default {
        page: {
            title: "Edit Doctors",
            meta: [{
                name: "description"
            }]
        },
        components: {
            Layout,
            PageHeader,
            vSelect
        },
        data() {
            return {
                name: 'Edit Doctor',
                title: "Edit Doctor",
                items: [{
                    text: "Doctors",
                    href: "/doctors"
                }],
                postLink: "doctors/update/",
                editLink: "doctors/edit/",
                form: {
                    surname: "",
                    name: "",
                    email: "",
                    gender: "",
                    phone: "",
                    dob: "",
                    email_verified: 0,

                    price: "",
                    yoe: "",
                    about: "",

                    age_group_ids: [],
                    qualification_ids: [],
                    specialty_ids: [],
                    working_style_ids: [],
                    speaking_language_ids: [],
                    category_ids: [],

                },
                errors: null,
                submitted: false,
                pending: false,

                qualifications: [],
                specialties: [],
                ageGroups: [],
                workingStyles: [],
                speakingLanguages: [],
                categories: [],

                currrentEntity: {},
                old_avatar: null,
                old_video: null,
                old_passport: null,
                old_cover_image: null,
                old_license: null,

                avatar: null,
                video: null,
                passport: null,
                cover_image: null,
                license: null,
            };
        },
        validations: {
            form: {
                email: { required, email },
                phone: { required },
                price: { numeric },
                yoe: { numeric },
            }
        },
        methods: {
            changedValue() {
                this.$forceUpdate();
            },
            deselectedValue() {
                this.$forceUpdate();
            },

            findInMedia(attr){
                if(attr == 'avatar'){
                    this.currrentEntity[attr] = null;
                    return this._.find(this.currrentEntity.media, {attribute:attr});
                } else {
                    this.currrentEntity[attr] = null;
                    return this._.find(this.currrentEntity.doctor_profile.media, {attribute:attr});
                }
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
                await that.axios.post("doctors/delete-media/" + id)
                .then(function () {
                    that['old_' + attr] = null;
                    that.$iziToast.success({message: 'Deleted Succesfully', position: 'bottomCenter', timeout: 3000});
                    that.pending = false;
                });
            },

            async getExtra() {
                let that = this;
                that.pending = true;
                await that.axios.get("doctors/extra")
                .then(function (response) {
                    that.pending = false;
                    that.categories = response.data.categories;
                    that.specialties = response.data.specialties;
                    that.qualifications = response.data.qualifications;
                    that.ageGroups = response.data.age_groups;
                    that.workingStyles = response.data.working_styles;
                    that.speakingLanguages = response.data.speaking_languages; 
                });
            },

            async getCurrentEntity() {
                let that = this;
                that.pending = true;
                await that.axios.get(that.editLink + this.$route.params.id).then(function(response){
                    
                    that.currrentEntity = response.data;

                    that.form.surname = that.currrentEntity.surname;
                    that.form.name = that.currrentEntity.name;
                    that.form.gender = that.currrentEntity.gender;
                    that.form.phone = that.currrentEntity.phone;
                    that.form.dob = that.currrentEntity.dob
                    that.form.email = that.currrentEntity.email
                    ;
                    that.form.email_verified = that.currrentEntity.email_verified_at?.trim().length > 0 ? 1 : 0;

                    that.form.about = that.currrentEntity.doctor_profile.about;
                    that.form.price = that.currrentEntity.doctor_profile.price;
                    that.form.yoe = that.currrentEntity.doctor_profile.yoe;
                    
                    that.form.category_ids            = that._.map(that.currrentEntity.categories, 'id');
                    that.form.qualification_ids       = that._.map(that.currrentEntity.qualifications, 'id');
                    that.form.age_group_ids           = that._.map(that.currrentEntity.age_groups, 'id');
                    that.form.speaking_language_ids   = that._.map(that.currrentEntity.speaking_languages, 'id');
                    that.form.specialty_ids           = that._.map(that.currrentEntity.specialties, 'id');
                    that.form.working_style_ids       = that._.map(that.currrentEntity.working_styles, 'id');

                    that.old_avatar         = that.findInMedia('avatar');
                    that.old_video          = that.findInMedia('video');
                    that.old_passport       = that.findInMedia('passport');
                    that.old_cover_image    = that.findInMedia('cover_image');
                    that.old_license        = that.findInMedia('license');
                    
                    that.pending = false;
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
                    if(that.avatar) formData.append('avatar', that.avatar);
                    if(that.video) formData.append('video', that.video);
                    if(that.passport) formData.append('passport', that.passport);
                    if(that.cover_image) formData.append('cover_image', that.cover_image);
                    if(that.license) formData.append('license', that.license);
                    
                    await that.axios.post(that.postLink + that.$route.params.id, formData)
                    .then(function(){
                        that.submitted = false;
                        that.$iziToast.success({message: 'Updated Succesfully', position: 'bottomCenter'});
                        that.$router.push({ name: 'Doctors'});
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
                this.getExtra(),
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

                        <form class="needs-validation" @submit.prevent="updateEntity">

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
                                            <label for="price">Price</label>
                                            <input 
                                                type="text" v-model="form.price" 
                                                class="form-control" :class="{ 'is-invalid': $v.form.price.$error }"
                                                placeholder="Enter price" />
                                            <div v-if="$v.form.price.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.price.numeric">Price must be a numeric value</span>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="yoe">Years of experience</label>
                                            <input 
                                                type="text" v-model="form.yoe" 
                                                class="form-control" :class="{ 'is-invalid': $v.form.yoe.$error }"
                                                placeholder="Enter years of experience" />
                                            <div v-if="$v.form.yoe.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.yoe.numeric">Years of experience must be a numeric value</span>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name">About</label>
                                            <textarea
                                                v-model="form.about"
                                                class="form-control"
                                                placeholder="Enter about"
                                            ></textarea>
                                        </div>




                                    </div>

                                    <div class="col-sm-6">


                                        <div class="form-group mb-3" v-if="old_avatar != null">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <a :href="old_avatar.fullpath" target="_blank">
                                                        <b-img :src="old_avatar.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3 d-flex">
                                                    <b-button 
                                                        @click="askBeforDelete(old_avatar.id, 'avatar')" 
                                                        class="mt-auto" variant="outline-primary"
                                                    >Delete</b-button>
                                                </div>
                                            </div>
                                        </div>
                                        
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
                                            <label for="categories">Categories</label>
                                            <v-select
                                                multiple 
                                                v-on:option:selected="changedValue"
                                                v-on:option:deselected="deselectedValue"
                                                v-model="form.category_ids" 
                                                :options="categories"
                                                :reduce="categories => categories.id" 
                                                label="name" 
                                            >
                                            </v-select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="qualification">Qualifications</label>
                                            <v-select
                                                multiple 
                                                v-on:option:selected="changedValue"
                                                v-on:option:deselected="deselectedValue"
                                                v-model="form.qualification_ids" 
                                                :options="qualifications"
                                                :reduce="qualification => qualification.id" 
                                                label="name" 
                                            >
                                            </v-select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="specialty">Specialties</label>
                                            <v-select
                                                multiple 
                                                v-on:option:selected="changedValue"
                                                v-on:option:deselected="deselectedValue"
                                                v-model="form.specialty_ids" 
                                                :options="specialties"
                                                :reduce="specialty => specialty.id" 
                                                label="name" 
                                            >
                                            </v-select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="ageGroup">Age Groups</label>
                                            <v-select
                                                multiple 
                                                v-on:option:selected="changedValue"
                                                v-on:option:deselected="deselectedValue"
                                                v-model="form.age_group_ids" 
                                                :options="ageGroups"
                                                :reduce="ageGroup => ageGroup.id" 
                                                label="range" 
                                            >
                                            </v-select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="workingStyle">Working styles</label>
                                            <v-select
                                                multiple 
                                                v-on:option:selected="changedValue"
                                                v-on:option:deselected="deselectedValue"
                                                v-model="form.working_style_ids" 
                                                :options="workingStyles"
                                                :reduce="workingStyle => workingStyle.id" 
                                                label="name" 
                                            >
                                            </v-select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="speakingLanguage">Speaking Languages</label>
                                            <v-select
                                                multiple 
                                                v-on:option:selected="changedValue"
                                                v-on:option:deselected="deselectedValue"
                                                v-model="form.speaking_language_ids" 
                                                :options="speakingLanguages"
                                                :reduce="speakingLanguage => speakingLanguage.id" 
                                                label="lang" 
                                            >
                                            </v-select>
                                        </div>



                                        
                                        <div class="custom-control custom-checkbox isActiveCheck">
                                            <input v-model="form.email_verified" type="checkbox" class="custom-control-input" id="email_verified" />
                                            <label class="custom-control-label" for="email_verified">Email Verified</label>
                                        </div>

                                    </div>

                                </div>
                                <!-- row -->

                                <hr class="mb-4">

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group mb-3" v-if="old_video != null">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <b-embed
                                                        type="video"
                                                        controls
                                                        :src="old_video.fullpath"
                                                        allowfullscreen
                                                    ></b-embed>
                                                </div>
                                                <div class="col-sm-3 d-flex">
                                                    <b-button 
                                                        @click="askBeforDelete(old_video.id, 'video')" 
                                                        class="mt-auto" variant="outline-primary"
                                                    >Delete</b-button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="video">Intro Video</label>
                                            <b-form-file 
                                                v-model="form.video"
                                                accept=".mp4, .mpg, .mpeg"
                                                placeholder="Choose a video or drop it here..."
                                                drop-placeholder="Drop video here..."
                                            ></b-form-file>
                                        </div>

                                        <div class="form-group mb-3" v-if="old_passport != null">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <a :href="old_passport.fullpath" target="_blank">
                                                        <b-img :src="old_passport.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3 d-flex">
                                                    <b-button 
                                                        @click="askBeforDelete(old_passport.id, 'passport')" 
                                                        class="mt-auto" variant="outline-primary"
                                                    >Delete</b-button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="passport">Passport</label>
                                            <b-form-file 
                                                v-model="form.passport"
                                                accept=".jpeg, .jpg, .png"
                                                placeholder="Choose a image or drop it here..."
                                                drop-placeholder="Drop image here..."
                                            ></b-form-file>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        
                                        <div class="form-group mb-3" v-if="old_cover_image != null">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <a :href="old_cover_image.fullpath" target="_blank">
                                                        <b-img :src="old_cover_image.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3 d-flex">
                                                    <b-button 
                                                        @click="askBeforDelete(old_cover_image.id, 'cover_image')" 
                                                        class="mt-auto" variant="outline-primary"
                                                    >Delete</b-button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="cover_image">Cover Image</label>
                                            <b-form-file 
                                                v-model="form.cover_image"
                                                accept=".jpeg, .jpg, .png"
                                                placeholder="Choose a image or drop it here..."
                                                drop-placeholder="Drop image here..."
                                            ></b-form-file>
                                        </div>

                                        <div class="form-group mt-4 mb-0" v-if="old_license != null">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <a :href="old_license.fullpath" target="_blank">{{ old_license.name }}</a>
                                                </div>
                                                <div class="col-sm-3 d-flex">
                                                    <b-button 
                                                        @click="askBeforDelete(old_license.id, 'license')" 
                                                        class="mt-auto" variant="outline-primary"
                                                    >Delete</b-button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="license">License</label>
                                            <b-form-file 
                                                v-model="form.license"
                                                accept=".pdf"
                                                placeholder="Choose a PDF file or drop it here..."
                                                drop-placeholder="Drop PDF file here..."
                                            ></b-form-file>
                                        </div>

                                        



                                    </div>
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

