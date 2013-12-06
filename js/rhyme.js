// the global word we need to rhyme
var word;
// all rhymes for that word
var rhymes;

$(document).ready(function() {
    $('#process-btn').click(function() {
        $.ajax({
            dataType: "json",
            url: '/rhyme/p_rhyme',
            beforeSend: function() {
                // clear the results area
                $('#results').empty();                
                $('#results').html("Fetching a word...");
            },
            success: function(response) { 
                word = response.word; 
                rhymes = response.rhymes;
            }
        }); // end ajax 


        $(document).ajaxComplete(function() {
            $('#word').text(word);
            console.log(rhymes); // the whole objext
            for (var key in rhymes) {
                // console.log(rhymes[i]);
                $('#results').append(rhymes[key] + '<br>');
                console.log(rhymes[key]);
            }
        });
    }); 
});