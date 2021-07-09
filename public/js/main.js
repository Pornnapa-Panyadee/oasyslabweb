$(()=>{
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        autoplay: true,
        autoplaySpeed: 5000,
        lazyLoad: 'ondemand',
        centerMode: true,
        centerPadding: '5rem',
        focusOnSelect: true
    });
})