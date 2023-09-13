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
                            <h3 class="card-title">Events</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-12">
                                            <validation-provider name="title" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="title">Title</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="event.title" name="title" placeholder="Title" id="title" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-calendar-event"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12">
                                            <validation-provider name="slug" rules="min:3|max:200" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="slug">Slug</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="event.slug" name="slug" placeholder="Slug" id="slug" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12">
                                            <validation-provider name="meta" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="meta">Meta</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="event.meta" name="meta" placeholder="Meta" id="meta" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-sort-down"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="thumbnail" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="thumbnail">Thumbnail</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="event.thumbnail" name="thumbnail" placeholder="Thumbnail" id="thumbnail" readonly />
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
                                                                <input type="text" class="form-control form-control-xl" v-model="event.image" name="image" placeholder="Image" id="image" readonly />
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

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="event_at" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="event_at">Event at</label>
                                                    <div class="position-relative">
                                                        <date-picker id="event_at" name="event_at" width="100%" input-class="form-control form-control-xl" v-model="event.event_at" type="date" lang="en" format="YYYY-MM-DD" value-type="format" :editable="false"></date-picker>
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-calendar-date"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="publish_at" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="publish_at">Publish At</label>
                                                    <div class="position-relative">
                                                        <date-picker id="publish_at" name="publish_at" width="100%"  input-class="form-control form-control-xl" v-model="event.publish_at"  type="datetime" lang="en" format="YYYY-MM-DD HH:mm" value-type="format" :editable="false" :show-time-header="true" confirm></date-picker>
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-calendar2-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12">
                                            <validation-provider name="teaser" rules="required|min:3|max:500" v-slot="{ dirty, valid, invalid, errors }">
                                                <label for="teaser">Teaser</label>
                                                <editor name="teaser" :id="'teaser'" v-model="event.teaser"
                                                        ref="tinymceCompact" :init="tinymceConfigCompact" />
                                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <validation-provider name="detail" rules="required|min:3" v-slot="{ dirty, valid, invalid, errors }">
                                                <label for="detail">Detail</label>
                                                <editor name="detail" :id="'detail'" v-model="event.detail"
                                                        ref="tinymce" :init="tinymceConfig" />
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
                            <h3 class="card-title">List of Events</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableEvents"  class="table-default" :columns="table.columns"
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
    import Editor from '@tinymce/tinymce-vue';
    import TinymceRepository from '../../repositories/TinymceRepository';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import CommonRepository from '../../repositories/CommonRepository';
    import moment from 'moment';
    import ActionButtonGroup from '../../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../../repositories/ActionButtonsRepository';
    const PREVIEW_EVENT_URL = '/admin/events/';

    export default {
        name: "Event",
        data() {
            return {
                EVENT_STATUS_PUBLISH: null,
                EVENT_STATUS_DRAFT: 1,
                table: {
                    columns: [
                        {
                            label: 'ID',
                            name: 'id',
                            orderable: true
                        },
                        {
                            label: 'Event',
                            name: 'title',
                            orderable: true,
                        },
                        {
                            label: 'Event At',
                            name: 'event_at',
                            orderable: true,
                        },
                        {
                            label: 'Publish At',
                            name: 'publish_at',
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
                    url: '/api/admin/events',
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
                event: {
                    title: '',
                    slug: '',
                    meta: '',
                    thumbnail: '',
                    image: '',
                    event_at: '',
                    teaser: '',
                    detail: '',
                    publish_at: '',
                    status: this.EVENT_STATUS_PUBLISH,
                    id: null
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
                tinymceConfigCompact: {
                    height: 200,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls : true,
                    forced_root_block : '',
                    image_advtab: false,
                    plugins: TinymceRepository.getCompactPlugins(),
                    toolbar: TinymceRepository.getCompactToolbar()
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        watch: {
            'event.event_at': function(val) {
                if((val !== '') || (val !== null)) {
                    this.setPublishAtByEventDate(val);
                }
            }
        },
        components: {
            'DatePicker': DatePicker,
            'editor': Editor,
            'StandaloneFileManager': StandaloneFileManager,
        },
        methods: {
            setPublishAtByEventDate(eventAt) {
                console.log('What is inside publish at: ', this.event.publish_at);
                if((this.event.publish_at === '') || (this.event.publish_at === null)) {
                    this.event.publish_at = eventAt+ ' '+'00:00';
                }
            },
            reloadDatatable() {
                this.$refs.tableEvents.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('eventShow', params).then( (resp)=> {
                    console.log('eventShow request success!');
                    this.serverResp = resp.data;
                    this.event = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('eventDestroy', params).then( (resp)=> {
                    console.log('eventDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initEvent();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initEvent();
            },

            initEvent() {
                this.$nextTick(() => {
                    this.event = {
                        title: '',
                        slug: '',
                        meta: '',
                        thumbnail: '',
                        image: '',
                        event_at: '',
                        teaser: '',
                        detail: '',
                        publish_at: '',
                        status: this.EVENT_STATUS_PUBLISH,
                        id: null
                    };
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
                    this.event.thumbnail = fileUrl;
                } else if(elem==='image') {
                    this.event.image = fileUrl;
                }
            },

            create(params, preview = false) {
                return this.$store.dispatch('eventStore', params).then( (resp)=> {
                    console.log('eventStore request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    if(!preview) {
                        this.initEvent();
                    }
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            update(params, preview = false) {
                return this.$store.dispatch('eventUpdate', params).then( (resp)=> {
                    console.log('eventUpdate request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    if(!preview) {
                        this.initEvent();
                    }
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            preview() {
                this.event.status = this.EVENT_STATUS_DRAFT;
                let params = this.event;

                if(params.id===null) {
                    this.create(params, true).then(resp => {
                        window.open(window.location.origin+PREVIEW_EVENT_URL+resp.data.data.slug);
                    }).catch(err => {
                        console.log(err);
                    });

                } else {
                    this.update(params, true).then(resp => {
                        window.open(window.location.origin+PREVIEW_EVENT_URL+resp.data.data.slug);
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },

            save() {
                this.event.status = this.EVENT_STATUS_PUBLISH;
                let params = this.event;

                if(params.id===null) {
                    this.create(params);
                } else {
                    this.update(params);
                }
            },
        }
    }
</script>

<style>
    .mx-datepicker {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .mx-datepicker-btn-confirm {
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: white;
        background-color: #435ebe;
    }
</style>
