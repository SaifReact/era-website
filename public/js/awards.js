new Swiper(".awards-slider", {
    speed: 600,
    loop: !0,
    autoplay: { delay: 5e3, disableOnInteraction: !1 },
    slidesPerView: "auto",
    pagination: { el: ".swiper-pagination", type: "bullets", clickable: !0 },
    breakpoints: {
        360: { slidesPerView: 1, spaceBetween: 0 },
        768: { slidesPerView: 1, spaceBetween: 0 },
        992: { slidesPerView: 2, spaceBetween: 10 },
        1024: { slidesPerView: 2, spaceBetween: 10 }
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
