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
                            <h3 class="card-title">Portfolios</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <validation-provider name="thumbnail" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="thumbnail">Thumbnail</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="portfolio.thumbnail" name="thumbnail" placeholder="Thumbnail" id="thumbnail" readonly />
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-building"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                    <div class="col-2 mt-4">
                                                        <StandaloneFileManager :bootstrapModalId='"lfm_modal_thumbnail"'
                                                                               :btnId='"lfm_btn_thumbnail"'
                                                                               :btnCls="'btn btn-primary btn-block btn-lg py-2 mt-1'"
                                                                               :label='"Browse"'
                                                                               :dataBsTarget='"thumbnail_modal"'
                                                                               :dataBsModal='"modal"'
                                                                               :modalTitle='"Thumbnail Selector"'
                                                                               @passFileUrl="getFileUrl($event, 'thumbnail')"/>
                                                    </div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="image" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="image">Image</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="portfolio.image" name="image" placeholder="Image" id="image" readonly />
                                                                <div class="form-control-icon"> <i class="bi bi-building"></i> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                    <div class="col-2 mt-4">
                                                        <StandaloneFileManager :bootstrapModalId='"lfm_modal_image"'
                                                                               :btnId='"lfm_btn_image"'
                                                                               :btnCls="'btn btn-primary btn-block btn-lg py-2 mt-1'"
                                                                               :label='"Browse"'
                                                                               :dataBsTarget='"image_modal"'
                                                                               :dataBsModal='"modal"'
                                                                               :modalTitle='"Image Selector"'
                                                                               @passFileUrl="getFileUrl($event, 'image')"/>
                                                    </div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <validation-provider name="portfolio_category_id" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group">
                                                    <label for="portfolio_category_id">Category</label>
                                                    <v-select v-model="portfolio_category"
                                                              :options="portfolio_categories"
                                                              name="portfolio_category_id" id="portfolio_category_id"
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

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="name" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="name">Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="portfolio.name" name="name" placeholder="Name" id="name">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-type-h2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <validation-provider name="order" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="order">Order</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="portfolio.order" name="order" placeholder="Order" id="order" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-sort-down"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12">
                                            <validation-provider name="detail" rules="required|min:3" v-slot="{ dirty, valid, invalid, errors }">
                                                <label for="detail">Detail</label>
                                                <editor name="detail" :id="'detail'" v-model="portfolio.detail"
                                                        ref="tinymce" :init="tinymceConfig" />
                                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mt-2 mb-1 btn-lg" @click.prevent="handleSubmit(save)">Submit</button>
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
                            <h3 class="card-title">List of Portfolios</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tablePortfolios"  class="table-default" :columns="table.columns"
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
    import Editor from '@tinymce/tinymce-vue';
    import vSelect from 'vue-select';
    import StandaloneFileManager from '../../components/laravel_file_manager/standalone/StandaloneFileManager';
    import TinymceRepository from '../../repositories/TinymceRepository';
    import CommonRepository from '../../repositories/CommonRepository';
    import ActionButtonGroup from '../../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../../repositories/ActionButtonsRepository';
    import "vue-select/dist/vue-select.css";

    export default {
        name: "Portfolio",
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
                            label: 'Portfolio Category',
                            name: 'portfolio_category.category_name',
                            orderable: true,
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
                    url: '/api/admin/portfolios',
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
                portfolio_categories:[{'text':'Select Category', 'value':''}],
                portfolio_category:{'text':'Select Category', 'value':''},
                portfolio: {
                    thumbnail: '',
                    image: '',
                    name: '',
                    portfolio_category_id: '',
                    detail: '',
                    order: null,
                    id: null,
                },
                tinymceConfig: {
                    height: 700,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls : true,
                    forced_root_block : '',
                    image_advtab: false,
                    image_dimensions: false,
                    verify_html : false,
                    allow_html_in_named_anchor: true,
                    valid_children: 'i[class],span[class],+a[div],+a[span],+a[img]',
                    extended_valid_elements : "a[*]",
                    menubar: TinymceRepository.getMenubar(),
                    plugins: TinymceRepository.getPlugins(),
                    toolbar: TinymceRepository.getToolbar(),
                    file_picker_callback: this.getFileBrowser
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        components: {
            'editor': Editor,
            'StandaloneFileManager': StandaloneFileManager,
            'vSelect': vSelect,
        },
        mounted() {
            this.initAll();
        },
        methods: {
            reloadDatatable() {
                this.$refs.tablePortfolios.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('portfolioShow', params).then( (resp)=> {
                    console.log('portfolioShow request success!');
                    this.serverResp = resp.data;
                    this.portfolio = resp.data.data;
                    this.portfolio_category = resp.data.data.portfolio_category;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('portfolioDestroy', params).then( (resp)=> {
                    console.log('portfolioDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initPortfolio();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.searchPortfolioCategories();
            },

            initPortfolio() {
                this.$nextTick(() => {
                    this.portfolio = {
                        thumbnail: '',
                        image: '',
                        name: '',
                        portfolio_category_id: '',
                        detail: '',
                        order: null,
                        id: null,
                    };
                    this.portfolio_category = {'text':'Select Category', 'value':''};
                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            getFileBrowser: TinymceRepository.getFileBrowser,

            getFileUrl(fileUrl, elem) {
                this.setByField(fileUrl, elem);
            },

            setByField(fileUrl, elem) {
                if(elem==='thumbnail') {
                    this.portfolio.thumbnail = fileUrl;
                } else if(elem==='image') {
                    this.portfolio.image = fileUrl;
                }
            },

            save() {
                let params = this.portfolio;

                console.log('portfolio', params);
                if(params.id===null) {
                    this.$store.dispatch('portfolioStore', params).then( (resp)=> {
                        console.log('portfolioStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initPortfolio();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('portfolioUpdate', params).then( (resp)=> {
                        console.log('portfolioUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initPortfolio();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },

            searchPortfolioCategories() {
                this.$store.dispatch('searchPortfolioCategories').then( (resp)=> {
                    this.portfolio_categories = resp.data.data;
                }).catch(err => {
                    console.log(err);
                });
            }
        },

        watch: {
            portfolio_category : function(val, oldVal) {
                if(val !== null) {
                    this.portfolio.portfolio_category_id = val.id;
                } else {
                    this.portfolio.portfolio_category_id = '';
                }
            },
        }
    }
</script>

<!--<style>
    .vs__dropdown-toggle {
        border: none;
        padding: 0;
        border-radius: 0;
    }

    .vs__clear, .vs__open-indicator {
        fill: #607080;
    }
</style>-->
