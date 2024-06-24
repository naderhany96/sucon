<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    /*
     * View Age Group
     */
    export default {
        page: {
            title: "View Age Group",
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
                name: 'View Age Group',
                title: "View Age Group",
                items: [{
                    text: "Age Groups",
                    href: "/age-groups"
                }],
                viewLink: "age_groups/edit/",
                form: {
                    from: "",
                    to: "",
                },
                errors: null,
                submitted: false,
                pending: false,
                currrentEntity: {},
            };
        },
        methods: {

            async getCurrentEntity() {
                let that = this;
                await that.axios.get(that.viewLink + that.$route.params.id).then(function(response){
                    that.currrentEntity = response.data;
                    that.form = that.currrentEntity;
                });
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

                        <form class="needs-validation">

                            <fieldset disabled="true">

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group mb-3">
                                            <label for="from">From</label>
                                            <input type="text" v-model="form.from" class="form-control" id="from" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="to">To</label>
                                            <input type="text" v-model="form.to" class="form-control" id="to" />
                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="created_at">Created at</label>
                                            <input v-model="form.created_at" type="text" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="updated_at">Updated at</label>
                                            <input v-model="form.updated_at" type="text" class="form-control"/>
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
