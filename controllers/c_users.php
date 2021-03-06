<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function login() {
        if (!$_POST) {
            // Send them back to the home page.
            Router::redirect("/");
        } else {

            // Sanitize the user entered data to prevent SQL Injection Attacks
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);

            // check POST data for valid input
            foreach($_POST as $field_name => $value) { 
                // If any field was blank, add a message to the error View variable
                if(trim($value) == "") {
                    $data['error'] = '<p>All fields are required.</p>';
                    // return data to AJAX request
                    echo json_encode($data);   
                    return;                 
                }
            }

            // Escape HTML chars (XSS attacks)
            $_POST['email'] = stripslashes(htmlspecialchars($_POST['email']));

            // Hash submitted password so we can compare it against one in the db
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

            // Search the db for this email and password
            // Retrieve the token if it's available
            $q = "SELECT token 
                FROM users 
                WHERE email = '".$_POST['email']."' 
                AND password = '".$_POST['password']."'";

            $token = DB::instance(DB_NAME)->select_field($q);

            // If we didn't find a matching token in the database, it means login failed
            if(!$token) {
                // send an error back 
                $data['error'] = '<p>Username and password combination not found.</p>';

            // But if we did, login succeeded! 
            } else {

                /* 
                Store this token in a cookie using setcookie()
                Important Note: *Nothing* else can echo to the page before setcookie is called
                Not even one single white space.
                param 1 = name of the cookie
                param 2 = the value of the cookie
                param 3 = when to expire
                param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
                */
                setcookie("token", $token, strtotime('+1 year'), '/');

                // Send success back to AJAX.
                $data['success'] = true;
            }

            // return data to AJAX request
            echo json_encode($data);
        }
    }

    public function getuser() {
        echo json_encode($this->user);
    }

    public function logout() {

        // Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        // Create the data array we'll use with the update method
        // In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        // Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        // Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        // Send them back to the home page.
        Router::redirect("/");

    }


    public function signup() {

        // If no POST data was yet submitted, just render the view
        if(!$_POST) {
            // Send them back to the home page.
            Router::redirect("/");
        }

        // check POST data for valid input
        foreach($_POST as $field_name => $value) { 
            // Escape HTML chars (XSS attacks)
            $value = stripslashes(htmlspecialchars($value));
            // If any field was blank, add a message to the error View variable
            if(trim($value) == "") {
                $data['error'] = '<p>All fields are required.</p>';
            }
        }

        // check whether this user's email already exists (sanitize input first)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        $exists = DB::instance(DB_NAME)->select_field("SELECT email FROM users WHERE email = '" . $_POST['email'] . "'");

        if (isset($exists)) {
            $data['error'] = '<p>This email address is already registered.</p>';       
        }

        // insure password is typed correctly
        else if ($_POST['password'] != $_POST['retype']) {
            $data['error'] = '<p>Password fields don&apos;t match.</p>';        
        }

        // if we got an error, return it
        if(isset($data['error'])) {
            // return error data to AJAX request
            echo json_encode($data);
        }

        // if no previous errors, add user to the database!
        else {              
            // unset the 'retype' field (not needed in db)
            unset($_POST['retype']);

            // UNIX timestamps for created and modified date
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

            // Encrypt the password  
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

            // Create an encrypted token via their email address and a random string
            $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

            // Insert this user into the database
            $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

            // log user in using the token we just generated
            setcookie("token", $_POST['token'], strtotime('+1 year'), '/');

            // send data back to AJAX
            $data['success'] = true;
            echo json_encode($data);
        }   

    } 


    public function stats() {
        $user_details = DB::instance(DB_NAME)->select_row('SELECT * FROM users WHERE user_id ='.$this->user->user_id);
        // send details to the view
        echo json_encode($user_details);
    }


    public function update() {
        if (!$_POST) 
        {
            // Send them back to the home page.
            Router::redirect("/");
        } 
        else 
        {   
            // get the player's score
            $score = $_POST['score'];

            // run update query:  increment games, add score, update high score if new one beats it  
            $q =    "UPDATE users SET games=games+1, points=points+" . $score . ", high_score = CASE WHEN " . $score . " > high_score THEN " . $score . " ELSE high_score END WHERE user_id = " . $this->user->user_id;

            # Run the command
            $data = DB::instance(DB_NAME)->query($q);
            
            echo json_encode($score);
        }
    }
} // eoc
