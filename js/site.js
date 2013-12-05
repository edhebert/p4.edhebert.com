$(document).ready(function() {
    // position welcome message
    $('#herocopy').center();

    // animate  homepage elements (for those with JS)
    $('h2>span, #playbtn').css('display', 'none');

    // load the "on time" text after a brief delay
    setTimeout(function() {
        $('h2>span').fadeIn('slow')
    }, 1500);

    //fade in the play button
    setTimeout(function() {
        $('#playbtn').fadeIn('slow')
    }, 2500);

    // reposition welcome message on resize
    $(window).resize(function() {
        $('#herocopy').center();
    });
});

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}