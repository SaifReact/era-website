<template>
    <!--<div id="header">
        <header class="mb-3 bg-primary">
            <nav class="navbar navbar-default pt-0">
                <a href="#" class="burger-btn d-block d-xl-none" @click.prevent>
                    <i class="bi bi-justify fs-3 text-white"></i>
                </a>
                <div class="navbar-menu-wrapper d-flex align-items-center">
                    <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
                        <li class="nav-item">
                            <a class="nav-link profile-pic" href="#">
                                &lt;!&ndash;<img class="rounded-circle" src="{{ url("/images/admin/faces/face.jpg") }}" alt="profile-photo">&ndash;&gt;
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-th"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>-->
    <header class="mb-3 bg-primary">
        <nav class="navbar navbar-expand navbar-light">
            <div class="container-fluid">
                <a href="#" class="burger-btn d-block" @click.prevent>
                    <i class="bi bi-justify fs-3 text-white"></i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav ms-auto mb-2 mb-lg-0"></div>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-menu d-flex">
                                <div class="user-name text-end me-3">
                                    <h6 class="mb-0 text-white">{{ this.user.first_name + ' ' + this.user.last_name }}</h6>
                                    <p class="mb-0 text-sm text-white">Administrator</p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <img :src="this.user.photo" v-if="this.user.photo">
                                        <img :src="'../../../../images/admin/faces/1.jpg'" v-else>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Hello, {{ this.user.first_name + ' ' + this.user.last_name }}!</h6>
                            </li>
                            <li>
                                <router-link to='/users/profile' class="dropdown-item">
                                    <i class="icon-mid bi bi-person me-2"></i>My Profile
                                </router-link>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" @click.prevent="logout">
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
<script>
    export default {
        name: "Header",
        data() {
            return {
                user: {
                    email: '',
                    first_name: '',
                    last_name: '',
                    name: '',
                    photo: ''
                }
            };
        },
        mounted() {
            this.userInfo();
        },
        methods: {
            userInfo() {
                this.$store.dispatch('userInfo').then((resp) => {
                    this.user = resp.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },
            logout() {
                this.$store.dispatch('logout').then((resp) => {
                    if (resp.data.status) {
                        this.$router.push('/auth/login');
                    }
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
