<template>
    <div>
        <vue-topprogress ref="topProgress" :color="progressBareColor" :errorColor="errorColor" ></vue-topprogress>
        <router-view/>
    </div>
</template>

<script>
    import Auth from './Auth';
    import { vueTopprogress } from 'vue-top-progress';
    import { mapState } from 'vuex';

    export default {
        name: "App",
        data() {
            return {
                "progressBar":{},
                "progressBareColor": "#fce300",
                "errorColor": "red",
                "request": 0,
            }
        },
        watch: {
            refCount: function(newVal, oldVal) {
                if (newVal == 0) {
                    this.$refs.topProgress.done();
                }
            }
        },
        computed: {
            ...mapState(['isLoading', 'refCount']),
        },
        components: {
            'Auth': Auth,
            vueTopprogress,
        },
        created() {
            this.$axios.interceptors.request.use((config) => {
                this.$store.commit('loading', true);
                this.$refs.topProgress.start();
                return config;
            }, (error) => {
                this.$store.commit('loading', false);
                this.$refs.topProgress.fail();
                return Promise.reject(error);
            });

            this.$axios.interceptors.response.use((response) => {
                this.$store.commit('loading', false);
                return response;
            }, (error) => {
                this.$store.commit('loading', false);
                this.$refs.topProgress.fail();
                return Promise.reject(error);
            });
        },
        methods: {}
    }
</script>
