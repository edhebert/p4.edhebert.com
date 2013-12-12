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

    $('#playbtn').click(function(e) {
        // if there's no user and no cookie, invite them to join via modal dialog
        if (!checkCookie())
        {
            e.preventDefault();
            $('#myModal').modal();
        }
        setCookie("anonymous",true,1);
    });
});


/* cookie functions adapted from http://www.w3schools.com/js/js_cookies.asp */

function setCookie(c_name,value,exdays) {
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1)
    {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1)
    {
        c_value = null;
    }
    else
    {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1)
        {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}

function checkCookie()
{
    var anonymous=getCookie("anonymous");
    if (anonymous!=null && anonymous!="")
    {
        return true;
    }
    else 
    {
        // return false
        return false;
        anonymous=prompt("Please enter your name:","");

        if (anonymous!=null && anonymous!="")
        {
            setCookie("anonymous",anonymous,365);
        }
    }
}
