<template>
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <img src="/images/admin/logo/logo.png" alt="Logo" srcset="" />
                    </div>
                    <div class="toggler">
                        <a href="#" @click.prevent class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item" :class='setActive("/company-infos")'>
                        <router-link to='/company-infos' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Company Info</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/contacts")'>
                        <router-link to='/contacts' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Contact</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/locations")'>
                        <router-link to='/locations' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Location</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item has-sub" :class='setActive("/front-page")'>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-stack"></i>
                            <span>Front Page</span>
                        </a>
                        <ul class="submenu" :class='setActive("/front-page")' style="display:block;">
                            <li class="submenu-item" :class='setActive("/front-page/banners")'>
                                <router-link to='/front-page/banners'>Banners</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/resources")'>
                                <router-link to='/front-page/resources'>Resources</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/market-concentrations")'>
                                <router-link to='/front-page/market-concentrations'>Market Concentrations</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/about-us")'>
                                <router-link to='/front-page/about-us'>About Us</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/client-categories")'>
                                <router-link to='/front-page/client-categories'>Client Categories</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/clients")'>
                                <router-link to='/front-page/clients'>Clients</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/products")'>
                                <router-link to='/front-page/products'>Products</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/portfolio-categories")'>
                                <router-link to='/front-page/portfolio-categories'>Port. Categories</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/portfolios")'>
                                <router-link to='/front-page/portfolios'>Portfolios</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/testimonials")'>
                                <router-link to='/front-page/testimonials'>Testimonials</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/events")'>
                                <router-link to='/front-page/events'>Events</router-link>
                            </li>
                            <li class="submenu-item" :class='setActive("/front-page/managements")'>
                                <router-link to='/front-page/managements'>Managements</router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item" :class='setActive("/pages")'>
                        <router-link to='/pages' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Pages</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/menus")'>
                        <router-link to='/menus' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Menus</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/users")'>
                        <router-link to='/users' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Users</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/assets")'>
                        <router-link to='/assets' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Assets</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/email-configs")'>
                        <router-link to='/email-configs' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>E-mail Configs</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#" @click.prevent="clearViewCache">
                            <i class="bi bi-grid-fill"></i>
                            <span>Clear Cache</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#" @click.prevent="reconfirmMaintenance">
                            <i class="bi" :class="toggleClass"></i>
                            <span>Maintenance: {{ getStatus() }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
</template>
<script>
    import CommonRepository from '../../repositories/CommonRepository';

    export default {
        name: "Sidenav",
        data() {
            return {
                maintenance_status: false,
                toggleClass: false,
            }
        },

        mounted() {
            this.initMaintenanceStatus();
        },

        methods: {
            initMaintenanceStatus() {
                this.$store.dispatch('showMaintenanceStatus').then((resp) => {
                    console.log('showMaintenanceStatus request success!');
                    this.serverResp = resp.data;
                    this.maintenance_status = resp.data.data.maintenance_status;
                    this.setClass();
                }).catch(err => {
                    console.log(err.response.data);
                    this.setClass();
                });
            },

            setActive(input) {
                if (this.subIsActive(input)) {
                    return ' active ';
                }
            },

            subIsActive(input) {
                const paths = Array.isArray(input) ? input : [input];
                return paths.some(path => {
                    return this.$route.path.indexOf(path) === 0;
                });
            },

            clearViewCache() {
                this.$store.dispatch('clearViewCache').then((resp) => {
                    console.log('clearViewCache request success!');
                    this.serverResp = resp.data;
                }).catch(err => {
                    console.log(err.response.data);
                });
            },

            setClass() {
                let cls = (this.maintenance_status) ? ' bi-toggle-on text-danger' : ' bi-toggle-off text-success';
                this.toggleClass = cls;
            },

            getStatus() {
                return (this.maintenance_status) ? 'on' : 'off';
            },

            getToggleCommand() {
                return (this.maintenance_status) ? 'off' : 'on';
            },

            reconfirmMaintenance() {
                CommonRepository.reconfirmMaintenance(this.maintenance, {
                    command: this.getToggleCommand(),
                });
            },

            maintenance(params) {
                return this.$store.dispatch('maintenance', params).then((resp) => {
                    console.log('maintenance request success!');
                    this.serverResp = resp.data;
                    this.maintenance_status = !this.maintenance_status;
                    this.setClass();
                    return resp;
                }).catch(err => {
                    console.log(err.response.data);
                    return Promise.reject(err);
                });
            }
        }
    }
</script>
