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
                            <h3 class="card-title">Banners</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form form-vertical" method="post" @submit.prevent>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <validation-provider name="banner_image" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <div class="form-group has-icon-left">
                                                                <label for="banner_image">Banner Image</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control form-control-xl" v-model="banner.banner_image" name="banner_image" placeholder="Banner Image" id="banner_image" readonly />
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-card-image"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                        </div>
                                                        <div class="col-2 mt-4">
                                                            <StandaloneFileManager :bootstrapModalId='"lfm_modal_banner_image"'
                                                                                   :btnId='"lfm_btn_banner_image"'
                                                                                   :btnCls="'btn btn-primary btn-block btn-lg py-2 mt-1'"
                                                                                   :label='"Browse"'
                                                                                   :dataBsTarget='"banner_image_modal"'
                                                                                   :dataBsModal='"modal"'
                                                                                   :modalTitle='"Banner Image Selector"'
                                                                                   @passFileUrl="getFileUrl($event, 'banner_image')"/>
                                                        </div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="banner_text" rules="min:3|max:200" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="banner_text">Banner Text</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="banner.banner_text" name="banner_text" placeholder="Banner Text" id="banner_text" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="button_text" rules="min:2|max:200" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="button_text">Button Text</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="banner.button_text" name="button_text" placeholder="Button Text" id="button_text" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-type-bold"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-8">
                                                <validation-provider name="button_url" rules="min:14|max:200|url" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="button_url">Button URL</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="banner.button_url" name="button_url" placeholder="Button URL" id="button_url" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-box-arrow-up-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-4">
                                                <validation-provider name="order" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="order">Order</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="banner.order" name="order" placeholder="Order" id="order" />
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
                            <h3 class="card-title">List of Banners</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableBanners"  class="table-default" :columns="table.columns"
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
    import StandaloneFileManager from '../../components/laravel_file_manager/standalone/StandaloneFileManager';
    import CommonRepository from '../../repositories/CommonRepository';
    import ActionButtonGroup from '../../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../../repositories/ActionButtonsRepository';

    export default {
        name: "Banner",
        components: {
            'StandaloneFileManager': StandaloneFileManager,
        },
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
                            label: 'Banner Text',
                            name: 'banner_text',
                            orderable: true,
                        },
                        {
                            label: 'Button Text',
                            name: 'button_text',
                            orderable: true,
                        },
                        {
                            label: 'Button URL',
                            name: 'button_url',
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
                    url: '/api/admin/banners',
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
                banner: {
                    banner_image: '',
                    banner_text: '',
                    button_text: '',
                    button_url: '',
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
        methods: {
            reloadDatatable() {
                this.$refs.tableBanners.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('bannerShow', params).then( (resp)=> {
                    console.log('bannerShow request success!');
                    this.serverResp = resp.data;
                    this.banner = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('bannerDestroy', params).then( (resp)=> {
                    console.log('bannerDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initBanner();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initBanner();
            },

            initBanner() {
                this.$nextTick(() => {
                    this.banner = {
                        banner_image: '',
                        banner_text: '',
                        button_text: '',
                        button_url: '',
                        order: null,
                        id: null,
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
                if(elem==='banner_image') {
                    this.banner.banner_image = fileUrl;
                }
            },

            save() {
                let params = this.banner;

                if(params.id===null) {
                    this.$store.dispatch('bannerStore', params).then( (resp)=> {
                        console.log('bannerStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initBanner();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('bannerUpdate', params).then( (resp)=> {
                        console.log('bannerUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initBanner();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },
        }
    }
</script>
