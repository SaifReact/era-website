(()=>{function e(e){return function(e){if(Array.isArray(e))return t(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,i){if(!e)return;if("string"==typeof e)return t(e,i);var a=Object.prototype.toString.call(e).slice(8,-1);"Object"===a&&e.constructor&&(a=e.constructor.name);if("Map"===a||"Set"===a)return Array.from(e);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return t(e,i)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function t(e,t){(null==t||t>e.length)&&(t=e.length);for(var i=0,a=new Array(t);i<t;i++)a[i]=e[i];return a}!function(){"use strict";$(".ajax-lazy").Lazy({afterLoad:function(e){e.siblings(".spinner").hide()},enableThrottle:!0,throttle:1});var t=function(t){var i=arguments.length>1&&void 0!==arguments[1]&&arguments[1];return t=t.trim(),i?e(document.querySelectorAll(t)):document.querySelector(t)},i=function(e,i,a){var n=arguments.length>3&&void 0!==arguments[3]&&arguments[3];n?t(i,n).forEach((function(t){return t.addEventListener(e,a)})):t(i,n).addEventListener(e,a)},a=function(e,t){e.addEventListener("scroll",t)},n=t("#navbar .scrollto",!0),o=function(){var e=window.scrollY+200;n.forEach((function(i){if(i.hash){var a=t(i.hash);a&&(e>=a.offsetTop&&e<=a.offsetTop+a.offsetHeight?i.classList.add("active"):i.classList.remove("active"))}}))};window.addEventListener("load",o),a(document,o);var r=function(e){var i=t("#header"),a=i.offsetHeight;i.classList.contains("header-scrolled")||(a-=10);var n=t(e).offsetTop;window.scrollTo({top:n-a,behavior:"smooth"})},l=t("#header");if(l){var s=function(){window.scrollY>100?l.classList.add("header-scrolled"):l.classList.remove("header-scrolled")};window.addEventListener("load",s),a(document,s)}var c=t(".back-to-top");if(c){var d=function(){window.scrollY>100?c.classList.add("active"):c.classList.remove("active")};window.addEventListener("load",d),a(document,d)}i("click",".mobile-nav-toggle",(function(e){t("#navbar").classList.toggle("navbar-mobile"),this.classList.toggle("bi-list"),this.classList.toggle("bi-x")})),i("click",".navbar .dropdown > a",(function(e){t("#navbar").classList.contains("navbar-mobile")&&(e.preventDefault(),this.nextElementSibling.classList.toggle("dropdown-active"))}),!0),i("click",".scrollto",(function(e){if(t(this.hash)){e.preventDefault();var i=t("#navbar");if(i.classList.contains("navbar-mobile")){i.classList.remove("navbar-mobile");var a=t(".mobile-nav-toggle");a.classList.toggle("bi-list"),a.classList.toggle("bi-x")}r(this.hash)}}),!0),window.addEventListener("load",(function(){window.location.hash&&t(window.location.hash)&&r(window.location.hash)})),window.addEventListener("load",(function(){var e=t(".gallery-container");if(e){var a=new Isotope(e,{itemSelector:".gallery-item",layoutMode:"fitRows"}),n=t("#gallery-flters li",!0);i("click","#gallery-flters li",(function(e){e.preventDefault(),n.forEach((function(e){e.classList.remove("filter-active")})),this.classList.add("filter-active"),a.arrange({filter:this.getAttribute("data-filter")}),f()}),!0)}}));GLightbox({selector:".gallery-lightbox"});function f(){AOS.init({duration:1e3,easing:"ease-in-out",once:!0,mirror:!1})}new Swiper(".gallery-details-slider",{speed:400,autoplay:{delay:5e3,disableOnInteraction:!1},pagination:{el:".swiper-pagination",type:"bullets",clickable:!0}}),new Swiper(".testimonials-slider",{speed:600,loop:!0,autoplay:{delay:5e3,disableOnInteraction:!1},slidesPerView:"auto",pagination:{el:".swiper-pagination",type:"bullets",clickable:!0},breakpoints:{320:{slidesPerView:1,spaceBetween:40},1200:{slidesPerView:3}}}),window.addEventListener("load",(function(){f()}));var u=t("#hero-carousel-indicators");t("#heroCarousel .carousel-item",!0).forEach((function(e,t){u.innerHTML+=0===t?"<li data-bs-target='#heroCarousel' data-bs-slide-to='"+t+"' class='active'></li>":"<li data-bs-target='#heroCarousel' data-bs-slide-to='"+t+"'></li>"}))}()})();