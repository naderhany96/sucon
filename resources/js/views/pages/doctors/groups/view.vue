<script>
import Layout from "../../../layout/mainLayout";
import PageHeader from "@/components/page-header";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
/*
 * View Doctor
 */
export default {
    page: {
        title: "View Doctor Group",
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
            name: 'View Doctor Group',
            title: "View Doctor Group",


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

    methods: {
        changedValue() {
            this.$forceUpdate();
        },
        deselectedValue() {
            this.$forceUpdate();
        },




        async getCurrentEntity() {
            let that = this;
            that.pending = true;
            await that.axios.get(that.editLink + this.$route.params.id).then(function (response) {

                that.currrentEntity = response.data;
                that.form = that.currrentEntity;
                that.pending = false;
            });
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

                        <form class="needs-validation">

                            <fieldset :disabled="true">


                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" v-model="form.title" class="form-control"
                                                placeholder="Enter Name" />

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
                                                locale="en" :hide-header="true"></b-form-datepicker>

                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group mb-3">
                                                    <label for="datepicker-dateformat2">Start Time</label>
                                                    <input class="form-control mb-2 ml-2" type="time"
                                                        v-model="form.start_time">

                                                </div>
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group mb-3">
                                                    <label for="datepicker-dateformat2">Finish Time</label>
                                                    <input class="form-control mb-2 ml-2" type="time"
                                                        v-model="form.finish_time">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group mb-3">
                                                    <label for="seats">Seats</label>
                                                    <input type="text" v-model="form.seats" class="form-control"
                                                        placeholder="Enter seats" />

                                                </div>

                                            </div>

                                        </div>





                                    </div>
                                </div>
                                <!-- row -->

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </Layout>
</template>

