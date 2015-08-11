	<!doctype html>

	<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
	<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
	<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
	<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
	<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
	<html <?php language_attributes(); ?> class="no-js">
	<!--<![endif]-->

		<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<meta name="keywords" content="one day interns, reliable help
	,temp workers
	,one day jobs
	,where to post a gig
	,where to find interns
	,how to get interns
	,hire an intern
	,where to hire college students in seattle
	,hiring college seasonal work
	,hire short term college students
	,Part time university reasources">
		
		<title><?php wp_title('|', true, 'right'); ?></title>
		
			<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
			<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">-->
	<!--<meta name="apple-mobile-web-app-capable" content="yes">-->
	<!--<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">-->
		<!--<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:800' rel='stylesheet' type='text/css'>
	   
		<!-- media-queries.js (fallback) -->
		<!--[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
		<![endif]-->
		
		<!-- html5.js -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png">
	
		<!-- wordpress head functions -->
		<?php wp_head(); 
			//require 'essential-scripts.php';
			?>
		  
		<!--Start of Zopim Live Chat Script-->
		<script type="text/javascript">
		window.$zopim||(function(d,s){var z=$zopim=function(c){
		z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
		$.src='//v2.zopim.com/?1XmR5kCIDQtO4j3qMe0N8Uk2q4R5kd2Y';z.t=+new Date;$.
		type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
		</script>
		<!--End of Zopim Live Chat Script-->
		
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43096826-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- AddThisEvent -->
<script type="text/javascript" src="https://addthisevent.com/libs/1.5.8/ate.min.js"></script>
<!-- AddThisEvent Settings -->
<script type="text/javascript">
addthisevent.settings({
	mouse		: false,
	css			: false,
	outlook		: {show:true, text:"Outlook Calendar"},
	google		: {show:true, text:"Google Calendar"},
	yahoo		: {show:true, text:"Yahoo Calendar"},
	ical		: {show:true, text:"iCal Calendar"},
	hotmail		: {show:true, text:"Hotmail Calendar"},
	facebook	: {show:false, text:"Facebook Calendar"}
});
</script>

		</head>
			<script>
				var siteurl='<?php echo site_url(); ?>';
				var logouturl='<?php echo wp_logout_url('');?>';
				var email='<?php  echo get_user_profile_email() ?>';
				var role='<?php if (get_user_role() == "minyawn"){ echo 'Minyawn';} else echo 'Employer' ; ?>';
				var logged_in_role='<?php echo get_logged_in_role() ?>';
				var logged_in_user_id='<?php echo get_user_id(); ?>'
				var is_logged_in='<?php echo is_user_logged_in();?>';

				<?php if (get_logged_in_role() == 'Minion'){ ?>
				//var profile_completed = '<?php echo check_if_minion_profile_completed(); ?>';
				var profile_completed = 'yes';
				<?php } ?>

				<?php $user = new WP_User( get_user_id() );
						if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
							foreach ( $user->roles as $role )
								$currentpage_user_role =  $role;
						} 
				?>
				 var currentpage_user_role = '<?php echo $currentpage_user_role; ?>'
				var is_admin='<?php echo current_user_can( 'administrator' ); ?>';
				var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
				</script>

	<body>


					<div class="top-menu-header student-header">
			<a href="<?php echo site_url(); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt=""  class="minions-logo"/> 
			</a>
			&nbsp;<b style="color:#fff;">Follow us</b>&nbsp;&nbsp;<a href="https://www.facebook.com/minyawn" target="_blank"> <img src="<?php echo get_template_directory_uri(); ?>/images/social-fb.png" alt="" /></a>  &nbsp;<a href="https://twitter.com/Minyawns"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/social-twitter.png" alt="" /> </a>
			<!-- city -name-->
		 	&nbsp;&nbsp;<!-- <b class="text-primary">City : <abbr ><?php echo get_option('Minyawn_city');?></abbr></b> -->
			<!-- city -name-->
			<div class="main-menu">
			<ul class="inline">
					<!-- <li><b>Browse:</b></li> -->
					<li id="browse"><a id="browse" href="<?php echo site_url()?>/jobs/#browse" class="pop-links">All Jobs </a></li>
									<!-- <li id="my_jobs"><a id="my_jobs" href="<?php echo site_url()?>/jobs/#my-jobs" >My Jobs</a></li>
					<li id="directory"><a href="<?php echo site_url() ?>/minyawns-directory">Minyawns Directory</a></li> -->
					<li id="directory"><a href="<?php echo site_url() ?>/blog/" class="pop-links">Blog</a></li>
					<!-- <li class="green-btn-top"   >
					 <?php /*if (get_logged_in_role() === 'Minion'): */?>
					<i class="icon-edit"></i>&nbsp;<a href="<?php echo site_url() ?>/edit-profile"> Update Your Profile</a>
					   <?php /*endif;*/ ?>	
						<?php /*if (get_logged_in_role() === 'Employer'): */?>
					<i class="icon-plus-sign" ></i><a href="<?php /*echo site_url() */?>/add-job/">&nbsp; Create a job</a>
					   <?php /*endif;*/ ?>
					   </li> -->

					   <li><a href="" class="pop-links">Login</a></li>
					   <li>|</li>
					   <li><a href="" class="btn btn-small btn-green pop-links">Signup</a></li>
					
			</ul>
			


			</div>

			<div class="clear"></div>
		</div>
				

