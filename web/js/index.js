/*$('#signup-btn').on('click', function() {
    //location.href = 'site/signup';
    $.ajax({
        method: 'GET',
        url: 'site/signup',
    }).done(function(response) {
        if (!response) {
            return false;
        }
        if ($(".modal").length === 0) {
            $("body").append(response);
            //$(".modal").addClass('show');
            //$(".modal").css('display', 'block');
        }
    });


});*/


$(document).ready(function() {
    $('#signup-btn').click(function() {
        $.ajax({
            method: 'GET',
            url: '/site/open-signup',
        }).done(function(response) {
            if (!response) {
                return false;
            }
            $('.popup-body').html(response);
        });
        $('.popup-fade').fadeIn();
        return false;
    });

    $('.popup-close').click(function() {
        $(this).parents('.popup-fade').fadeOut();
        return false;
    });

    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            $('.popup-fade').fadeOut();
        }
    });

    $('.popup-fade').click(function(e) {
        if ($(e.target).closest('.popup').length === 0) {
            $(this).fadeOut();
        }
    });


});


