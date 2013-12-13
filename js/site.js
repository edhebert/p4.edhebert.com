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


$(document).ready(function() {

    $('#login-btn').click(function(e) {
        e.preventDefault();

        $('#loginModal').modal();

        // focus cursor on first input element of modal
        setTimeout(function(){
            $('#login_email').focus();
        }, 500);        
    });

    $('#signup-btn').click(function(e) {
        e.preventDefault();

        $('#signupModal').modal();

        setTimeout(function(){
            $('#first_name').focus();
        }, 500);              
    });

    $('#p_signup').click(function(e) {
        e.preventDefault();

        console.log('click!');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '/users/signup',
            data: {
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                email: $('#signup_email').val(),
                password: $('#signup_password').val(),
                retype: $('#retype').val(),
            },        
            beforeSend: function() {
                // do the before send stuff

            },
            success: function(response) { 
                // process the response end
                // if there was an error
                if (typeof response.error != undefined)
                {
                    $('.display-error').html(response.error);
                    $('.callout-error').fadeIn('slow');
                }
            }
        }); //  ajax     
    });

    $('#p_login').click(function(e) {

        // prevent form from submitting
        e.preventDefault();
        
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

                console.log(response);                
                // if there was an error
                if (typeof response.error != 'undefined')
                {
                    $('.display-error').html(response.error);
                    $('.callout-error').fadeIn('slow');
                }
            }
        }); // ajax     
    });

});
