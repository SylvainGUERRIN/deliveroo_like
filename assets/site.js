/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/site/globals.scss';

// start the Stimulus application
import './bootstrap';

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
                $(".navbar").css('background-color', '#2e3333');
                $(".navbar").css('border-bottom', 'solid 1px #000000');
            } else {
                $('.navbar').css('background-color', '#585a5a');
                $(".navbar").css('border-bottom', 'solid 1px #585a5a');
            }
        });
    }
});
