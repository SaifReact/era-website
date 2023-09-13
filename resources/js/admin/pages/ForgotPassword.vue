<template>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <img src="/images/admin/logo/logo.png" alt="Logo" srcset="" />
                </div>
                <h1 class="auth-title">Forgot Password.</h1>
                <p class="auth-subtitle mb-5" :style="(serverResp.status===true) ? 'color: green;' : 'color: red;'">{{ serverResp.message }}</p>
                <validation-observer v-slot="{ handleSubmit }">
                    <form method="post" @submit.prevent="handleSubmit(sendForgotPasswordLink)">
                        <validation-provider name="email" rules="required|max:8|max:100|email" v-slot="{ dirty, valid, invalid, errors }">
                            <div class="form-group">
                                <div class="form-group position-relative has-icon-left mb-1">
                                    <input type="email" class="form-control form-control-xl" placeholder="E-mail" v-model="forgotPassword.email" name="email" autocomplete="off" />
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                            </div>
                        </validation-provider>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-1" :disabled="disabled">Send</button>
                    </form>
                </validation-observer>
                <div class="text-center mt-5 text-lg fs-4">
                    <p>Go to <router-link to="/auth/login" class="font-bold" :disabled="disabled">Login</router-link>.</p>
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
        name: "ForgotPassword",
        data() {
            return {
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                forgotPassword: {
                    email: ''
                },
                disabled: false,
            }
        },
        created() {
        },
        methods: {
            sendForgotPasswordLink() {
                let params = this.forgotPassword;
                this.disabled = true;

                this.$store.dispatch('sendForgotPasswordLink', params).then( (resp)=> {
                    console.log('sendForgotPasswordLink success!');
                    this.serverResp = resp.data;
                    this.disabled = false;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    this.forgotPassword.email = '';
                    this.disabled = false;
                });
            }
        }
    }
</script>
