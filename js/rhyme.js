/**
 * Ed Hebert
 * ehebert@fas.harvard.edu
 * Project 4 - RymrTymr
 */


/* game variables */

// the game (used for setInterval)
var game;

// SetTimeout var for showing word
var showWord;

// the global word we need to rhyme
var word;

// all rhymes for that word
var rhymeArray;

// global score of the game
var gameScore;

// the game timer
var countdown;

// whether the game is actively being played
var playing = false;


$(document).ready(function() {
    //play the game
    playgame();
});


// reposition welcome message on resize
$(window).resize(function() {
    $('#herocopy').center();
});

// check for keypresses and react accordingly
$(document).on("keydown", function(e) {
    var code = e.keyCode || e.which;

    // if enter or tab pressed, check word
    if (playing && (code == '9' || code == '13')) {
        
        // prevent default behavior
        e.preventDefault();

        // check the word
        var checkWord = $("[contenteditable='true']").text().toLowerCase();

        // if the word is found in the rhymes array
        var arrayIndex = $.inArray(checkWord, rhymeArray);
        if (arrayIndex != -1)
        {
            // item found, remove from array so it cant be used twice
            rhymeArray.splice(arrayIndex, 1);

            // increment score as necessary
            gameScore++;
            $('#score').text(gameScore);
            // color the text
            $("[contenteditable='true']").css('color', '#E2F64C');
        }
        else {
            // word not found
            $("[contenteditable='true']").css('color', '#F44033');
        }

        // remove contenteditable attribute from all editable tags
        $('.editable').attr('contenteditable', 'false'); 

        // add a new, editable li element
        $('#rhymes').append('<li class="editable" contenteditable="true"></li>');

        // give it the focus
        $("[contenteditable='true']").focus();
    }
});


/**
 * Game Functions
 */


function playgame() {

    // hide the main copy and gameboard
    $('#herocopy, #gameboard').hide();

    $.ajax({
        dataType: "json",
        url: '/rhyme/p_rhyme',
        beforeSend: function() {
            // clear the results area
            $('#herocopy').empty();                
            $('#herocopy').html('<i class="fa fa-spinner fa-spin"></i> Fetching a word...');
            $('#herocopy').center();
            $('#herocopy').show();
        },
        success: function(response) { 
            word = response.word.toLowerCase();
            var rhymes = response.rhymes;
            // make an array out of the rhymes object
            rhymeArray = $.map(rhymes, function(value, index) {
                return [value];
            });
        }
    }); // end ajax 

    // return array when ajax call is complete
    $(document).ajaxComplete(function() {
        $('#word, #word2').text(word);

        // display the word in the middle of the page
        $('#herocopy').html('<h2>The word to rhyme is:<br> <span id="word">' + word + '</span></h2>');
        $('#herocopy').center();
        $('#herocopy').fadeIn();

        // perform the countdown / timing functions
        countdown = 3;

        // show intro word for 2 seconds and then start game timer
        showWord = setTimeout(function() {
            game = setInterval(updateCountdown, 1000);
        }, 2000);    
    });
}

/* reset all game variables */

function resetGame() {
    clearInterval(game);
    clearTimeout(showWord);
    game = "";
    showWord = "";
    countdown = 0;
    gameScore = 0;
    playing = false;
}

/* performs all the looping / timing for the game */

function updateCountdown() {
    // display numbers until it hits zero 
    if (countdown >= 0) {
        if (countdown == 0)
        {
            //show appropriate message
            if (!playing)
                $('#herocopy').html('<h2 class="bignumber">Go!</h2>').css('opacity', '1.0');
            else
            {
                $('#herocopy').html('<h2 class="bignumber">Game Over</h2>').css({'opacity': '1.0', 'z-index':'2'});
                $('#rhymes').css('opacity', '0.2');
                $('#herocopy').css({'opacity': '1.0', 'z-index': 2});
                $('#herocopy').append($('#playbtn'));
                $('#playbtn').css({'display': 'none', 'visibility' : 'visible'}).fadeIn('slow');  

                // remove contenteditable attribute from all editable tags
                $('.editable').attr('contenteditable', 'false');  
            }
        }
        else {
            $('#herocopy').html('<h2 class="bignumber">' + countdown + '</h2>');
            $('#herocopy').center();
        }
        countdown--;
    }
    else
    {
        // toggle game play 
        if (!playing) {
            //init score to zero
            gameScore = 0;

            // set game clock to 30 sec, show the game board and begin the game
            countdown = 30;
            playing = true;

            // make the counter faint overlay on top of screen
            $('#herocopy').css('opacity', '0.2');
            $('#score').text(gameScore);

            // set up gameboard
            $('#rhymes').css('opacity', '0.8');
            $('#rhymes').html('<li class="editable" contenteditable="true"></li>');
            $('#gameboard').show();

            // remove contenteditable attribute from all editable tags
            $('.editable').attr('contenteditable', 'true');  

            // position cursor at first editable element
            $("[contenteditable='true']").focus();
        }
        else {
            // stop the timer, end the game  
            clearInterval(game);  
            playing = false;   
            // remove contenteditable attribute from all editable tags
            $('.editable').attr('contenteditable', 'false');     

            // if user's logged in send score to database
            if(typeof firstName != 'undefined') 
            {
                    $.ajax({
                        async: false,
                        type: 'POST',
                        dataType: "json",
                        url: '/users/update',
                        data: {
                            score: gameScore,
                        },        
                        beforeSend: function() {
                            // do the before send stuff
                        },
                        success: function(response) { 
                            console.log(response);
                            clearInterval(game);
                        }
                    }); //  ajax   
            }            
        }
    }
};




