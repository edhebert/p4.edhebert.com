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