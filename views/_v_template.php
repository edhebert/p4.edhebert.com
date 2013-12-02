<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title . " | "; ?>RymrTymr</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Google Web Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,700' rel='stylesheet' type='text/css'>

        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">

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

    <body>
        <!-- Sticky footer wrapper -->	
        <div id="wrap">
            <!-- nav -->
            <header class="navbar navbar-inverse navbar-static-top" role="banner">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a href="/" class="navbar-brand">RymrTymr</a>
                    </div>
                    <nav class="collapse navbar-collapse pull-right" role="navigation">
                        <ul class="nav navbar-nav">
                            <?php if ($user) : ?>
                                <li>
                                    <a href='/posts'>View &amp; Add Posts</a>
                                </li>  
                                <li>
                                    <a href='/posts/users'>Follow Others</a>
                                </li>                                                           
                                <li>
                                    <a href='/users/profile'>Edit Your Profile</a>
                                </li>
                                <li>
                                    <a href='/users/logout'>Logout</a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href='/users/signup'>Sign up</a>
                                </li>
                                <li>
                                    <a href='/users/login'>Log in</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div> <!-- container -->
            </header>

            <div class="container">
                <div class="row well well-lg">
                    <?php if(isset($content)) echo $content; ?>
                </div> <!-- well -->
            </div> <!-- container -->
            
            <div id="push"></div> <!-- sticky footer push -->
            
        </div> <!-- wrap -->   
        
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                        <p>RymrTymr<br>DWA Project 4<br>
                        Ed Hebert<br>
                        <a href="mailto:ehebert@fas.harvard.edu">ehebert@fas.harvard.edu</a>
                        </p>
                    </div>
                    <div class="col-xs-6">

                    </div>
                </div>
            </div>
        </div> <!-- footer -->
        
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>

        <!-- Twitter Bootstrap JS stuff -->
        <script src="/js/bootstrap.min.js"></script>

        <?php if(isset($client_files_body)) echo $client_files_body; ?>
        
    </body>
</html>