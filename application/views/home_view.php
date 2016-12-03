<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class='no-js' lang='en'>
	<!--<![endif]-->
	<head>
		<meta charset='utf-8' />
		<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>EuroZoneGlobal - Welcome</title>	
		
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="<?php echo base_url("assets/images/favicon.png"); ?>" />
		
		<link rel="stylesheet" href="<?php echo base_url("assets/css/maximage.css"); ?>"> 
		<link rel="stylesheet" href="<?php echo base_url("assets/css/styles.css"); ?>"> 
		
		
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		
		<!--[if IE 6]>
			<style type="text/css" media="screen">
				.gradient {display:none;}
			</style>
		<![endif]-->

		<!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
	</head>
	<body>

		<!-- Social Links -->
<!--
		<nav class="social-nav">
			<ul>
				<li><a href="<?php echo base_url("login_new")?>"><img src="<?php echo base_url("assets/images/icon-facebook.png"); ?>" /></a></li>
				<li><a href="#"><img src="<?php echo base_url("assets/images/icon-twitter.png"); ?>" /></a></li>
				<li><a href="#"><img src="<?php echo base_url("assets/images/icon-google.png"); ?>" /></a></li>
				<li><a href="#"><img src="<?php echo base_url("assets/images/icon-dribbble.png"); ?>" /></a></li>
				<li><a href="#"><img src="<?php echo base_url("assets/images/icon-linkedin.png"); ?>" /></a></li>
				<li><a href="#"><img src="<?php echo base_url("assets/images/icon-pinterest.png"); ?>" /></a></li>
			</ul>
		</nav>
-->
		<!-- Switch to full screen -->
		<button class="full-screen" onclick="$(document).toggleFullScreen()"></button>

		<!-- Site Logo -->
		<!-- div id="logo">eurozoneglobal</div> -->

		<!-- Main Navigation -->
<!--
		<nav class="main-nav">
			<ul>
				<li><a href="#home" class="active">Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
			</ul>
		</nav>
-->

		<!-- Slider Controls -->
		<!-- <a href="" id="arrow_left"><img src="<?php //echo base_url("assets/images/arrow-left.png"); ?>" alt="Slide Left" /></a>
		<a href="" id="arrow_right"><img src="<?php //echo base_url("assets/images/arrow-right.png"); ?>" alt="Slide Right" /></a> -->

		<!-- Home Page -->
		<section class="content show" id="home">
		
			<h1>Welcome</h1>	
			<h5>to EuroZoneGlobal.com</h5></p>
			<p><a href="<?php echo base_url("login_new");?>"> Login here &#187;</a></p>
		</section>

		<!-- About Page -->
		<section class="content hide" id="about">
			<h1>About</h1>
			<h5>Here's a little about what we're up to.</h5>
			<p>EuroZoneGlobal.com manage to make profit in the form of grants ( HIBAH ) Returns on Investment ( ROI ) Without Recruit People 25% Every Cycle ( Profit from Trading Pool Accounts / Mining )</p>
			<p><a href="#contact">Get in touch &#187;</a></p>
		</section>

		<!-- Contact Page -->
		<section class="content hide" id="contact">
			<h1>Contact</h1>
			<h5>Get in touch.</h5>
			<p><!--Email: <a href="#"> email here --></a><br />
				<!-- phone here --><br /></p>
			<p><!--address 1 --><br />
				<!-- address 2 --></p>
		</section>
		
		<!-- Background Slides -->
		<div id="maximage">
			<div>
				<img src="<?php echo base_url("assets/images/backgrounds/bg-img-1.jpg"); ?>" alt="" />
				<img class="gradient" src="<?php echo base_url("assets/images/backgrounds/gradient.png"); ?>" alt="" />
			</div>
			<div>
				<img src="<?php echo base_url("assets/images/backgrounds/bg-img-2.jpg"); ?>" alt="" />
				<img class="gradient" src="<?php echo base_url("assets/images/backgrounds/gradient.png"); ?>" alt="" />
			</div>
			<div>
				<img src="<?php echo base_url("assets/images/backgrounds/bg-img-3.jpg"); ?>" alt="" />
				<img class="gradient" src="<?php echo base_url("assets/images/backgrounds/gradient.png"); ?>" alt="" />
			</div>
			<div>
				<img src="<?php echo base_url("assets/images/backgrounds/bg-img-4.jpg"); ?>" alt="" />
				<img class="gradient" src="<?php echo base_url("assets/images/backgrounds/gradient.png"); ?>" alt="" />
			</div>
			<div>
				<img src="<?php echo base_url("assets/images/backgrounds/bg-img-5.jpg"); ?>" alt="" />
				<img class="gradient" src="<?php echo base_url("assets/images/backgrounds/gradient.png"); ?>" alt="" />
			</div>
		</div>
		
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js'></script>
		<script src="<?php echo base_url("assets/js/jquery.easing.min.js"); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url("assets/js/jquery.cycle.all.js"); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url("assets/js/jquery.maximage.js"); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url("assets/js/jquery.fullscreen.js"); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url("assets/js/jquery.ba-hashchange.js"); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url("assets/js/main.js"); ?>" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript" charset="utf-8">
			$(function(){
				$('#maximage').maximage({
					cycleOptions: {
						fx: 'fade',
						speed: 1000, // Has to match the speed for CSS transitions in jQuery.maximage.css (lines 30 - 33)
						timeout: 5000,
						prev: '#arrow_left',
						next: '#arrow_right',
						pause: 0,
						before: function(last,current){
							if(!$.browser.msie){
								// Start HTML5 video when you arrive
								if($(current).find('video').length > 0) $(current).find('video')[0].play();
							}
						},
						after: function(last,current){
							if(!$.browser.msie){
								// Pauses HTML5 video when you leave it
								if($(last).find('video').length > 0) $(last).find('video')[0].pause();
							}
						}
					},
					onFirstImageLoaded: function(){
						jQuery('#cycle-loader').hide();
						jQuery('#maximage').fadeIn('fast');
					}
				});
	
				// Helper function to Fill and Center the HTML5 Video
				jQuery('video,object').maximage('maxcover');
	
			});
		</script>
  </body>
</html>
