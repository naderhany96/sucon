<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    /*
     * View Doctor
     */
    export default {
        page: {
            title: "View Doctor",
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
                name: 'View Doctor',
                title: "View Doctor",
                items: [{
                    text: "Doctors",
                    href: "/doctors"
                }],
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

                    avatar: null,
                    video: null,
                    passport: null,
                    cover_image: null,
                    license: null,
                },
                errors: null,
                submitted: false,
                pending: false,

                qualifications: [],
                specialties: [],
                ageGroups: [],
                workingStyles: [],
                speakingLanguages: [],

                currrentEntity: {},
                old_avatar: null,
                old_video: null,
                old_passport: null,
                old_cover_image: null,
                old_license: null,
            };
        },

        methods: {
            changedValue() {
                this.$forceUpdate();
            },
            deselectedValue() {
                this.$forceUpdate();
            },

            findInDoctorMedia(attr){
                if(attr == 'avatar'){
                    this.currrentEntity[attr] = null;
                    return this._.find(this.currrentEntity.media, {attribute:attr});
                } else {
                    this.currrentEntity[attr] = null;
                    return this._.find(this.currrentEntity.doctor_profile.media, {attribute:attr});
                }
            },

            async getExtra() {
                let that = this;
                that.pending = true;
                await that.axios.get("doctors/extra")
                .then(function (response) {
                    that.pending = false;
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

                    that.currrentEntity.email_verified = that.currrentEntity.email_verified_at?.trim().length > 0 ? 1 : 0;

                    that.currrentEntity.about = that.currrentEntity.doctor_profile.about;
                    that.currrentEntity.price = that.currrentEntity.doctor_profile.price;
                    that.currrentEntity.yoe = that.currrentEntity.doctor_profile.yoe;
                    
                    that.currrentEntity.qualification_ids = that._.map(that.currrentEntity.doctor_profile.qualifications, 'id');
                    that.currrentEntity.age_group_ids = that._.map(that.currrentEntity.doctor_profile.age_groups, 'id');
                    that.currrentEntity.speaking_language_ids = that._.map(that.currrentEntity.doctor_profile.speaking_languages, 'id');
                    that.currrentEntity.specialty_ids = that._.map(that.currrentEntity.doctor_profile.specialties, 'id');
                    that.currrentEntity.working_style_ids = that._.map(that.currrentEntity.doctor_profile.working_styles, 'id');

                    that.old_avatar = that.findInDoctorMedia('avatar');
                    that.old_video = that.findInDoctorMedia('video');
                    that.old_passport = that.findInDoctorMedia('passport');
                    that.old_cover_image = that.findInDoctorMedia('cover_image');
                    that.old_license = that.findInDoctorMedia('license');
                    
                    that.form = that.currrentEntity;
                    that.pending = false;
                });
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
                                            <input type="text" v-model="form.email" class="form-control" id="email"
                                                placeholder="Enter Email" />
=
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="phone">Phone *</label>
                                            <input 
                                                id="phone" type="text" v-model="form.phone" 
                                                class="form-control" placeholder="Enter phone" />
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
                                                class="form-control"
                                                placeholder="Enter price" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="yoe">Years of experience</label>
                                            <input 
                                                type="text" v-model="form.yoe" 
                                                class="form-control" 
                                                placeholder="Enter years of experience" />
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
                                            </div>
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

                                        <div class="form-group">
                                            <label for="mobile_phone">Created at</label>
                                            <input v-model="form.created_at" type="text" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_phone">Updated at</label>
                                            <input v-model="form.updated_at" type="text" class="form-control"/>
                                        </div>

                                    </div>

                                </div>
                                <!-- row -->

                                <hr class="mb-4">

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group mb-3" v-if="old_video != null">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <b-embed
                                                        type="video"
                                                        controls
                                                        :src="old_video.fullpath"
                                                        allowfullscreen
                                                    ></b-embed>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" v-if="old_passport != null">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a :href="old_passport.fullpath" target="_blank">
                                                        <b-img :src="old_passport.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-6">
                                        
                                        <div class="form-group mb-3" v-if="old_cover_image != null">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a :href="old_cover_image.fullpath" target="_blank">
                                                        <b-img :src="old_cover_image.fullpath" fluid rounded></b-img>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mt-4 mb-0" v-if="old_license != null">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a :href="old_license.fullpath" target="_blank">{{ old_license.name }}</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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

