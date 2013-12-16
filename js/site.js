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


    // show login modal
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

    //show signup modal
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

    $('#stats-btn').click(function(e) {
        e.preventDefault();

        // get the player's stats from the db
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '/users/stats',
      
            beforeSend: function() {
                // do the before send stuff
                $('.display-error').html("sending..."); 
            },
            success: function(response) { 

                if (response.games > 0)
                {
                    //calculate avg
                    var avg = response.points / response.games;
                    avg = avg.toFixed(1);

                    // calculate seconds
                    // number of games times 30 sec/game
                    var totalSec = response.games * 30;

                    // code from http://stackoverflow.com/questions/1322732/convert-seconds-to-hh-mm-ss-with-javascript
                    var hours = parseInt( totalSec / 3600 ) % 24;
                    var minutes = parseInt( totalSec / 60 ) % 60;
                    var seconds = totalSec % 60;

                    var time = "";
                    if (hours > 0)
                        if (hours == 1)
                            time = time + minutes + " hour ";                        
                        else
                            time = hours + " hours "
                    if (minutes > 0)
                        if (minutes == 1)
                            time = time + minutes + " minute ";
                        else
                            time = time + minutes + " minutes ";
                    if (seconds > 0)
                        time = time + seconds + " seconds"

                    // add the table to the modal
                    $('#stats-body').html('<table><tr><td><h3>Games played:</h3></td><td><h3><span class="badge">' + response.games + '</span></h3></td></tr><tr><td><h3>Average score:</h3></td><td><h3><span class="badge">' + avg + ' rhymes</span></h3></td></tr><tr><td><h3>High Score:</h3></td><td><h3><span class="badge">' + response.high_score + ' rhymes</span></h3></td></tr><tr><td><h3>Time wasted:</h3></td><td><h3><span class="badge">' + time + '</span></h3></td></tr></table>');
                } else {
                    $('#stats-body').html('<h3>No games played yet!</h3>');
                }


                $('#statsModal').modal();
            }
        }); //  ajax   
    });

    // process signup
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

    // process login
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
