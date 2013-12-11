/**
 * Ed Hebert
 * ehebert@fas.harvard.edu
 * Project 4 - RymrTymr
 */

$(document).ready(function() {
    // position welcome message
    $('#herocopy').center();

    // animate homepage elements (for those with JS)
    $('#first, #second, #playbtn').css({'display': 'none', 'visibility' : 'visible'});

    setTimeout(function() {
        $('#first').fadeIn('slow');
    }, 500);

    // load the "on time" text after a brief delay
    setTimeout(function() {
        $('#second').fadeIn('slow')
    }, 2000);

    //fade in the play button
    setTimeout(function() {
        $('#playbtn').fadeIn('slow')
    }, 3000);

    // reposition welcome message on resize
    $(window).resize(function() {
        $('#herocopy').center();
    });
});
