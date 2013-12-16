p4.edhebert.com
===============

## DWA Project 4 - RymrTymr

RymrTymr is a word game web app that displays a random word from a dictionary, and challenging players to list as many rhyming words for it as possible in a 30 second span. Visitors are given the choice to either play games anonymously just for fun, or to log in and have their game performance stats monitored and displayed.

It makes use of several key DWA topics, including MVC / framework PHP, JS / AJAX, and API usage.

## Background

Being a parent to three little ones, rhyming games are quite popular around the house nowadays. All the ideas came from there! While this version of RymrTymr is a little too hard for my oldest five year old to play, I invite you to enjoy the game. :)

## Usage

The user interface was designed to be minimal, and hopefully intuitive and inviting. A simple greeting and a big "Play" button welcome the user on the home page. If a user isn't logged in, they'll initially be presented with a "nagging" modal encouraging them to join to save their game stats. If they choose to continue without joining, a cookie is set, and the modal won't pop up again for another 24 hours, allowing them to play in peace.

Continuing on to the rhyme page, the game flashes the player's random word for two seconds, and then she's prompted to "Get Ready". After a brief countdown from 3, the game begins and the user's then given 30 seconds to type as many rhymes as possible for their word. If the entered words rhyme, the score is incremented and each word turns green. If the word isn't a rhyme, the word turns red, and the user continues playing until time's up.

Anonymous users may play as often as they'd like, but no game stats will be tallied. Logged in users are invited to check their stats at any time. These statistics monitor games played, average score per game, high score, and total time wasted playing RymrTymmr.

##  "Behind the Scenes" Functionality

The game makes heavy use of AJAX, and almost all data is transferred to/from the controllers in this way. As such, the game feels quick and seamless. 

#### Wordnik API
This game makes use of the Wordnik Dictionary API, found at http://developer.wordnik.com/ Among other features, the Wordnik API can be queried to return a list of rhymes for any given word.

On the 'rhyme' page, AJAX calles are made to a controller that queries the Wordnik API for a random word from the dictionary. For this game, the request to Wordnik is manually adjusted to return only words between 4 and 16 characters, and for only those words that are somewhat common in English usage ($minCorpusCount > 100000). From there, a second query is made to Wordnik to return a list of rhymes for that word into a javascript array. If the random word has fewer than 6 rhymes, the word is rejected and the process restarted.  In that way, every random word chosen gives a the player the possibility to score at least 6 points each round.

NOTE: After playing quite a few rounds, I've noticed there are times when Wordnik fails to return a valid rhyme for the word. Kind of a bummer. Anyway, if curious to see how the brain works, you can "console.log(rhymeArray);" to see the entire array the Wordnik spit out to us.

#### Log In / Sign Up
The buttons for login and signup make AJAX calls to insert / retrieve necessary login info from the database. If a user submits bad info, an error message is fed from the controller directly back to the modal. If the input is successful, the home page is reloaded, and the user is personally welcomed to the game. 

#### Game Timer
The game makes use of both setTimeout() and setInterval() to control the game clock, and therefore reuses the same code to power both the pre-game countdown and the in-game timers. Pressing one of non-game buttons (e.g. Login or Signup) during the game will clearInterval(), stop the game, and pop up the requested dialog modal.

#### User Input
Rather than using "input" elements, I decided to modify ordinary "li" elements via an HTML5 "contenteditable" attribute. In that way, I could more easily style the page, and better control the overall aesthetics of the game.

Each time the player presses either 'tab' or 'enter', the last word they typed is checked against the array of rhyming words. If a match is encountered, the player's score is incremented, and the word is spliced from the array so it can't be scored twice. The word's color is then changed to green, and a new li element is appended to contain the next typed word.

#### Game Completion
At game's end, yet another AJAX call is made to feed the data from the completed game into the player's database record. The score is added to total score, compared against the player's high score, and adjusted accordingly. The "time wasted" stat is calculated by mutiplying the total number of games completed by 30 (seconds per game), and breaking that number down into hours/minutes/seconds from there.


#### Design Decisions
Twitter Bootstrap is the underlying design framework. The fun color palettes were inspired by Allison Jay's "ABC Flashcards". The background photo is mine - an image of those cards mounted to an art canvas in my kid's playroom.


## That's about it...hope you enjoy!








