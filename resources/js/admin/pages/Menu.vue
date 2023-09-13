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
                    <!--<pre>{{ menu }}</pre><br />
                    <pre>{{ pages }}</pre><br />
                    <pre>{{ selectedPages }}</pre><br />
                    <pre>{{ menuItems }}</pre><br />-->
                    <div v-if="menu.id">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex">
                                            <div class="d-flex justify-content-between"><h3>Selected Menu:</h3></div>
                                            <div class="d-flex justify-content-between"><h3>{{ menu.name }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Add Menu Items</h4>
                                    </div>
                                    <div class="card-body">
                                        <badger-accordion>

                                            <badger-accordion-item v-if="pages.length > 0">
                                                <template slot="header"><div class="p-2"><h6 class="text-white">Pages</h6></div></template>
                                                <template slot="content">
                                                    <form name="page_add_form" id="page_add_form" @submit.prevent="addPageToMenu">
                                                        <ul class="list-group" v-if="pages">
                                                            <li class="list-group-item" v-for="page in pages">
                                                                <label class="menu-item-title checkbox">
                                                                    <input type="checkbox"
                                                                           v-model="selectedPages"
                                                                           :id="'selected_pages_' + page.title"
                                                                           class="form-check-input"
                                                                           name="menu-item[page]"
                                                                           :value="page">
                                                                    <span class="post-state">{{ page.title }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary" name="add_page_to_menu" id="add_page_to_menu">
                                                                    + Add to Menu
                                                                </button>
                                                            </li>
                                                        </ul>
                                                        <div v-else>
                                                            No page available.
                                                        </div>
                                                    </form>
                                                </template>
                                            </badger-accordion-item>

                                            <badger-accordion-item>
                                                <template slot="header"><div class="p-2"><h6 class="text-white">Custom Links</h6></div></template>
                                                <template slot="content">
                                                    <form name="custom_url_add_form" id="custom_url_add_form"  @submit.prevent="addCustomLinkToMenu">
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <div class="form-group">
                                                                    <label for="external_url">URL</label>
                                                                    <input type="text" required class="form-control" name="external_url" id="external_url" v-model="customLink.external_url" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="title">Title</label>
                                                                    <input type="text" required class="form-control" name="title" id="title" v-model="customLink.title" />
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary" name="add_custom_link_to_menu" id="add_custom_link_to_menu">
                                                                    + Add to Menu
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </form>
                                                </template>
                                            </badger-accordion-item>
                                        </badger-accordion>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9" v-if="menuItems.length > 0">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Menu Structure</h4>
                                    </div>
                                    <div class="card-body">
                                        <form name="add_menu_items_to_menu" id="add_menu_items_to_menu" @submit.prevent="addMenuItems">
                                            <Tree :value="menuItems" draggable droppable>
                                                <div slot-scope="{node, index, path, tree}">
                                                    <div class="row">
                                                        <div class="col-6 border shadow rounded g-0">
                                                            <div class="rounded-top bg-primary menu-header-border-bottom text-white" @click="node.show = !node.show">
                                                                <div class="row p-3 g-0">
                                                                    <div class="col-8"><div class="d-flex justify-content-start"><h6 class="text-white">{{node.original_name}}</h6></div></div>
                                                                    <div class="col-4"><div class="d-flex justify-content-end"><span>{{ node.type }}</span></div></div>
                                                                </div>
                                                            </div>
                                                            <transition name="slide">
                                                                <div class="m-2 text-dark" v-if="node.show">
                                                                    <div v-if="isCustomLink(node.type)">
                                                                        <label :for="'menuItem['+node.type+']['+node.original_name+'][external_url]'">URL</label>
                                                                        <input type="text" required class="form-control" :id="'menuItem['+node.type+']['+node.original_name+'][external_url]'" :name="'menuItem['+node.type+']['+node.original_name+'][external_url]'" v-model="node.external_url" />
                                                                    </div>
                                                                    <div>
                                                                        <label :for="'menuItem['+node.type+']['+node.original_name+'][name]'">Navigation Label</label>
                                                                        <input type="text" required class="form-control" :id="'menuItem['+node.type+']['+node.original_name+'][name]'" :name="'menuItem['+node.type+']['+node.original_name+'][name]'" v-model="node.name" />
                                                                    </div>

                                                                    <div>
                                                                        <label :for="'menuItem['+node.type+']['+node.original_name+'][target]'">Target</label>
                                                                        <select class="form-control" required :id="'menuItem['+node.type+']['+node.original_name+'][target]'" v-model="node.target">
                                                                            <option :value="target" v-for="target in targets">{{ target }}</option>
                                                                        </select>
                                                                    </div>

                                                                    <div v-if="!isCustomLink(node.type)">
                                                                        <span>Original: </span><span>{{ node.original_name }}</span>
                                                                    </div>

                                                                    <a class="btn btn-link" @click="tree.removeNodeByPath(path)">Remove</a>
                                                                </div>
                                                            </transition>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Tree>
                                            <div class="row g-0">
                                                <div class="col-6 g-0">
                                                    <button type="submit" class="btn btn-success btn-block btn-lg g-0" name="save_menu_items_to_menu" id="save_menu_items_to_menu">Save Menu</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>Edit a menu from the list!</h4>
                            </div>
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
                            <h3 class="card-title">List of Menus</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableMenus"  class="table-default" :columns="table.columns"
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
    import CommonRepository from '../repositories/CommonRepository';
    import ActionButtonGroup from '../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT } from '../repositories/ActionButtonsRepository';
    import { PAGE, CUSTOM } from '../repositories/PageTypeRepository';
    import { BLANK, SELF, PARENT, TOP } from '../repositories/PageTargetRepository';
    import {BadgerAccordion, BadgerAccordionItem} from 'vue-badger-accordion';
    import {Tree, // Base tree
        Fold, Check, Draggable, // plugins
        foldAll, unfoldAll, cloneTreeData, walkTreeData, getPureTreeData, // utils
    } from 'he-tree-vue';
    import 'he-tree-vue/dist/he-tree-vue.css';

    export default {
        name: "Menu",
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
                            label: 'Slug',
                            name: 'slug',
                            orderable: true,
                        },
                        {
                            label: 'Order',
                            name: 'order',
                            orderable: true,
                        },
                        {
                            label: 'Actions',
                            name: JSON.stringify({
                                buttons: [
                                    { name: EDIT, iconClass: "bi bi-pencil-square" },
                                ],
                            }),
                            data: {
                                EDIT: EDIT
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
                    url: '/api/admin/menus',
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
                menu: {
                    name: '',
                    slug: '',
                    order: null,
                    id: null,
                },
                pages: [],
                selectedPages: [],
                menuItems: [],
                customLink: {
                    external_url: '',
                    title: '',
                },
                targets: [
                    SELF,
                    BLANK,
                    PARENT,
                    TOP
                ],
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false
            }
        },
        created() {
        },
        components: {
            'BadgerAccordion': BadgerAccordion,
            'BadgerAccordionItem': BadgerAccordionItem,
            Tree: Tree.mixPlugins([Draggable]),
            Fold, Check,
            foldAll,
            unfoldAll,
            cloneTreeData,
            walkTreeData,
            getPureTreeData,
        },
        methods: {
            initCustomLink() {
                this.customLink = {
                    external_url: '',
                    title: '',
                }
            },

            initMenu() {
                this.menu = {
                    name: '',
                    slug: '',
                    order: null,
                    id: null,
                };
            },

            resetDataObjects() {
                this.pages = [];
                this.selectedPages = [];
                this.menuItems = [];
                this.initCustomLink();
            },

            reloadDatatable() {
                this.$refs.tableMenus.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                }
            },

            editHandler(params) {
                this.resetDataObjects();
                this.$store.dispatch('menuShow', params).then( (resp)=> {
                    console.log('menuShow request success!');
                    this.serverResp = resp.data;
                    this.menu = resp.data.data.menu;
                    this.menuItems = resp.data.data.menuItems;
                    this.pages = resp.data.data.pages;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            addPageToMenu() {
                if(this.selectedPages.length > 0) {
                    this.selectedPages.forEach( (page) => {
                        this.createPageMenuItem(page);
                    });
                }

                this.selectedPages = [];
            },

            createPageMenuItem(item) {
                let pageMenuItem = {
                    type: PAGE,
                    show: false,
                    name: item.title,
                    original_name: item.title,
                    external_url: '',
                    target: '',
                    menu_id: this.menu.id,
                    page_id: item.id,
                    id: null
                };

                this.menuItems.push(pageMenuItem);
            },

            createCustomLinkMenuItem(item) {
                let customLinkMenuItem = {
                    type: CUSTOM,
                    show: false,
                    name: item.title,
                    original_name: item.title,
                    external_url: item.external_url,
                    target: '',
                    menu_id: this.menu.id,
                    page_id: null,
                    id: null
                };

                this.menuItems.push(customLinkMenuItem);
            },

            addCustomLinkToMenu() {
                this.createCustomLinkMenuItem(this.customLink);
                this.initCustomLink();
            },

            isCustomLink(nodeType) {
                return (nodeType === CUSTOM);
            },

            addMenuItems() {
                this.$store.dispatch('menuItemBalkStore', {menuItems: this.menuItems, menu: this.menu}).then( (resp)=> {
                    console.log('menuItemBalkStore request success!');
                    this.serverResp = resp.data;
                    this.resetDataObjects();
                    this.initMenu();
                }).catch(err => {
                    this.serverResp = err.response.data;
                });
            },
        }
    }
</script>


<style>
    .he-tree .tree-node {
        border: none;
        border-radius: 5px;
    }

    .slide-enter-active {
        -moz-transition-duration: 0.3s;
        -webkit-transition-duration: 0.3s;
        -o-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -moz-transition-timing-function: ease-in;
        -webkit-transition-timing-function: ease-in;
        -o-transition-timing-function: ease-in;
        transition-timing-function: ease-in;
    }

    .slide-leave-active {
        -moz-transition-duration: 0.3s;
        -webkit-transition-duration: 0.3s;
        -o-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -moz-transition-timing-function: ease-out;
        -webkit-transition-timing-function: ease-out;
        -o-transition-timing-function: ease-out;
        transition-timing-function: ease-out;
    }

    /*.slide-leave-active {
        -moz-transition-duration: 0.3s;
        -webkit-transition-duration: 0.3s;
        -o-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }*/

    .slide-enter-to, .slide-leave {
        max-height: 100px;
        overflow: hidden;
    }

    .slide-enter, .slide-leave-to {
        overflow: hidden;
        max-height: 0;
    }

    .bg-lightgrey {
        background: #f6f7f7;
    }

    .menu-header-border-bottom {
        border-bottom: 1px solid #dcdcde;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .js-badger-accordion-header {
        background:#435ebe !important;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        padding: 0 10px;
    }

    .badger-toggle-indicator {
        color: white;
        font-weight: 800;
    }

    .badger-accordion-title {
        margin-top: 5px;
    }
</style>
