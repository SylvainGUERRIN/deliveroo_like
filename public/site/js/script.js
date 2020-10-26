$(document).ready(function () {
    // $("#sidebar").mCustomScrollbar({
    //     theme: "minimal"
    // });

    //script for sidebar
    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        // $('.collapse.in').toggleClass('in');
        // $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    //script for navbar change color on scroll
    let scroll_start = 0;
    let startChange = $('#startChange');
    let offset = startChange.offset();
    if (startChange.length){
        $(document).scroll(function() {
            scroll_start = $(this).scrollTop();
            if(scroll_start > offset.top) {
                $(".navbar-head").css('background-color', '#026b62');
                $(".navbar-head").css('border-bottom', 'solid 1px #000000');
            } else {
                $('.navbar-head').css('background-color', 'transparent');
                $(".navbar-head").css('border-bottom', 'solid 1px transparent');
            }
        });
    }
});
