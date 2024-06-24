<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    /*
     * View Category
     */
    export default {
        page: {
            title: "View Category",
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
                name: 'View Category',
                title: "View Category",
                items: [{
                    text: "Categories",
                    href: "/categories"
                }],
                viewLink: "categories/edit/",
                form: {
                    name: "",
                    parent: ""
                },
                errors: null,
                submitted: false,
                pending: false,
                currrentEntity: {},
                parentCategries: []
            };
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

            async getCurrentEntity() {
                let that = this;
                await that.axios.get(that.viewLink + that.$route.params.id).then(function(response){
                    that.currrentEntity = response.data;
                    that.form = that.currrentEntity;
                    that.form.parent = that.currrentEntity.parent_id;
                });
            },
        },
        created() {            
            this.pending = true;
            this.axios.all([
                this.getCurrentEntity(),
                this.getExtra()
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
                                        
                                        <div class="form-group">
                                            <label for="created_at">Created at</label>
                                            <input v-model="form.created_at" type="text" class="form-control"/>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        
                                        <div class="form-group mb-3">
                                            <label>Parent</label>
                                            <select
                                                v-model="form.parent"
                                                class="custom-select form-control">
                                                <option
                                                    :value="category.id"
                                                    v-for="category in parentCategries"
                                                    :key="category.id"
                                                >
                                                    {{ category.name }}
                                                </option>
                                            </select>
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
