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

// the user's name
var firstName;

$(document).ready(function() {

    // get user data into JS, if available
    $.ajax({
        async: false,
        dataType: "json",
        url: '/users/getuser',     
        success: function(response) { 
            // process the response end
            // if there was an error
            if (response)
            {
                firstName = response.first_name;
            }
        }
    }); //  ajax       

    $('#nag-login, #login-btn').click(function(e) {
        e.preventDefault();

        // clear game if appropriate
        if (typeof playing != 'undefined' && playing)
        {
            countdown = 0;
        }

        // hide the nag modal if open
        $('#myModal').modal('hide');

        $('#loginModal').modal();

        // focus cursor on first input element of modal
        var focusMe = setTimeout(function(){
            $('#login_email').focus();
        }, 500);        
    });

    $('#nag-signup, #signup-btn').click(function(e) {
        e.preventDefault();

        // clear game if appropriate
        if (typeof playing != 'undefined' && playing)
        {
            countdown = 0;
        }

        // hide the nag modal if open
        $('#myModal').modal('hide');

        $('#signupModal').modal();

        var focusMe = setTimeout(function(){
            $('#first_name').focus();
        }, 500);              
    });

    $('#p_signup').click(function(e) {
        e.preventDefault();

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
                $('.display-error').html("sending..."); 
            },
            success: function(response) { 
                console.log(response);
                // if there was an error
                if (typeof response.error != 'undefined')
                {
                    $('.display-error').html(response.error);
                    $('.callout-error').fadeIn('slow');
                }
                else
                {
                    // reload the home page with a personal greeting
                    document.location.href = '/';
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
                $('.display-error').html("sending..."); 
            },
            success: function(response) {             
                // if there was an error
                if (typeof response.error != 'undefined')
                {
                    $('.display-error').html(response.error);
                    $('.callout-error').fadeIn('slow');
                }
                else
                {
                    // reload the home page with a personal greeting
                    document.location.href = '/';
                }
            }
        }); // ajax     
    });

});
