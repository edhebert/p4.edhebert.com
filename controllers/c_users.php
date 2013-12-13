<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function login() {

        // Render template
        if (!$_POST) {
            return; 
        
        } else {

            // Sanitize the user entered data to prevent SQL Injection Attacks
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);

            // Escape HTML chars (XSS attacks)
            $_POST['email'] = stripslashes(htmlspecialchars($_POST['email']));

            // Hash submitted password so we can compare it against one in the db
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);


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

                # Send them to the posts page
                Router::redirect("/posts/");
            }

            // return data to AJAX request
            echo json_encode($data);
        }
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
            return;
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
        else if (!$error){              
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

            // all users follow their own posts by default
            $data = Array(
                "created" => Time::now(),
                "user_id" => $user_id,
                "user_id_followed" => $user_id
                );

            # Do the insert
            DB::instance(DB_NAME)->insert('users_users', $data);

            // Email a welcome message to the new user
            $to[]    = Array("name" => $_POST['first_name'], "email" => $_POST['email']);
            $from    = Array("name" => APP_NAME, "email" => APP_EMAIL);
            $subject = "Welcome to Blabbr!";              
                
            $body = View::instance('v_email_welcome');
                
            // Send email
            Email::send($to, $from, $subject, $body, true, '');

            // log user in using the token we generated
            setcookie("token", $_POST['token'], strtotime('+1 year'), '/');


        }
    } 

} // eoc
