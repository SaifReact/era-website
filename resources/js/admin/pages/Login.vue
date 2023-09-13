<template>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <img src="/images/admin/logo/logo.png" alt="Logo" srcset="" />
                </div>
                <h1 class="auth-title">Log in new page.</h1>
                <p class="auth-subtitle mb-5" :style="(serverResp.status===true) ? 'color: green;' : 'color: red;'">{{ serverResp.message }}</p>
                <validation-observer ref="form" v-slot="{ handleSubmit }">
                    <form method="post" @submit.prevent="handleSubmit(authenticate)">
                        <validation-provider name="email" rules="required|min:8|max:100|email" v-slot="{ dirty, valid, invalid, errors }">
                            <div class="form-group">
                                <div class="form-group position-relative has-icon-left mb-1">
                                    <input type="email" class="form-control form-control-xl" placeholder="E-mail" v-model="credential.email" name="email">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                            </div>
                        </validation-provider>
                        <validation-provider name="password" rules="required|min:8|max:50" v-slot="{ dirty, valid, invalid, errors }">
                            <div class="form-group">
                                <div class="form-group position-relative has-icon-left mb-1">
                                    <input type="password" class="form-control form-control-xl" placeholder="Password" v-model="credential.password" name="password" autocomplete="off">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                            </div>
                        </validation-provider>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-1">Log in</button>
                    </form>
                </validation-observer>
                <div class="text-center mt-5 text-lg fs-4">
                    <p><router-link to="/auth/forgot-password" class="font-bold">Forgot password?</router-link>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                credential: {
                    email: '',
                    password: ''
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        methods: {
            initCred() {
                this.credential.email = '';
                this.credential.password = '';
            },
            authenticate() {
                let currObj = this;
                let params = this.credential;

                this.$store.dispatch('login', params).then( (resp)=> {
                    console.log('login request success!');
                    if(resp.data.status) {
                        currObj.$router.push(currObj.$route.query.redirect||'/company-infos');
                    }
                    this.serverResp = resp.data;
                }).catch(err => {
                    currObj.serverResp = err.response.data;
                    currObj.$refs.form.setErrors(err.response.data.errors);
                });
            }
        }
    }
</script>
