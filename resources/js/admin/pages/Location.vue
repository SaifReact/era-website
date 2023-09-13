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
                            <h3 class="card-title">Location</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <validation-provider name="location_name" rules="min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="location_name">Location Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="lokation.location_name" name="location_name" placeholder="Location Name" id="location_name" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="address" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="address">Address</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="lokation.address" name="address" placeholder="Address" id="address">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="map_location" rules="min:14|max:500|url" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="map_location">Map URL</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="lokation.map_location" name="map_location" placeholder="Map URL" id="map_location">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="lat" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="lat">Latitude</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="lokation.lat" name="lat" placeholder="Latitude" id="lat">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <validation-provider name="lng" rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="lng">Longitude</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="lokation.lng" name="lng" placeholder="Longitude" id="lng">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
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
                                </form>
                            </validation-observer>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import CommonRepository from '../repositories/CommonRepository';

    export default {
        name: 'Location',
        data() {
            return {
                lokation: {
                    location_name: '',
                    address: '',
                    map_location: '',
                    lat: '',
                    lng: '',
                    id: null
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        mounted() {
            this.initAll();
        },
        methods: {
            initAll() {
                this.fetchLocation();
            },

            fetchLocation() {
                this.$store.dispatch('locationShow').then( (resp)=> {
                    console.log('locationShow request success!');
                    if(resp.data.data) {
                        this.lokation = resp.data.data;
                    }
                }).catch( err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            initLocation() {
                this.$nextTick(() => {
                    this.lokation = {
                        location_name: '',
                        address: '',
                        map_location: '',
                        lat: '',
                        lng: '',
                        id: null
                    };
                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            save() {
                let params = this.lokation;

                this.$store.dispatch('locationUpdate', params).then( (resp)=> {
                    console.log('locationUpdate request success!');
                    this.serverResp = resp.data;
                    this.lokation = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            }
        },
    }
</script>
