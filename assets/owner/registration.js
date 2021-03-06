// any SCSS you import will output into a single scss file (app.scss in this case)
import './../styles/owner/registration.scss';

//owl-carousel
$(".owl-present").owlCarousel({
    center:true,
    // items:4,
    loop:false,
    rewind:true,
    margin: 20,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        900:{
            items:1,
            nav:false
        },
        1200:{
            items:1,
            nav:false
        }
    },
    autoHeight:false,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    dots:false,
    nav:false,
});

$(".owl-partnership").owlCarousel({
    center:true,
    // items:4,
    loop:false,
    rewind:true,
    // margin: 20,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        900:{
            items:1,
            nav:false
        },
        1200:{
            items:1,
            nav:false
        }
    },
    autoHeight:false,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    dots:false,
    nav:false,
});
