<?php

class rhyme_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index($error = NULL) {

        // Setup view
        $this->template->content = View::instance('v_rhyme_index');
        $this->template->title   = "Let's Rhyme";

        // include access to the Wordnik API
        require($_SERVER['DOCUMENT_ROOT'] . '/wordnik/Swagger.php');
        $myAPIKey = '1aa94b552058e254ba72b0fb2dc0bba89c925fe4037896b95';
        $client = new APIClient($myAPIKey, 'http://api.wordnik.com/v4');

        // API placeholders for random word and rhymes
        $wordsApi = new WordsApi($client);
        $wordApi = new WordApi($client);

        // define the minimum number of rhymes a word must have to be accepted
        define("NUM_RHYMES", 6);

        // loop until we have a word with more than 4 rhymes
        do {
            // get random word - exclude proper names and other stuff that isn't fun to rhyme against
            $result = $wordsApi->getRandomWords($includePartOfSpeech='noun, verb, adjective', $excludePartOfSpeech='family-name, given-name, past-participle, proper-noun, proper-noun-plural, proper-noun-posessive', $sortBy=null, $sortOrder=null, $hasDictionaryDef=true, $minCorpusCount=100000, $maxCorpusCount=null, $minDictionaryCount=null, $maxDictionaryCount=null, $minLength=4, $maxLength=13, $limit=1);
            
            $randomWord = $result[0]->word;

            // make sure the word's canonical (no plurals or weird verb tenses)
            $result = $wordApi->getWord($randomWord, $useCanonical='true', $includeSuggestions=null);
            $canonical = $result->word;

            // get an array of rhymes for that random word
            $result = $wordApi->getRelatedWords($canonical, $relationshipTypes='rhyme', $useCanonical=false, $limitPerRelationshipType=1000);
        } 
        while (count($result[0]->words) < NUM_RHYMES); 

        $rhymes = $result[0]->words;

        # Pass data to the View
        $this->template->content->word = $canonical;
        $this->template->content->rhymes = $rhymes;

        # pass errors, if any
        $this->template->content->error = $error;

        # Render the View
        echo $this->template;

        
        // print($canonical . '<br><br>');
        // print_r($rhymes);
    }    

}

?>