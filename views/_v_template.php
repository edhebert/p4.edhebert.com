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
                        <a class="btn btn-custom" href="#"><i class="fa fa-lock"></i> Login</a>
                        <a class="btn btn-custom" href="#"><i class="fa fa-pencil-square-o"></i> Sign Up</a>
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
        
    </body>
</html>