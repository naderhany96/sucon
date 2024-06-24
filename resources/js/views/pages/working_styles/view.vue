<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    /*
     * View Working Style
     */
    export default {
        page: {
            title: "View Working Style",
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
                name: 'View Working Style',
                title: "View Working Style",
                items: [{
                    text: "Working Styles",
                    href: "/working-styles"
                }],
                viewLink: "working_styles/edit/",
                form: {
                    name: "",
                    desc: "",
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
                                            <label for="name">Name</label>
                                            <input type="text" v-model="form.name" class="form-control" id="name" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="desc">Description</label>
                                            <input type="text" v-model="form.desc" class="form-control" id="desc" />
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
