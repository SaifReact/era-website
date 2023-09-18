new Swiper(".products-slider", {
    speed: 600,
    loop: !0,
    autoplay: { delay: 5e3, disableOnInteraction: !1 },
    slidesPerView: "auto",
    pagination: { el: ".swiper-pagination", type: "bullets", clickable: !0 },
    breakpoints: {
        360: { slidesPerView: 1, spaceBetween: 40 },
        992: { slidesPerView: 3, spaceBetween: 30 },
        1200: { slidesPerView: 4, spaceBetween: 30 }
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    },
    keyboard: {
        enabled: true,
        onlyInViewport: false
    },
    watchOverflow: !0
});
