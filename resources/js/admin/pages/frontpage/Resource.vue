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
                            <h3 class="card-title">Resources</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form form-vertical" method="post" @submit.prevent="handleSubmit(save)">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <validation-provider name="commencement" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="commencement">Commencement</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="resource.commencement" name="commencement" placeholder="Commencement" id="commencement" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <validation-provider name="number_of_installation" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="number_of_installation">Number of Installation</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="resource.number_of_installation" name="number_of_installation" placeholder="Number of Installation" id="number_of_installation" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <validation-provider name="customers" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="customers">Customers</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="resource.customers" name="customers" placeholder="Customers" id="customers" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <validation-provider name="team_members" rules="required|numeric" v-slot="{ dirty, valid, invalid, errors }">
                                                    <div class="form-group has-icon-left">
                                                        <label for="team_members">Team Members</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-xl" v-model="resource.team_members" name="team_members" placeholder="Team Members" id="team_members" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                    </div>
                                                </validation-provider>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary my-1 btn-lg">Submit</button>
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
    import CommonRepository from '../../repositories/CommonRepository';

    export default {
        name: "Resource",
        data() {
            return {
                resource: {
                    commencement: null,
                    number_of_installation: null,
                    customers: null,
                    team_members: null
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },

        methods: {
            initResource() {
                this.$nextTick(() => {
                    this.resource = {
                        commencement: null,
                        number_of_installation: null,
                        customers: null,
                        team_members: null
                    };
                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            save() {
                let params = this.resource;

                this.$store.dispatch('resourceSave', params).then( (resp)=> {
                    console.log('resourceSave request success!');
                    this.serverResp = resp.data;
                    this.initResource();
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            }
        }
    }
</script>
