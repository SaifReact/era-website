<template>
    <div id="app">
        <Sidenav />

        <div id="main" class="layout-navbar">
            <Header />
            <div id="main-content">
                <router-view/>
                <Footer />
            </div>
        </div>
    </div>
</template>

<script>
    import Sidenav from "./partials/Sidenav";
    import Header from "./partials/Header";
    import Footer from "./partials/Footer";
    import PerfectScrollbar from "perfect-scrollbar";

    export default {
        name: "Protected",
        mounted() {
            this.init();
        },
        data() {
            return {
                //
            }
        },
        components: {
            'Sidenav': Sidenav,
            'Header': Header,
            'Footer': Footer,
        },
        created() {
        },
        methods: {
            init: function() {
                let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
                let that = this;
                for(var i = 0; i < sidebarItems.length; i++) {
                    let sidebarItem = sidebarItems[i];
                    sidebarItems[i].querySelector('.sidebar-link').addEventListener('click', function(e) {
                        e.preventDefault();

                        let submenu = sidebarItem.querySelector('.submenu');
                        if( submenu.classList.contains('active') ) submenu.style.display = "block"

                        if( submenu.style.display === "none" ) submenu.classList.add('active')
                        else submenu.classList.remove('active')
                        that.slideToggle(submenu, 300)
                    })
                }

                window.addEventListener('DOMContentLoaded', (event) => {
                    var w = window.innerWidth;
                    if(w < 1200) {
                        document.getElementById('sidebar').classList.remove('active');
                    }
                });

                window.addEventListener('resize', (event) => {
                    var w = window.innerWidth;
                    if(w < 1200) {
                        document.getElementById('sidebar').classList.remove('active');
                    }else{
                        document.getElementById('sidebar').classList.add('active');
                    }
                });

                document.querySelector('.burger-btn').addEventListener('click', () => {
                    document.getElementById('sidebar').classList.toggle('active');
                })

                document.querySelector('.sidebar-hide').addEventListener('click', () => {
                    document.getElementById('sidebar').classList.toggle('active');

                })

                // Perfect Scrollbar Init
                if(typeof PerfectScrollbar == 'function') {
                    const container = document.querySelector(".sidebar-wrapper");
                    const ps = new PerfectScrollbar(container, {
                        wheelPropagation: false
                    });
                }

                // Scroll into active sidebar
                document.querySelector('.sidebar-item.active').scrollIntoView(false)
            },

            slideToggle: function (t, e, o) {
                0 === t.clientHeight ? this.j(t, e, o, !0) : this.j(t, e, o)
            },

            slideUp: function(t, e, o) {
                this.j(t, e, o)
            },

            slideDown: function(t, e, o) {
                this.j(t, e, o, !0)
            },

            j: function(t, e, o, i) {
                void 0 === e && (e = 400), void 0 === i && (i = !1), t.style.overflow = "hidden", i && (t.style.display = "block");
                var p, l = window.getComputedStyle(t), n = parseFloat(l.getPropertyValue("height")),
                    a = parseFloat(l.getPropertyValue("padding-top")), s = parseFloat(l.getPropertyValue("padding-bottom")),
                    r = parseFloat(l.getPropertyValue("margin-top")), d = parseFloat(l.getPropertyValue("margin-bottom")),
                    g = n / e, y = a / e, m = s / e, u = r / e, h = d / e;
                window.requestAnimationFrame(function l(x) {
                    void 0 === p && (p = x);
                    var f = x - p;
                    i ? (t.style.height = g * f + "px", t.style.paddingTop = y * f + "px", t.style.paddingBottom = m * f + "px", t.style.marginTop = u * f + "px", t.style.marginBottom = h * f + "px") : (t.style.height = n - g * f + "px", t.style.paddingTop = a - y * f + "px", t.style.paddingBottom = s - m * f + "px", t.style.marginTop = r - u * f + "px", t.style.marginBottom = d - h * f + "px"), f >= e ? (t.style.height = "", t.style.paddingTop = "", t.style.paddingBottom = "", t.style.marginTop = "", t.style.marginBottom = "", t.style.overflow = "", i || (t.style.display = "none"), "function" == typeof o && o()) : window.requestAnimationFrame(l)
                })
            }
        }
    }
</script>
