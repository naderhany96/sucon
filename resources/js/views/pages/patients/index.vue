<script>
    import Layout from "../../layout/mainLayout";
    import PageHeader from "@/components/page-header";
    import NavigateTo from "@/components/navigate-to";
    import Loading from "@/components/table/table-loading";
    import EditItem from "@/components/table/edit-item";
    import ConfirmDelete from "@/components/table/confirm-delete-popover";
    import {
        editItem,
        viewItem,
        dynamicDeleteItem,
        dynamicFetchComponentData
    } from "@/helpers/crud-func";

    /*
     *  Patients component
     */
    export default {
        page: {
            title: "Patients",
            meta: [{
                name: "description"
            }]
        },
        components: {
            Layout,
            PageHeader,
            NavigateTo,
            Loading,
            EditItem,
            ConfirmDelete
        },
        data() {
            return {
                // page header
                title: "Patients",
                items: [],
                // crud functions
                fetchLink: "patients/list",
                deleteLink: "patients/delete/",
                editRouteName: "Edit-Patient",
                viewRouteName: "View-Patient",
                componentData: [],
                // table properties
                transProps: { name: 'table-list'},
                totalRows: 0,
                currentPage: 1,
                perPage: 10,
                pageOptions: [10, 25, 50, 100],
                search: '',
                sortDesc: false,
                hover: true,
                isBusy: true,
                fields: [
                    {
                        key: 'name',
                        label: 'Name'
                    },
                    {
                        key: 'email',
                        label: 'Email'
                    },
                    {
                        key: "phone",
                        label: "Phone",
                    },
                    {
                        key: "verified",
                        label: "Verified",
                    },
                    { key: "actions", label: "", sortable: false },
                ],
            };
        },
        computed: {
            rows() {
                return this.componentData != undefined ? this.componentData.length : 0; // Total no. of records
            },
        },
        watch: {
            perPage() {
                this.dynamicFetchComponentData()
            },
            search() {
                this.dynamicFetchComponentData()
            }
        },
        created() {
            this.editItem = editItem.bind(this);
            this.viewItem = viewItem.bind(this);
            this.dynamicDeleteItem = dynamicDeleteItem.bind(this);
            this.dynamicFetchComponentData = dynamicFetchComponentData.bind(this);
        },
        mounted() {
            this.dynamicFetchComponentData();
        },
    };

</script>

<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body dynamic_table_card_body">
                        
                        <div v-if="$can('add_patient')">
                            <NavigateTo routeName="Add-Patient" routeLabel="Add Patient"></NavigateTo>
                            <hr>
                        </div>
                        
                        <!-- Limit & search -->
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-6">
                                <div id="tickets-table_length" class="dataTables_length">
                                    <label class="d-inline-flex align-items-center">
                                        view&nbsp;
                                        <b-form-select v-model="perPage" size="sm" :options="pageOptions">
                                        </b-form-select>&nbsp;records 
                                    </label>
                                </div>
                            </div>
                            <!-- Search -->
                            <div class="col-sm-12 col-md-6">
                                <div id="tickets-table_filter" class="dataTables_filter text-md-right">
                                    <label class="d-inline-flex align-items-center">
                                        <b-form-input v-model="search" type="search"
                                            placeholder="search ..." class="form-control form-control-sm ml-2">
                                        </b-form-input>
                                    </label>
                                </div>
                            </div>
                            <!-- End search -->
                        </div>

                        <!-- Table -->
                        <div class="mb-0 position-relative dynamic_table">
                            <b-table 
                                primary-key="id"
                                :tbody-transition-props="transProps"
                                :items="componentData" 
                                :fields="fields" 
                                :hover="hover"
                                responsive="sm" 
                                :per-page="0" 
                                :current-page="currentPage" 
                                :sort-desc.sync="sortDesc"
                            >
                                <template #cell(verified)="data">
                                    <div class="d-inline-block" v-if="data.item.email_verified_at == null || data.item.email_verified_at == ''">
                                        <b-badge pill variant="danger">Not Verified</b-badge>
                                    </div>
                                    <div class="d-inline-block" v-else>
                                        <b-badge pill variant="success">Verified</b-badge>
                                    </div>
                                </template>
                                <template #cell(actions)="row">
                                    <div class="d-inline" v-if="$can('view_patient')">
                                        <b-button
                                            size="sm"
                                            @click="viewItem(row.item, $event.target, viewRouteName)"
                                            class="mr-1"
                                            v-b-tooltip.hover
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </b-button>
                                    </div>
                                    <EditItem
                                        :row="row" 
                                        :routeName="editRouteName"
                                        :editItem="editItem"
                                        permissionName="edit_patient"
                                    ></EditItem>
                                    <ConfirmDelete
                                        :row="row" 
                                        :deleteItem="dynamicDeleteItem" 
                                        :deleteLink="deleteLink" 
                                        :dynamicFetchComponentData="dynamicFetchComponentData"
                                        permissionName="delete_patient"
                                    ></ConfirmDelete>
                                </template>
                            </b-table>

                            <div class="table_feedback">
                                <div class="empty_records text-center" v-if="componentData.length == 0 && !isBusy">
                                    <p>No record to display.</p>
                                </div>
                                <div class="empty_filtered text-center" v-if="rows > 0 && totalRows == 0">
                                    <p>No search result.</p>
                                </div>
                                <div class="loading d-flex justify-content-center align-self-center" v-if="isBusy">
                                    <Loading></Loading>
                                </div>
                            </div>
                            <!-- table_feedback -->
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="dataTables_paginate paging_simple_numbers float-right">
                                    <ul class="pagination pagination-rounded mb-0">
                                        <!-- pagination -->
                                        <b-pagination @input="dynamicFetchComponentData" v-model="currentPage"
                                            :total-rows="totalRows" :per-page="perPage"></b-pagination>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </Layout>
</template>
