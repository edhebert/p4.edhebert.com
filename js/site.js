/**
 * Ed Hebert
 * ehebert@fas.harvard.edu
 * Project 4 - RymrTymr
 */

// centers elements in the middle of the page
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).height()) / 2)));
    this.css("left", Math.max(0, (($(window).width() - $(this).width()) / 2)));
    return this;
}

$('#login-btn').click(function(e) {
    e.preventDefault();
    $('#loginModal').modal();
});

$('#signup-btn').click(function(e) {
    e.preventDefault();
    $('#signupModal').modal();
});

// $('#p_signup').click(function(e) {
//     $.ajax({
//         type: 'POST',
//         dataType: "json",
//         url: '/users/signup/',
//         data: {
//             email: $('#signup_email').val(),
//             password: $('#signup_password').val(),
//         },        
//         beforeSend: function() {
//             // do the before send stuff

//         },
//         success: function(response) { 
//             // process the response end
//             // if there was an error
//             if (typeof response.error != undefined)
//             {
//                 $('.display-error').html(response.error);
//             }
//         }
//     }); //  ajax     
//     return false;
// });

$('#login-form').submit(function(e) {
    e.preventDefault();
    return false;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/users/login',
        data: {
            email: $('#login_email').val(),
            password: $('#login_password').val(),
        },
        beforeSend: function() {
            // do the before send stuff
            $('.display-error').html("sending..."); // just a test
        },
        success: function(response) { 
            // process the response end
            // if there was an error
            if (typeof response.error != 'undefined')
            {
                $('.display-error').html(response.error);
            }
        }
    }); // ajax     
});