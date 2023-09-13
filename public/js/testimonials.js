new Swiper(".testimonials-slider", {
    speed: 600,
    loop: !0,
    autoplay: { delay: 5e3, disableOnInteraction: !1 },
    slidesPerView: "auto",
    pagination: { el: ".swiper-pagination", type: "bullets", clickable: !0 },
    breakpoints: {
        320: { slidesPerView: 1, spaceBetween: 40 }
    },
    watchOverflow: !0
});
