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
                            <h3 class="card-title">Users</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <validation-provider name="photo" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="photo">Photo</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="user.photo" name="photo" placeholder="Photo" id="photo" readonly />
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
                                            <validation-provider name="name" rules="required|min:2|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="name">User Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="user.name" name="name" placeholder="User Name" id="name" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12" v-if="!user.id">
                                            <validation-provider name="email" rules="required|min:8|max:100|email" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="email">E-mail</label>
                                                    <div class="position-relative">
                                                        <input type="email" class="form-control form-control-xl" v-model="user.email" name="email" placeholder="E-mail" id="email">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-envelope"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>

                                        </div>

                                        <div class="col-md-6 col-12" v-else>
                                            <div class="form-group has-icon-left">
                                                <label for="email">E-mail</label>
                                                <div class="position-relative">
                                                    <div class="form-control form-control-xl readonly">{{ user.email }}</div>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="first_name" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="first_name">First Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="user.first_name" name="first_name" placeholder="First Name" id="first_name">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="last_name" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="last_name">Last Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="user.last_name" name="last_name" placeholder="Last Name" id="last_name">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="password" rules="min:8|password:@password_confirmation" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="password">Password</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control form-control-xl" v-model="user.password" name="password" placeholder="Password" id="password" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-shield-lock"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="password_confirmation" vid="password_confirmation" rules="required_if:id,null|min:8" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="password_confirmation">Re-type Password</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control form-control-xl" v-model="user.password_confirmation" name="password_confirmation" placeholder="Re-type Password" id="password_confirmation" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-shield-lock"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="send_notification" rules="" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="send_notification" class="form-check-input" v-model="user.send_notification" name="send_notification">
                                                        <label for="send_notification">Send e-mail to the user about account login information.</label>
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
                            <h3 class="card-title">List of Users</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableUsers"  class="table-default" :columns="table.columns"
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
        name: "User",
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
                            label: 'Name',
                            name: 'name',
                            orderable: true,
                        },
                        {
                            label: 'First Name',
                            name: 'first_name',
                            orderable: true,
                        },
                        {
                            label: 'Last Name',
                            name: 'last_name',
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
                    url: '/api/admin/users',
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
                user: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    photo: '',
                    first_name: '',
                    last_name: '',
                    send_notification: true,
                    remember_token: '',
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
        },
        methods: {
            reloadDatatable() {
                this.$refs.tableUsers.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('userShow', params).then( (resp)=> {
                    console.log('userShow request success!');
                    this.serverResp = resp.data;
                    this.user = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('userDestroy', params).then( (resp)=> {
                    console.log('userDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initUser();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initUser() {
                this.$nextTick(() => {
                    this.user = {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        photo: '',
                        first_name: '',
                        last_name: '',
                        send_notification: true,
                        remember_token: '',
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
                if(elem==='photo') {
                    this.user.photo = fileUrl;
                }
            },

            save() {
                let params = this.user;

                if(params.id===null) {
                    this.$store.dispatch('userStore', params).then( (resp)=> {
                        console.log('userStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initUser();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('userUpdate', params).then( (resp)=> {
                        console.log('userUpdate request success!');
                        if(resp.data.data.ok) {
                            this.serverResp = resp.data;
                            this.reloadDatatable();
                            this.initUser();
                        } else {
                            this.$router.push('/auth/login');
                        }
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },
        }
    }
</script>

<style scoped>
    .readonly {
        background-color: #e9ecef;
        opacity: 1;
    }
</style>
