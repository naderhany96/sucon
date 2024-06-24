<script>
import Layout from "../../layout/mainLayout";
import PageHeader from "@/components/page-header";
import { required } from "vuelidate/lib/validators";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
/*
 * Edit Doctor Slots
 */
export default {
    page: {
        title: "Edit Doctor Slots",
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
            name: 'Edit Doctor Slots',
            title: "Edit Doctor Slots",
            items: [{
                text: "Doctors",
                href: "/doctors"
            }],
            postLink: "doctors/update-slot/",
            editLink: "doctors/edit-slot/",
            form: {
                price: 0,
                range: 60,
                timeZoneId: 1,
                doctorId: null,
                timeSlots: [
                    { day: "Saturday", slots: [{ timeFrom: "", timeTo: "" }] },
                    { day: "Sunday", slots: [{ timeFrom: "", timeTo: "" }] },
                    { day: "Monday", slots: [{ timeFrom: "", timeTo: "" }] },
                    { day: "Tuesday", slots: [{ timeFrom: "", timeTo: "" }] },
                    { day: "Wednesday", slots: [{ timeFrom: "", timeTo: "" }] },
                    { day: "Thursday", slots: [{ timeFrom: "", timeTo: "" }] },
                    { day: "Friday", slots: [{ timeFrom: "", timeTo: "" }] }
                ]
            },
            errors: null,
            submitted: false,
            pending: false,
            currrentEntity: {},

            doctors: [],
            timeZones: []

        };
    },
    validations: {
        form: {
            timeSlots: {
                $each: {
                    day: {},
                    timeSlots: {
                        $each: {
                            timeFrom: { required },
                            timeTo: { required }
                        }
                    }
                }
            }
        }
    },
    methods: {
        async getTimeZones() {
            try {
                const response = await this.axios.get('/time-zones');
                this.timeZones = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        changedValue() {
            this.$forceUpdate();
        },
        deselectedValue() {
            this.$forceUpdate();
        },


        addTimeSlot(dayIndex) {
            const day = this.form.timeSlots[dayIndex];
            day.slots.push({ timeFrom: "", timeTo: "" });
        },
        removeSlot(index, slotIndex) {
            const day = this.form.timeSlots[index];
            day.slots.splice(slotIndex, 1);
        },
        async getCurrentEntity() {
            let that = this;
            that.pending = true;
            await that.axios.get(that.editLink + this.$route.params.id).then(function (response) {

                that.currrentEntity = response.data;


                that.form.range = that.currrentEntity.slots[0].range;
                that.form.price = that.currrentEntity.doctor_profile.price;



                for (let i = 0; i < that.form.timeSlots.length; i++) {
                    const day = that.form.timeSlots[i].day;

                    if (that.currrentEntity.slotss[day]) {
                        that.form.timeSlots[i].slots = that.currrentEntity.slotss[day];


                    }
                }

                that.form.timeZoneId = that.currrentEntity.time_zone_id;

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
                    if (key === 'timeSlots') {
                        formData.append(key, JSON.stringify(that.form[key]));
                    } else {
                        formData.append(key, that.form[key]);
                    }
                }


                formData.append('timeZoneId', that.form.timeZoneId);

                await that.axios.post(that.postLink + that.$route.params.id, formData)
                    .then(function () {
                        that.submitted = false;
                        that.$iziToast.success({ message: 'Updated Succesfully', position: 'bottomCenter' });
                        that.$router.push({ name: 'Doctors' });
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
            this.getCurrentEntity(),
            this.getTimeZones(),
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

                                    <div class="col-sm-4">

                                        <div class="form-group mb-3">
                                            <label for="range">Slot Range in minutes </label>
                                            <input type="text" v-model="form.range" class="form-control" placeholder="60" />
                                        </div>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label for="timeZone">Time Zone</label>
                                            <select v-model="form.timeZoneId" class="form-control" id="timeZone">
                                                <option value="">Select Time Zone</option>
                                                <option v-for="timeZone in timeZones" :value="timeZone.id"
                                                    :key="timeZone.id">{{ timeZone.name }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" v-model="form.price" class="form-control" />
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div v-for="(day, index) in form.timeSlots" :key="index">
                                            <h3 class="mt-3">{{ day.day }}</h3>
                                            <button type="button" class="btn btn-primary mb-3" @click="addTimeSlot(index)">+
                                                Add Time Slot</button>
                                            <div class="row col-3">
                                                <div v-for="(slot, slotIndex) in day.slots" :key="slotIndex"
                                                    class="d-flex align-items-center">
                                                    <input class="form-control mb-2 mr-2" type="time"
                                                        v-model="slot.timeFrom">
                                                    <span>-</span>
                                                    <input class="form-control mb-2 ml-2" type="time" v-model="slot.timeTo">
                                                    <button type="button" class="form-control btn btn-danger ml-2"
                                                        style="position: relative;top: -4px;"
                                                        @click="removeSlot(index, slotIndex)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
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

