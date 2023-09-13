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
                            <h3 class="card-title">Company Information</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!--url-->
                                            <validation-provider name="logo_src" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="logo_src">Logo</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="companyInfo.logo_src" name="logo_src" placeholder="Logo" id="logo_src" readonly />
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
                                                                               :dataBsTarget='"logo_src_modal"'
                                                                               :dataBsModal='"modal"'
                                                                               :modalTitle='"Logo Selector"'
                                                                               @passFileUrl="getFileUrl($event, 'logo_src')"/>
                                                    </div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <!--url-->
                                            <validation-provider name="logo_small_src" rules="required|min:14|max:191|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group has-icon-left">
                                                            <label for="logo_small_src">Logo (Small)</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control form-control-xl" v-model="companyInfo.logo_small_src" name="logo_small_src" placeholder="Logo (Small)" id="logo_small_src" readonly />
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-building"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                    <div class="col-2 mt-4">
                                                        <StandaloneFileManager :bootstrapModalId='"lfm_modal_logo_small"'
                                                                               :btnId='"lfm_btn_logo_small"'
                                                                               :btnCls="'btn btn-primary btn-block btn-lg py-2 mt-1'"
                                                                               :label='"Browse"'
                                                                               :dataBsTarget='"logo_small_src_modal"'
                                                                               :dataBsModal='"modal"'
                                                                               :modalTitle='"Logo (Small) Selector"'
                                                                               @passFileUrl="getFileUrl($event, 'logo_small_src')"/>
                                                    </div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="logo_alt" rules="required|min:3|max:50" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="logo_alt">Logo Alt Text</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.logo_alt" name="logo_alt" placeholder="Logo Alt Text" id="logo_alt">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-type-h2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="root_url" rules="required|min:1|max:200" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="root_url">Root URL</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.root_url" name="root_url" placeholder="Root URL" id="root_url">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-type-h2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <validation-provider name="website_name" rules="required|min:3|max:50" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="website_name">Website Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.website_name" name="website_name" placeholder="Site Title" id="website_name">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-type-h2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="tagline" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="tagline">Tagline</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.tagline" name="tagline" placeholder="Tagline" id="tagline">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-type-h3"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="fax" :rules="{min:7, regex:/^([0-9\s\-\+\(\)]*)$/}" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="fax">Fax</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.fax" name="fax" placeholder="Fax" id="fax">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-reception-1"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="phone" :rules="{min:7, regex:/^([0-9\s\-\+\(\)]*)$/}" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="phone">Phone</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.phone" name="phone" placeholder="Phone" id="phone">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-reception-1"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="email" rules="min:5|max:100|email" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="email">E-mail</label>
                                                    <div class="position-relative">
                                                        <input type="email" class="form-control form-control-xl" v-model="companyInfo.email" name="email" placeholder="Email" id="email">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-envelope"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <!--url-->
                                            <validation-provider name="web" rules="min:14|max:200|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="web">Web</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.web" name="web" placeholder="Web" id="web">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <!--url-->
                                            <validation-provider name="facebook" rules="min:14|max:200|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="facebook">Facebook</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.facebook" name="facebook" placeholder="Facebook" id="facebook">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <!--url-->
                                            <validation-provider name="linkedin" rules="min:14|max:200|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="linkedin">Linkedin</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.linkedin" name="linkedin" placeholder="Linkedin" id="linkedin">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="open_days" rules="min:5|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="open_days">Open Days</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.open_days" name="open_days" placeholder="Open Days" id="open_days">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-calendar-day"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="duration" rules="min:5|max:50" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="duration">Duration</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="companyInfo.duration" name="duration" placeholder="Duration" id="duration">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-clock"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="company_summary" rules="min:10|max:1000" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group">
                                                    <label for="company_summary">Company Summary</label>
                                                    <textarea class="form-control form-control-xl" v-model="companyInfo.company_summary" name="company_summary" id="company_summary" rows="3"></textarea>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
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
    </div>
</template>

<script>
    import StandaloneFileManager from "../components/laravel_file_manager/standalone/StandaloneFileManager";
    import CommonRepository from '../repositories/CommonRepository';

    export default {
        name: 'CompanyInfo',
        data() {
            return {
                lfm: {
                    inputId: '',
                },
                companyInfo: {
                    logo_src: '',
                    logo_small_src: '',
                    logo_alt: '',
                    root_url: '',
                    website_name: '',
                    tagline: '',
                    fax: '',
                    phone: '',
                    email: '',
                    web: '',
                    facebook: '',
                    linkedin: '',
                    company_summary: '',
                    open_days: '',
                    duration: '',
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
            initCompanyInfo() {
                this.$nextTick(() => {
                    this.companyInfo = {
                        logo_src: '',
                        logo_small_src: '',
                        logo_alt: '',
                        root_url: '',
                        website_name: '',
                        tagline: '',
                        fax: '',
                        phone: '',
                        email: '',
                        web: '',
                        facebook: '',
                        linkedin: '',
                        company_summary: '',
                        open_days: '',
                        duration: '',
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
                if(elem==='logo_src') {
                    this.companyInfo.logo_src = fileUrl;
                } else if(elem==='logo_small_src') {
                    this.companyInfo.logo_small_src = fileUrl;
                }
            },

            save() {
                let params = this.companyInfo;

                this.$store.dispatch('companyInfoSave', params).then( (resp)=> {
                    console.log('companyInfoSave request success!');
                    this.serverResp = resp.data;
                    this.initCompanyInfo();
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            }
        }
    }
</script>
