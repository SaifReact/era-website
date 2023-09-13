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
                            <h3 class="card-title">E-mail Configuration</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form form-vertical" method="post" @submit.prevent="handleSubmit(save)">
                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="active" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group">
                                                        <label for="active">Activated?</label>
                                                        <v-select v-model="selected_activate_option"
                                                                  :options="activate_options"
                                                                  name="active" id="active"
                                                                  label="text"
                                                                  class="form-control form-control-xl" :clearable="false">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="mailer" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group">
                                                        <label for="mailer">Mailer</label>
                                                        <v-select v-model="selected_mailer_option"
                                                                  :options="mailer_options"
                                                                  name="mailer" id="mailer"
                                                                  label="text"
                                                                  class="form-control form-control-xl" :clearable="false">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="host" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="host">Host</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.host" name="host" placeholder="Host" id="host" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="port" rules="required|min:0|max:10000" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="port">Port</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.port" name="port" placeholder="Port" id="port" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="username" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="username">User Name</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.username" name="username" placeholder="User Name" id="username" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="password" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="password">Password</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.password" name="password" placeholder="Password" id="password" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="encryption" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="encryption">Encryption</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.encryption" name="encryption" placeholder="Encryption" id="encryption" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="from_address" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="from_address">From Address</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.from_address" name="from_address" placeholder="From Address" id="from_address" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <validation-provider name="from_name" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="from_name">From Name</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="email_config.from_name" name="from_name" placeholder="From Name" id="from_name" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-card-text"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-md-6 col-12 mt-4">
                                                <button type="submit" class="btn btn-primary my-1 py-2 btn-lg btn-block">Submit</button>
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
    </div>
</template>

<script>
    import CommonRepository from '../repositories/CommonRepository';
    import vSelect from 'vue-select';
    import "vue-select/dist/vue-select.css";

    const ACTIVATE_DEFAULT = false;
    const SMTP = 'smtp';
    const SENDMAIL = 'sendmail';

    export default {
        name: "EmailConfig",

        data() {
            return {
                email_config: {
                    active: ACTIVATE_DEFAULT,
                    mailer: SMTP,
                    host: '',
                    port: '',
                    username: '',
                    password: '',
                    encryption: '',
                    from_address: '',
                    from_name: '',
                },
                activate_options: [{'text':'Activate', 'value':true}, {'text':'De-activate', 'value':false} ],
                selected_activate_option: {'text':'De-activate', 'value':false},
                mailer_options: [{'text':'SMTP', 'value':'smtp'}, {'text':'Sendmail', 'value':'sendmail'} ],
                selected_mailer_option: {'text':'SMTP', 'value':'smtp'},
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },

        components: {
            'vSelect': vSelect,
        },

        mounted() {
            this.initAll();
        },

        methods: {
            initAll() {
                this.fetchEmailConfig();
            },

            fetchEmailConfig() {
                this.$store.dispatch('emailConfigShow').then( (resp)=> {
                    console.log('emailConfigShow request success!');
                    if(resp.data.data) {
                        this.email_config = resp.data.data;
                        this.activateOption(resp.data.data.active);
                        this.mailerOption(resp.data.data.mailer);
                    }
                }).catch( err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            save() {
                let params = this.email_config;

                this.$store.dispatch('emailConfigUpdate', params).then( (resp)=> {
                    console.log('emailConfigUpdate request success!');
                    this.serverResp = resp.data;
                    this.email_config = resp.data.data;
                    this.activateOption(resp.data.data.active);
                    this.mailerOption(resp.data.data.mailer);
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            activateOption(val) {
                if(val === true) {
                    this.selected_activate_option = {'text':'Activate', 'value':true};
                } else if(val === false) {
                    this.selected_activate_option = {'text':'De-activate', 'value':false};
                }
            },

            mailerOption(val) {
                if(val === SMTP) {
                    this.selected_mailer_option = {'text':'SMTP', 'value':'smtp'};
                } else if(val === SENDMAIL) {
                    this.selected_mailer_option = {'text':'Sendmail', 'value':'sendmail'};
                }
            },
        },

        watch: {
            selected_activate_option: function(val, oldVal) {
                if(val !== null) {
                    this.email_config.active = val.value;
                } else {
                    this.email_config.active = ACTIVATE_DEFAULT;
                }
            },

            selected_mailer_option: function(val, oldVal) {
                if(val !== null) {
                    this.email_config.mailer = val.value;
                } else {
                    this.email_config.mailer = SMTP;
                }
            },
        }
    }
</script>
