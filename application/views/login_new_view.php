<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EuroZoneGlobal.com</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("assets/font-awesome/css/font-awesome.min.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("assets/css/form-elements.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">

    </head>

    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>EuroZone</strong>Global</h1>
                            <div class="description">
	                            	Manage to make profit in the form of grants ( HIBAH ) Returns on Investment ( ROI ) Without Recruit People <strong>20% to 40% Every Cycle</strong> ( Profit from Trading Pool Accounts / Mining )
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login to our site</h3>
                            		<p>Enter your Member ID and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            
                            <div class="form-bottom">
                            <?php echo $this->session->flashdata('msg'); ?>
                                <?php $attributes = array("name" => "loginform");
                                echo form_open("Login_new", $attributes);?>
			                    <!--<form role="form" action="" method="post" class="login-form">-->
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Member ID</label>
			                        	<input type="text" name="usrnme" placeholder="Member ID..." class="form-username form-control" id="form-username" value="<?php echo set_value('usrnme'); ?>"><span class="text-danger"><?php echo form_error('usrnme'); ?></span>
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password" value="<?php echo set_value('password'); ?>"><span class="text-danger"><?php echo form_error('password'); ?></span>
			                        </div>
			                        <button type="submit" class="btn">Sign in!</button>
                                    
			                    <!--</form>-->
                                <?php echo form_close(); ?>
                                
		                    </div>
                     <!--       Click <a href="<?php //echo base_url("main/forgot"); ?>">here</a> if you forgot your password. -->
                        </div>
                    </div>
                    <!--
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	<h3>...or login with:</h3>
                        	<div class="social-login-buttons">
	                        	<a class="btn btn-link-1 btn-link-1-facebook" href="#">
	                        		<i class="fa fa-facebook"></i> Facebook
	                        	</a>
	                        	<a class="btn btn-link-1 btn-link-1-twitter" href="#">
	                        		<i class="fa fa-twitter"></i> Twitter
	                        	</a>
	                        	<a class="btn btn-link-1 btn-link-1-google-plus" href="#">
	                        		<i class="fa fa-google-plus"></i> Google Plus
	                        	</a>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        -->

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    
                    <div class="col-sm-8 col-sm-offset-2">
                    <!--    <div class="footer-border"></div>-->
                        <!-- for footer -->
                        2016 | <a href="<?php echo base_url();?>">EuroZoneGlobal.com</a>
                    </div>
                    
                </div>
            </div>
        </footer>

        <!-- Javascript -->
        <script src="<?php echo base_url("assets/js/jquery-1.11.1.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/js/jquery.backstretch.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/js/scripts.js"); ?>"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->


    </body>

</html>
<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy();
?>