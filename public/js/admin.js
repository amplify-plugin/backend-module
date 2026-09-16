/**
 * This file hold all js that will load on admin panel
 */

$(document).ready(function () {
    $('.large_text_toggle_button').on('click', function () {
        if ($('.large_text').hasClass('d-none')) {
            $('.large_text').removeClass('d-none');
            $('.large_text_toggle_button').removeClass('btn-primary').addClass('btn-secondary').html('Hide Content');
        } else {
            $('.large_text').addClass('d-none');
            $('.large_text_toggle_button').removeClass('btn-secondary').addClass('btn-primary').html('Show Content');
        }
    });

    $(window).on('scroll', function () {
        if (window.scrollY > 55) {
            document.querySelector('.sidebar-pills').classList.add('top');
        } else {
            document.querySelector('.sidebar-pills').classList.remove('top');
        }
    });
});
