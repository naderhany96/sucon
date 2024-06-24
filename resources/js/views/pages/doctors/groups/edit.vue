<script>
import Layout from "../../../layout/mainLayout";
import PageHeader from "@/components/page-header";
import { required, email, numeric } from "vuelidate/lib/validators";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
/*
 * Edit Doctor Groups
 */
export default {
    page: {
        title: "Edit Doctor Groups",
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
            name: 'Edit Doctor Groups',
            title: "Edit Doctor Groups",


            postLink: "doctor/groups/update/",
            editLink: "doctor/groups/edit/",
            form: {
                title: "",
                desc: "",
                date: "",
                seats: 10,
                start_time: "",
                finish_time: ""
            },
            errors: null,
            submitted: false,
            pending: false,
            currrentEntity: {},
        };
    },
    validations: {
        form: {
            title: { required },
            date: { required },
            seats: { required, numeric },
            start_time: { required },
            finish_time: { required }
        }
    },
    methods: {
        changedValue() {
            this.$forceUpdate();
        },
        deselectedValue() {
            this.$forceUpdate();
        },

        askBeforDelete(id, attr) {
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


        async getCurrentEntity() {
            let that = this;
            that.pending = true;
            await that.axios.get(that.editLink + this.$route.params.id).then(function (response) {
                that.currrentEntity = response.data;
                that.form.title = that.currrentEntity.title;
                that.form.desc = that.currrentEntity.desc;
                that.form.date = that.currrentEntity.date;
                that.form.seats = that.currrentEntity.seats
                that.form.start_time = that.currrentEntity.start_time
                that.form.finish_time = that.currrentEntity.finish_time
                that.pending = false;
            });
        },

        async updateEntity() {

            let that = this;
            that.$v.$touch();

            if (that.$v.$invalid) {
                window.scrollTo(0, 0);
                return;
            } else {

                that.submitted = true;
                let formData = new FormData();

                for (const key in that.form) {
                    formData.append(key, that.form[key]);
                }



                await that.axios.post(that.postLink + that.$route.params.id, formData)
                    .then(function () {
                        that.submitted = false;
                        that.$iziToast.success({ message: 'Updated Succesfully', position: 'bottomCenter' });
                        that.$router.go(-1);
                    }).catch(function (error) {
                        that.submitted = false;
                        if (error.response) {
                            that.errors = error.response.data.errors;
                            window.scrollTo(0, 0);
                        }
                    });
            }
        },
    },
    created() {
        this.pending = true;
        this.axios.all([
            this.getCurrentEntity()
        ]).finally(() => this.pending = false);
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
                                            <label for="title">Title</label>
                                            <input type="text" v-model="form.title" class="form-control"
                                                placeholder="Enter Name" :class="{ 'is-invalid': $v.form.title.$error }" />
                                            <div v-if="$v.form.title.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.title.required">Title is required </span>
                                            </div>
                                        </div>





                                        <div class="form-group mb-3">
                                            <label for="name">Description</label>
                                            <textarea v-model="form.desc" class="form-control"
                                                placeholder="Enter Description ..."></textarea>
                                        </div>


                                    </div>

                                    <hr class="mb-4">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="datepicker-dateformat2">Date</label>
                                            <b-form-datepicker id="datepicker-dateformat2" v-model="form.date"
                                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                :class="{ 'is-invalid': $v.form.date.$error }" locale="en"
                                                :hide-header="true"></b-form-datepicker>
                                            <div v-if="$v.form.date.$error" class="invalid-feedback">
                                                <span v-if="!$v.form.date.required">Date is required</span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group mb-3">
                                                    <label for="datepicker-dateformat2">Start Time</label>
                                                    <input class="form-control mb-2 ml-2" type="time"
                                                        :class="{ 'is-invalid': $v.form.start_time.$error }"
                                                        v-model="form.start_time">
                                                    <div v-if="$v.form.start_time.$error" class="invalid-feedback">
                                                        <span v-if="!$v.form.start_time.required">Start Time is
                                                            required</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group mb-3">
                                                    <label for="datepicker-dateformat2">Finish Time</label>
                                                    <input class="form-control mb-2 ml-2" type="time"
                                                        v-model="form.finish_time"
                                                        :class="{ 'is-invalid': $v.form.finish_time.$error }">
                                                    <div v-if="$v.form.finish_time.$error" class="invalid-feedback">
                                                        <span v-if="!$v.form.finish_time.required">Finish Time is
                                                            required</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group mb-3">
                                                    <label for="seats">Seats</label>
                                                    <input type="text" v-model="form.seats" class="form-control"
                                                        :class="{ 'is-invalid': $v.form.seats.$error }"
                                                        placeholder="Enter seats" />
                                                    <div v-if="$v.form.seats.$error" class="invalid-feedback">
                                                        <span v-if="!$v.form.seats.numeric">Seats must be a numeric
                                                            value</span>
                                                        <span v-if="!$v.form.seats.required">Seats is
                                                            required</span>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- row -->

                                <div class="col-lg-12 mt-4 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                        <span v-show="submitted || pending" class="spinner-border spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
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

