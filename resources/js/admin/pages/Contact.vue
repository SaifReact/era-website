<template>
    <div class="page-heading">
        <div class="row">
            <div class="col-12" v-if="!isEmptyServerResp()">
                <div class="alert " :class="(serverResp.status===true) ? 'alert-success' : 'alert-danger'">
                    <i class="bi bi-check-circle" v-if="(serverResp.status===true)"></i>
                    <i class="bi bi-file-excel" v-else></i>
                    {{ serverResp.message }}
                </div>
            </div>
        </div>

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contacts</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!--url-->
                                            <validation-provider name="photo" rules="min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="photo">Photo</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="contact.photo" name="photo" placeholder="Photo" id="photo" readonly />
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-building"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                    <div class="col-2 mt-4">
                                                        <StandaloneFileManager :bootstrapModalId='"lfm_modal_photo"'
                                                                               :btnId='"lfm_btn_photo"'
                                                                               :btnCls="'btn btn-primary btn-block btn-lg py-2 mt-1'"
                                                                               :label='"Browse"'
                                                                               :dataBsTarget='"photo_modal"'
                                                                               :dataBsModal='"modal"'
                                                                               :modalTitle='"Photo Selector"'
                                                                               @passFileUrl="getFileUrl($event, 'photo')"/>
                                                    </div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="person_name" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="person_name">Person Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="contact.person_name" name="person_name" placeholder="Person Name" id="person_name" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="designation" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="designation">Designation</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="contact.designation" name="designation" placeholder="Designation" id="designation">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="contact_no" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="contact_no">Contact No.</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="contact.contact_no" name="contact_no" placeholder="Contact No." id="contact_no">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="order" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="order">Order</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="contact.order" name="order" placeholder="Order" id="order" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-sort-down"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="primary_contact" rules="" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="primary_contact" class="form-check-input" v-model="contact.primary_contact" name="primary_contact">
                                                        <label for="primary_contact">Should it be shown at the top most portion of landing page?</label>
                                                    </div>
                                                </div>
                                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary my-1 btn-lg" @click.prevent="handleSubmit(save)">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </validation-observer>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
        <section class="section">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Contacts</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableContacts"  class="table-default" :columns="table.columns"
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
    import StandaloneFileManager from "../components/laravel_file_manager/standalone/StandaloneFileManager";
    import CommonRepository from '../repositories/CommonRepository';
    import ActionButtonGroup from '../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../repositories/ActionButtonsRepository';

    export default {
        name: 'Contact',
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
                            label: 'Person Name',
                            name: 'person_name',
                            orderable: true,
                        },
                        {
                            label: 'Designation',
                            name: 'designation',
                            orderable: true,
                        },
                        {
                            label: 'Order',
                            name: 'order',
                            orderable: true,
                        },
                        {
                            label: 'Primary Contact?',
                            name: 'primary_contact',
                            orderable: false,
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
                    url: '/api/admin/contacts',
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
                contact: {
                    photo: '',
                    person_name: '',
                    designation: '',
                    order: null,
                    primary_contact: false,
                    id: null
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        mounted() {
        },
        components: {
            'StandaloneFileManager': StandaloneFileManager,
        },
        methods: {
            reloadDatatable() {
                this.$refs.tableContacts.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('contactShow', params).then( (resp)=> {
                    console.log('contactShow request success!');
                    this.serverResp = resp.data;
                    this.contact = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('contactDestroy', params).then( (resp)=> {
                    console.log('contactDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initContact();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initContact();
            },

            initContact() {
                this.$nextTick(() => {
                    this.contact = {
                        photo: '',
                        person_name: '',
                        designation: '',
                        order: null,
                        primary_contact: false,
                        id: null
                    };
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
                if(elem==='photo') {
                    this.contact.photo = fileUrl;
                }
            },

            save() {
                let params = this.contact;

                if(params.id===null) {
                    this.$store.dispatch('contactStore', params).then( (resp)=> {
                        console.log('contactStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initContact();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('contactUpdate', params).then( (resp)=> {
                        console.log('contactUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initContact();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },
        },
    }
</script>
