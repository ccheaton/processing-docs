<?php

//Let's get this payparty started
$showDonationForm = false;
$showPaymentForm  = false;
$showDownloadPage = false;
$thankYou 		  = false;
$type 			  = NULL;
$amount 		  = NULL;

// updated by fry for new server layout [140826]
require(realpath(__DIR__ . '/../../../cred/config.php'));

//Check what to show
if(isset($_POST['form'])){
	if($_POST['form'] == 1){ //if form equals 1, user has selected payment amount so show the payment form
		$showPaymentForm = true;	
		$amount = $_POST['selectAmount'];
	} elseif($_POST['form'] == 2){ //if form equals 2, check if payment was Stripe or PayPal
		$type = $_POST['type'];
		if($_POST['type'] == 'stripe'){ //if stripe, include Stripe processing	
			require('_stripeProcessing.php');
		} elseif($_POST['type'] == 'paypal'){ //if PayPal, include PayPal processing
			require('_paypalProcessing.php');
		}
	}
} else {
	if(isset($_GET['thankyou'])){ //if we have our thankyou query, show downloads
		if($_GET['thankyou'] == 'paypal') require('_ppEmailThanks.php');
		$showDownloadPage = true;
		$thankYou = true;
	} elseif(isset($_GET['processing'])){
		$showDownloadPage = true;
	} else { //show donation form
		$showDonationForm = true;
	}
} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Download \ Processing.org</title>
		
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="Author" content="Processing Foundation" />
		<meta name="Publisher" content="Processing Foundation" />
		<meta name="Keywords" content="Processing, Sketchbook, Programming, Coding, Code, Art, Design" />
		<meta name="Description" content="Processing is a flexible software sketchbook and a language for learning how to code within the context of the visual arts. Since 2001, Processing has promoted software literacy within the visual arts and visual literacy within technology." />
		<meta name="Copyright" content="All contents copyright the Processing Foundation, Ben Fry, Casey Reas, and the MIT Media Laboratory" />

		<script src="/javascript/modernizr-2.6.2.touch.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/javascript/jquery-1.9.1.min.js"><\/script>')</script>
		<script src="/javascript/site.js" type="text/javascript"></script>
		<? if($showDonationForm): ?>
			<script type="text/javascript" src="_js/select.js"></script>
		<? endif; ?>
		<? if($showPaymentForm): ?>
			<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
			<script type="text/javascript">Stripe.setPublishableKey('<?php echo $config['publishable-key'] ?>');</script>
			<script type="text/javascript" src="_js/jquery.validate.min.js"></script>
			<script type="text/javascript" src="_js/donate.js"></script>
		<? endif; ?>
	
		<link href="/css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body id="Download" onload="" >
		
		<!-- ==================================== PAGE ============================ --> 
		<div id="container">
	
			<!-- ==================================== HEADER ============================ --> 
			<div id="ribbon">
				<ul class="left">
					<li class="highlight"><a href="http://processing.org/">Processing</a></li>
					<li><a href="http://p5js.org/">p5.js</a></li>
					<li><a href="http://py.processing.org/">Processing.py</a></li>
				</ul>
				<ul class="right">
					<li><a href="http://foundation.processing.org/">Processing Foundation</a></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div id="header">
				<a href="/" title="Back to the Processing cover."><div class="processing-logo no-cover" alt="Processing cover"></div></a>
				<form name="search" action="http://www.google.com/search" method="get">
				    <p><input type="hidden" name="as_sitesearch" value="processing.org" />
				    <input type="text" name="as_q" value="" size="20" class="text" /> 
					<input type="submit" value=" " /></p>
				</form>
			</div> 
			<a id="TOP" name="TOP"></a>
			
			<!-- ==================================== NAVIGATION ============================ -->
			<div id="navigation">
				<div class="navBar" id="mainnav_noSub">
					<a href="/">Cover</a><br><br>
					<a href="/download/" class="active">Download</a><br><br>
					<a href="/exhibition/">Exhibition</a><br><br>
					<a href="/reference/">Reference</a><br>
					<a href="/reference/libraries/">Libraries</a><br>
					<a href="/reference/tools/">Tools</a><br>
					<a href="/reference/environment/">Environment</a><br><br>
					<a href="/tutorials/">Tutorials</a><br>
					<a href="/examples/">Examples</a><br>
					<a href="/books/">Books</a><br>
					<a href="/handbook/">Handbook</a><br><br>
					<a href="/overview/">Overview</a><br> 
					<a href="/people/">People</a><br><br />
					<!--<a href="/foundation/">Foundation</a><br><br>-->
					<a href="/shop/">Shop</a><br><br>
					<a href="http://forum.processing.org" class="outward"><span>&raquo;</span>Forum</a><br>
    				<a href="https://github.com/processing" class="outward"><span>&raquo;</span>GitHub</a><br>
    				<a href="https://github.com/processing/processing/issues?state=open" class="outward"><span>&raquo;</span>Issues</a><br>
    				<a href="http://wiki.processing.org" class="outward"><span>&raquo;</span>Wiki</a><br>
    				<a href="http://wiki.processing.org/w/FAQ" class="outward"><span>&raquo;</span>FAQ</a><br>
    				<a href="https://twitter.com/processingOrg" class="outward"><span>&raquo;</span>Twitter</a><br>
					<a href="https://www.facebook.com/page.processing" class="outward"><span>&raquo;</span>Facebook</a>
				</div>
			</div>

			<!-- ==================================== CONTENT ============================ -->
			<div class="content">

			<? if($showDonationForm): ?>
				<? require('_selectForm.php'); ?>
			<? elseif($showPaymentForm): ?>
				<? require('_paymentForm.php'); ?>
			<? elseif($showDownloadPage): ?>
				<? require('_downloads.php'); ?>
			<? endif; ?>
      
			</div>

			<!-- ==================================== FOOTER ============================ --> 
  			<div id="footer">
    			<div id="copyright">Processing was initiated by <a href="http://benfry.com/">Ben Fry</a> and <a href="http://reas.com">Casey Reas</a>. It is developed by a <a href="/people/">small team of volunteers</a>.</div> 
    			<div id="colophon">
                    <a href="/copyright.html">&copy; Info</a> \ <span>Site hosted by <a href="http://www.mediatemple.net">Media Temple!</a></span>
                </div>
  			</div>
  			
		</div>
		<script type="text/javascript">

		 var _gaq = _gaq || [];
		 _gaq.push(['_setAccount', 'UA-40016511-1']);
		 _gaq.push(['_trackPageview']);

		 (function() {
		   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		 })();

		</script>
	</body>
</html>
