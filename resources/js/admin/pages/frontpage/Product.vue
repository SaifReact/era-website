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
                            <h3 class="card-title">Products</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form form-vertical" method="post" @submit.prevent>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <validation-provider name="logo" rules="min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <div class="form-group has-icon-left">
                                                                <label for="logo">Logo</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control form-control-xl" v-model="product.logo" name="logo" placeholder="Logo" id="logo" readonly />
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-app-indicator"></i>
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
                                                <validation-provider name="product_name" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="product_name">Product Name</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="product.product_name" name="product_name" placeholder="Product Name" id="product_name" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-app-indicator"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="summary" rules="required|min:3|max:1000" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group">
                                                        <label for="summary">Summary</label>
                                                        <textarea class="form-control form-control-xl" v-model="product.summary" name="summary" id="summary" rows="3"></textarea>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12">
                                                <validation-provider name="url" rules="min:14|max:200|url" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="url">URL</label>
                                                        <div class="position-relative">
                                                            <input type="url" class="form-control form-control-xl" v-model="product.url" name="url" placeholder="URL" id="url">
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-box-arrow-up-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-7">
                                                <div class="form-group has-icon-left">
                                                    <label for="box_color">Box Color</label>
                                                    <div class="position-relative">
                                                        <color-picker :id="'box_color'" :klass="'form-control form-control-xl'" :color="product.box_color" :name="'box_color'" @input="updateBoxColor" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-card-text"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-5">
                                                <validation-provider name="order" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="order">Order</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="product.order" name="order" placeholder="Order" id="order" />
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
                            <h3 class="card-title">List of Products</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableProducts"  class="table-default" :columns="table.columns"
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
    import ColorPicker from '../../components/color_picker/ColorPicker';
    import CommonRepository from '../../repositories/CommonRepository';
    import ActionButtonGroup from '../../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../../repositories/ActionButtonsRepository';

    export default {
        name: "Product",
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
                            label: 'Product Name',
                            name: 'product_name',
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
                    url: '/api/admin/products',
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
                product: {
                    logo: '',
                    product_name: '',
                    summary: '',
                    url: '',
                    box_color: '#000000',
                    order: null,
                    id: null
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
            'color-picker': ColorPicker
        },
        methods: {
            reloadDatatable() {
                this.$refs.tableProducts.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('productShow', params).then( (resp)=> {
                    console.log('productShow request success!');
                    this.serverResp = resp.data;
                    this.product = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('productDestroy', params).then( (resp)=> {
                    console.log('productDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initProduct();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initProduct();
            },

            initProduct() {
                this.$nextTick(() => {
                    this.product = {
                        logo: '',
                        product_name: '',
                        summary: '',
                        url: '',
                        box_color: '#000000',
                        order: null,
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
                if(elem==='logo') {
                    this.product.logo = fileUrl;
                }
            },

            updateBoxColor(val) {
                this.product.box_color = val;
            },

            save() {
                let params = this.product;

                if(params.id===null) {
                    this.$store.dispatch('productStore', params).then( (resp)=> {
                        console.log('productStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initProduct();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('productUpdate', params).then( (resp)=> {
                        console.log('productUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initProduct();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },
        }
    }
</script>
