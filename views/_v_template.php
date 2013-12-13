<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title . " | "; ?>RymrTymr</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Typekit Fonts -->
        <script type="text/javascript" src="//use.typekit.net/jsa0zoc.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>

        <!-- Bootstrap & Font Awesome-->
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

        <!-- custom styles -->
        <link href="/css/styles.css" rel="stylesheet" media="screen">
        					
        <!-- Controller Specific JS/CSS -->
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
        
        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-44004266-4', 'edhebert.com');
            ga('send', 'pageview');

        </script>
    </head>

    <body id="hero">
        <!-- Sticky footer wrapper -->	
        <div id="wrap">
        
            <header>
                <h1><a href="/">RymrTymr - a rhyming game.</a></h1>
            </header>

            <div class="container">
                <?php if(isset($content)) echo $content; ?>
            </div> <!-- container -->                   

            <div id="push"></div> <!-- sticky footer push -->            
        </div> <!-- wrap -->   
        
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="pull-right md-col-12">
                    <?php if ($user) : ?>
                        <a class="btn btn-custom" id="login-btn" href="#"><i class="fa fa-lock"></i> View your stats</a>
                    <?php else: ?>
                        <a class="btn btn-custom" id="login-btn" href="#"><i class="fa fa-lock"></i> Log In</a>
                        <a class="btn btn-custom" id="signup-btn" href="#"><i class="fa fa-pencil-square-o"></i> Sign Up</a>
                    <?php endif; ?>
                            
                    </div>
                </div>
            </div>
        </div> <!-- footer -->
        
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>

        <!-- Twitter Bootstrap JS stuff -->
        <script src="/js/bootstrap.min.js"></script>

        <!-- Site JS -->
        <script src="/js/site.js"></script>
        <?php if(isset($client_files_body)) echo $client_files_body; ?>
 
                      
        <!-- login modal-->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Log In</h4>
                    </div>
                    <div class="modal-body centered">
                        <form role="form" method="POST" id="login-form" action="/users/login">
                            <div class="form-group">
                                <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Enter email" <?php if(isset($_POST['email'])) echo "value = '". $_POST['email'] ."'"?>>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Enter password">
                            </div> 
                            <!-- warn on login errors -->
                            <?php if(isset($error)): ?>
                                <div class="callout-error">
                                    <h4>Login failed.</h4> 
                                    <div class="display-error"></div>
                                </div>
                            <?php endif; ?> 
                            <button type="submit" class="btn btn-custom" id="p_login"><i class="fa fa-lock"></i> Log In</button>   
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal --> 

        <!-- signup modal-->
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog signup-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Sign Up</h4>
                    </div>
                    <div class="modal-body centered">
                        <form role="form" method="POST" action="/users/signup">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" <?php if(isset($_POST['first_name'])) echo "value = '". $_POST['first_name'] ."'"?>>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" <?php if(isset($_POST['last_name'])) echo "value = '". $_POST['last_name'] ."'"?>>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="signup_email" name="signup_email" placeholder="Enter email" <?php if(isset($_POST['email'])) echo "value = '". $_POST['email'] ."'"?>>
                            </div>
                            <div class="form-group">
                                <label for="first_name">Password</label>
                                <input type="password" class="form-control" id="signup_password" name="signup_password" placeholder="Enter password">
                            </div>  
                            <div class="form-group">
                                <label for="first_name">Retype Password</label>
                                <input type="password" class="form-control" id="retype" name="retype" placeholder="Retype password">
                            </div>         
                            <!-- warn on signup errors -->
                            <?php if(isset($error)): ?>
                                <div class="callout-error">
                                    <h4>Signup failed.</h4> 
                                    <div class="display-error"></div>
                                </div>
                            <?php endif; ?> 
                            <button type="submit" class="btn btn-custom" id="p_signup"><i class="fa fa-pencil-square-o"></i> Sign Up</button>   
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->         
                                                                                                                                      
    </body>
</html>