<?php session_start();

require_once "functions/functions.php";
?>
<!doctype html>
        <!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en-US"> <![endif]-->
        <!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en-US"> <![endif]-->
        <!--[if IE 8]>    <html class="lt-ie9" lang="en-US"> <![endif]-->
        <!--[if gt IE 8]><!--> <html lang="en-US"> <!--<![endif]-->
        <head>
                <!-- META TAGS -->
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <title>The Londoners</title>

                <link rel="shortcut icon" href="images/favicon.png" />


                

                <!-- Style Sheet-->
                <link rel="stylesheet" href="style.css"/>
                <link rel='stylesheet' id='bootstrap-css-css'  href='css/bootstrap5152.css?ver=1.0' type='text/css' media='all' />
                <link rel='stylesheet' id='responsive-css-css'  href='css/responsive5152.css?ver=1.0' type='text/css' media='all' />
                <link rel='stylesheet' id='pretty-photo-css-css'  href='js/prettyphoto/prettyPhotoaeb9.css?ver=3.1.4' type='text/css' media='all' />
                <link rel='stylesheet' id='main-css-css'  href='css/main5152.css?ver=1.0' type='text/css' media='all' />
               
             

           <!--     <link rel='stylesheet' id='custom-css-css'  href='css/custom5152.html?ver=1.0' type='text/css' media='all' />-->


                <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
                <!--[if lt IE 9]>
                <script src="js/html5.js"></script></script>
                <![endif]-->
                <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>

        </head>
        <body>
 <!-- Start of Header -->
                <div class="header-wrapper">
                        <header>
                                <div class="container">


                                        <div class="logo-container">
                                                <!-- Website Logo -->
                                                <a href="index.php"  title="The Londoners">
                                                        <img src="images/logo.png" alt="The Londoners">
                                                </a>
                                                <span class="tag-line">Welcome to The Londoners</span>
                                        </div>


                                        <!-- Start of Main Navigation -->
                                        <nav class="main-nav">
                                                <div class="menu-top-menu-container">
                                                        <ul id="menu-top-menu" class="clearfix">
                                                                <li><a href="index.php">Home</a></li>
                                                                <li><a href="categories.php">Categories</a></li>
                                                                <li><a href="contact.php">Contact</a></li>

                                                                <?php if(isset($_SESSION['loggedin'])): ?>
						                <li><img src="images/support.png" alt="user" class="rounded-circle" width="40">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block"><?php echo $_SESSION['username']?> <i class="mdi mdi-chevron-down"></i></span>
                                                                        <ul class="sub-menu">
                                                                                <li><a href="includes/messages.php">Messages</a></li>
                                                                                <li><a href="userprofile.php">View Profile</a></li>
                                                                                <li><a href="includes/logout.php">Logout</a></li>
                                                                        </ul>
                                                                </li>
					                         <?php else: ?> 
						                <li><a  data-toggle="modal" data-target="#exampleModal">Signin</a></li>
                                                                <li><a  data-toggle="modal" data-target="#exampleModal1">Register</a></li>
                                                                <?php endif; ?>
                                                                 <?php
                                                                 $str=loginmodals();
                                                                 echo $str;

                                                                 $reg=regmodals();
                                                                 echo $reg;
                                                                 ?>                                                               
                  
                                                                
                                                        </ul>
                                                </div>
                                        </nav>
                                        <!-- End of Main Navigation -->

                                </div>
                        </header>
                </div>
                <!-- End of Header -->