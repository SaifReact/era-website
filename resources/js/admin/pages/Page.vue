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
                            <h3 class="card-title">Pages</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-12">
                                            <validation-provider name="title" rules="required|min:3|max:150" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="title">Title</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="page.title" name="title" placeholder="Title" id="title" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="slug" rules="min:3|max:200" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="slug">Slug</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="page.slug" name="slug" placeholder="Slug" id="slug">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="meta" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="meta">Meta</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="page.meta" name="meta" placeholder="Meta" id="meta" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-sort-down"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12">
                                            <validation-provider name="content" rules="required|min:3" v-slot="{ dirty, valid, invalid, errors }">
                                                <label for="content">Content (For image responsiveness and image in the middle position use: class="img-fluid mx-auto d-block" in img tag)</label>
                                                <editor name="content" :id="'content'" v-model="page.content"
                                                        ref="tinymce" :init="tinymceConfig"
                                                />
                                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary mt-2 mb-1 btn-lg me-4" @click.prevent="handleSubmit(preview)">Draft Preview</button>
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
                            <h3 class="card-title">List of Pages</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tablePages"  class="table-default" :columns="table.columns"
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
    import TinymceRepository from "../repositories/TinymceRepository";
    import CommonRepository from '../repositories/CommonRepository';
    import ActionButtonGroup from '../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../repositories/ActionButtonsRepository';
    const PREVIEW_PAGE_URL = '/admin/pages/';

    export default {
        name: "Page",
        data() {
            return {
                PAGE_STATUS_PUBLISH: null,
                PAGE_STATUS_DRAFT: 1,
                table: {
                    columns: [
                        {
                            label: 'ID',
                            name: 'id',
                            orderable: true
                        },
                        {
                            label: 'Title',
                            name: 'title',
                            orderable: true,
                        },
                        {
                            label: 'Slug',
                            name: 'slug',
                            orderable: true,
                        },
                        {
                            label: 'Meta',
                            name: 'meta',
                            orderable: true,
                        },
                        {
                            label: 'Status',
                            name: 'status'
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
                    url: '/api/admin/pages',
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
                page: {
                    title: '',
                    slug: '',
                    content: '',
                    meta: '',
                    status: this.PAGE_STATUS_PUBLISH,
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
            'editor': Editor
        },
        methods: {
            reloadDatatable() {
                this.$refs.tablePages.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('pageShow', params).then( (resp)=> {
                    console.log('pageShow request success!');
                    this.serverResp = resp.data;
                    this.page = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('pageDestroy', params).then( (resp)=> {
                    console.log('pageDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initPage();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initPage();
            },

            initPage() {
                this.$nextTick(() => {
                    this.page = {
                        title: '',
                        slug: '',
                        content: '',
                        meta: '',
                        status: this.PAGE_STATUS_PUBLISH,
                        id: null,
                    };
                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            getFileBrowser: TinymceRepository.getFileBrowser,

            create(params, preview = false) {
                return this.$store.dispatch('pageStore', params).then( (resp)=> {
                    console.log('pageStore request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    if(!preview) {
                        this.initPage();
                    }
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            update(params, preview = false) {
                return this.$store.dispatch('pageUpdate', params).then( (resp)=> {
                    console.log('pageUpdate request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    if(!preview) {
                        this.initPage();
                    }
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            preview() {
                this.page.status = this.PAGE_STATUS_DRAFT;
                let params = this.page;

                if(params.id===null) {
                    this.create(params, true).then(resp => {
                        window.open(window.location.origin+PREVIEW_PAGE_URL+resp.data.data.slug);
                    }).catch(err => {
                        console.log(err);
                    });

                } else {
                    this.update(params, true).then(resp => {
                        window.open(window.location.origin+PREVIEW_PAGE_URL+resp.data.data.slug);
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },

            save() {
                this.page.status = this.PAGE_STATUS_PUBLISH;
                let params = this.page;

                if(params.id===null) {
                    this.create(params);
                } else {
                    this.update(params);
                }
            },
        }
    }
</script>
