// the global word we need to rhyme
var word;

// all rhymes for that word
var rhymes;

// global score of the game
var score;

// whether the game is actively being played
var playing = false;

$(document).ready(function() {
    // hide the main copy and gameboard
    $('#herocopy, #gameboard').hide();

    $.ajax({
        dataType: "json",
        url: '/rhyme/p_rhyme',
        beforeSend: function() {
            // clear the results area
            $('#herocopy').empty();                
            $('#herocopy').html("Fetching a word...");
            $('#herocopy').center();
            $('#herocopy').show();
        },
        success: function(response) { 
            word = response.word; 
            rhymes = response.rhymes;
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
        var countdown = 3;
        var updateCountdown = function() {
            // display numbers until it hits zero 
            if (countdown > 0) {
                $('#herocopy').html('<h2 class="bignumber">' + countdown + '</h2>');
                $('#herocopy').center();
                countdown--;
            }
            else
            {
                // toggle game play 
                if (!playing) {
                    //start the game
                    $('#herocopy').html('<h2 class="bignumber">Go!</h2>');
                    $('#herocopy').center();

                    // when countdown has finished, show the game board and begin the game
                    countdown = 5;
                    playing = true;
                    $('#gameboard').show();
                 
                }
                else {
                    // stop the timer, end the game  
                    clearInterval();    
                    $('#herocopy').html('<h2 class="bignumber">Time\'s Up!</h2>').center();           
                }
            }
        };

        // show intro word for 2 seconds and then start game timer
        setTimeout(function() {
            setInterval(updateCountdown, 1000);
        }, 2000);
        
    });

});


