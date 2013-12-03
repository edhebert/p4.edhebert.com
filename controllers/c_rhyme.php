<?php

// include access to the Wordnik API in all pages of the site
require('/wordnik/Swagger.php');
$myAPIKey = '1aa94b552058e254ba72b0fb2dc0bba89c925fe4037896b95';
$client = new APIClient($myAPIKey, 'http://api.wordnik.com/v4');

class rhyme_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }    

}