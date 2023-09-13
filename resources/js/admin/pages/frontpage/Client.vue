<template>
    <div class="page-heading">
        <div class="row">
            <div class="offset-md-3 col-md-6 col-12" v-if="!isEmptyServerResp()">
                <div class="alert " :class="(serverResp.status===true) ? 'alert-success' : 'alert-danger'">
                    <i class="bi bi-check-circle" v-if="(serverResp.status===true)"></i>
                    <i class="bi bi-file-excel" v-else></i>
                    {{ serverResp.message }}
                </div>
            </div>
        </div>
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="offset-md-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Clients</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form form-vertical" method="post" @submit.prevent>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <validation-provider name="logo" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <div class="form-group has-icon-left">
                                                                <label for="logo">Logo</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control form-control-xl" v-model="client.logo" name="logo" placeholder="Logo" id="logo" readonly />
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                        </div>
                                                        <div class="col-2 mt-4">
                                                            <StandaloneFileManager :bootstrapModalId='"lfm_modal_logo"'
                                                                                   :btnId='"lfm_btn_logo"'
                                                                                   :btnCls="'btn btn-primary btn-block btn-lg py-2 mt-1'"
                                                                                   :label='"Browse"'
                                                                                   :dataBsTarget='"logo_modal"'
                                                                                   :dataBsModal='"modal"'
                                                                                   :modalTitle='"Logo Selector"'
                                                                                   @passFileUrl="getFileUrl($event, 'logo')"/>
                                                        </div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="client_category_id" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group">
                                                        <label for="client_category_id">Category</label>
                                                        <v-select v-model="client_category"
                                                                  :options="client_categories"
                                                                  name="client_category_id" id="client_category_id"
                                                                  label="text"
                                                                  class="form-control form-control-xl" :clearable="false" :default="'Select Category'">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="client_name" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="client_name">Client Name</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="client.client_name" name="client_name" placeholder="Client Name" id="client_name" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-building"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="url" rules="min:14|max:200|url" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="url">URL</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="client.url" name="url" placeholder="URL" id="url">
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-box-arrow-up-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="order" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="order">Order</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="client.order" name="order" placeholder="Order" id="order" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-sort-down"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary my-1 btn-lg" @click.prevent="handleSubmit(save)">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </validation-observer>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
        <section class="section">
            <div class="row match-height">
                <div class="offset-md-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Clients</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableClients"  class="table-default" :columns="table.columns"
                                        :url="table.url" :classes="table.classes" :debounce-delay="500">
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import vSelect from 'vue-select';
    import StandaloneFileManager from '../../components/laravel_file_manager/standalone/StandaloneFileManager';
    import CommonRepository from '../../repositories/CommonRepository';
    import ActionButtonGroup from '../../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../../repositories/ActionButtonsRepository';
    import "vue-select/dist/vue-select.css";

    export default {
        name: "Client",
        data() {
            return {
                table: {
                    columns: [
                        {
                            label: 'ID',
                            name: 'id',
                            orderable: true
                        },
                        {
                            label: 'Client Name',
                            name: 'client_name',
                            orderable: true,
                        },
                        {
                            label: 'URL',
                            name: 'url',
                            orderable: false,
                        },
                        {
                            label: 'Order',
                            name: 'order',
                            orderable: true,
                        },
                        {
                            label: 'Actions',
                            name: JSON.stringify({
                                buttons: [
                                    { name: EDIT, iconClass: "bi bi-pencil-square" },
                                    { name: DELETE, iconClass: "bi bi-trash" },
                                ],
                            }),
                            data: {
                                EDIT: EDIT,
                                DELETE: DELETE
                            },
                            orderable: false,
                            classes: {
                                'btn': true,
                                'btn-md': true,
                                'me-4': true,
                            },
                            event: "click",
                            handler: this.actionHandler,
                            component: ActionButtonGroup,
                        },
                    ],
                    url: '/api/admin/clients',
                    classes: {
                        "table-container": {
                            "table-responsive": true,
                        },
                        "table": {
                            "table": true,
                            "table-striped": true,
                            "table-hover": true,
                            "align-middle": true,
                            "py-2": true,
                        },
                        "t-head": {
                            "bg-primary": true,
                            "text-white": true,
                        },
                        "t-body": {

                        },
                        "t-head-tr": {

                        },
                        "t-body-tr": {

                        },
                        "td": {
                            "text-center": true,
                        },
                        "th": {
                            "text-center": true,
                        },
                    }
                },
                client_categories:[{'text':'Select Category', 'value':''}],
                client_category:{'text':'Select Category', 'value':''},
                client: {
                    logo: '',
                    client_category_id: '',
                    client_name: '',
                    url: '',
                    order: null,
                    id: null,
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        components: {
            'StandaloneFileManager': StandaloneFileManager,
            'vSelect': vSelect,
        },
        mounted() {
            this.initAll();
        },
        methods: {
            reloadDatatable() {
                this.$refs.tableClients.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('clientShow', params).then( (resp)=> {
                    console.log('clientShow request success!');
                    this.serverResp = resp.data;
                    this.client = resp.data.data;
                    this.client_category = resp.data.data.client_category;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('clientDestroy', params).then( (resp)=> {
                    console.log('clientDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initClient();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.searchClientCategories();
            },

            initClient() {
                this.$nextTick(() => {
                    this.client = {
                        logo: '',
                        client_category_id: '',
                        client_name: '',
                        url: '',
                        order: null,
                        id: null
                    };
                    this.client_category = {'text':'Select Category', 'value':''};
                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            getFileUrl(fileUrl, elem) {
                this.setByField(fileUrl, elem);
            },

            setByField(fileUrl, elem) {
                if(elem==='logo') {
                    this.client.logo = fileUrl;
                }
            },

            save() {
                let params = this.client;

                if(params.id===null) {
                    this.$store.dispatch('clientStore', params).then( (resp)=> {
                        console.log('clientStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initClient();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('clientUpdate', params).then( (resp)=> {
                        console.log('clientUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initClient();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },

            searchClientCategories() {
                this.$store.dispatch('searchClientCategories').then( (resp)=> {
                    this.client_categories = resp.data.data;
                }).catch(err => {
                    console.log(err);
                });
            }
        },
        watch: {
            client_category : function(val, oldVal) {
                if(val !== null) {
                    this.client.client_category_id = val.id;
                } else {
                    this.client.client_category_id = '';
                }
            },
        }
    }
</script>
