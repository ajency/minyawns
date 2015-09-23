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
					<li>|</li>
									<!-- <li id="my_jobs"><a id="my_jobs" href="<?php echo site_url()?>/jobs/#my-jobs" >My Jobs</a></li>
					<li id="directory"><a href="<?php echo site_url() ?>/minyawns-directory">Minyawns Directory</a></li> -->
					<li id="directory"><a href="<?php echo site_url() ?>/blog/" class="pop-links">Blog</a></li>
					<li>|</li>
					<!-- <li class="green-btn-top"   >
					 <?php /*if (get_logged_in_role() === 'Minion'): */?>
					<i class="icon-edit"></i>&nbsp;<a href="<?php echo site_url() ?>/edit-profile"> Update Your Profile</a>
					   <?php /*endif;*/ ?>	
						<?php /*if (get_logged_in_role() === 'Employer'): */?>
					<i class="icon-plus-sign" ></i><a href="<?php /*echo site_url() */?>/add-job/">&nbsp; Create a job</a>
					   <?php /*endif;*/ ?>
					   </li> -->

					   <li><a href="#mylogin" data-toggle="modal" id="btn__login" class="pop-links">Login</a></li>
					   <li></li>
					   <li><a href="#myModal" class="btn btn-small btn-green pop-links" data-toggle="modal"  id="link_minyawnregister" onclick="return true">Sign Up</a></li>
					
			</ul>
			


			</div>

			<div class="clear"></div>
		</div>
		
		<!-- modal-->
		<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
	   <div class="modal-header">
		  <button type="button" id="signup_popup_close" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
		  <span id="div_signupheader"><h4 id="myModalLabel">Sign Up as a Minyawn</h4></span>
	   </div>
	   <div class="modal-body">
	  
		  <div id="div_signupmsg" ></div>
		  

		  <!-- testing -->
		   <form name="frm_signup"  id="frm_signup" action="" autocomplete="off">
		   	<input type="hidden" name="signup_role" id="signup_role" value="" />
		   	<input type="hidden" name="profile_pic_path" id="profile_pic_path" value="" />
		   	<input type="hidden" name="profile_image_id" id="profile_image_id" value="" />
			<h6 class="align-center" style=" margin-bottom: 0px; ">
				Create an Account
			</h6>
		   <p class="align-center">Fill out the required information Below</p>

		   <div class="row-fluid" id="signup-error" style="display:none;">
		   	<div class="span12">
		   		<div class="alert alert-error" style="padding: 10px 40px 10px 30px;">
		   			<b style="text-align: center">All the below fields are required</b>&nbsp;        
		   		</div>
		   	</div>
		   </div>

		   <div class="row-fluid" id="signup-error-photo" style="display:none;">
		   	<div class="span12">
		   		<div class="alert alert-error" style="padding: 10px 40px 10px 30px;">
		   			<b style="text-align: center">Upload profile picture</b>&nbsp;        
		   		</div>
		   	</div>
		   </div>

		   <div class="row-fluid">
		   	<div class="span5">
		   		<div class="control-group ">
					<input type="text" value="" name="signup_email"  id="signup_email"  placeholder="Email Address" class="span3">
			   	</div>
			   	<div class="control-group ">
				  	<input type="password" value="" name="signup_password"  id="signup_password" onblur="this.placeholder = 'Password'"  onfocus="this.placeholder = ''" autocomplete="off"  placeholder="Password" class="span3">
			   	</div>

			   	<div class="row-fluid">
			   		<div class="span6">
			   			<div class="control-group" style=" margin-left: 0px; ">
							<input type="text" value=""  name="signup_fname"   id="signup_fname"  placeholder="First Name" class="span3">
						</div>
			   		</div>
			   		<div class="span6">
			   			<div class="control-group">
						  	<input type="text" value=""  name="signup_lname"   id="signup_lname"  placeholder="Last Name" class="span3">
					   	</div>
			   		</div>
			   	</div>
		   	</div>
		   	<div class="span5">
		   		<div class="control-group ">
					<input type="text" value="" name="telephone_no"  id="telephone_no"  placeholder="Telephone Number" class="span3">
			   	</div>
			   	<div class="control-group ">
				  	<input type="text" value="" name="university_name"  id="university_name" placeholder="University Name" class="span3">
			   	</div>
			   	<div class="control-group ">
				  	<input type="text" value="" name="major_in"  id="major_in" placeholder="Major" class="span3">
			   	</div>
		   	</div>
		   	<div class="span2">
		   		<p class="text-center m-b-0">Upload Photo</p>

		   		<div id="avatar">
		   			<img src="<?php echo get_template_directory_uri(); ?>/images/avatar2.jpg" >
		   			<a href="#myprofilepic"  id="change-avatar-span" class="change-avtar avtar-btn" data-toggle="modal"><i class="icon-camera"></i></a>
		   		</div>

		   	</div>
		   </div>

		   <div class="row-fluid">
		   	<div class="span4 offset4">
		   		<button href="#" class="btn btn-large btn-block btn-inverse" id="btn_signup"  type="button">Sign Up</button>
		   	</div>
		   </div>
		   
		</form>

		<div class="row-fluid">
			<div class="span6">
				<h6 class="align-center" style=" margin-bottom: 0px; ">
				   Sign Up Using Facebook
				</h6>
				<p class="align-center">Get using Minyawns, faster !</p>
			</div>
			<div class="span6">
				<?php
				   jfb_output_facebook_btn();
				?>
				<br><br>
				<p class="align-center"><span id="div_alreadyregister">Already registered at Minyawns?</span><a href="#" id="lnk_signin"><b> Sign in here</b></a></p>
			</div>
		</div>
		  <!-- testing -->
		   <span id="div_signup_subheader"></span>
	   </div>
	</div>
		<!-- /modal -->

		<!-- login popup -->
		<!-- LOgin/forgot pass pop up -->
						<input type="hidden" name="hdn_siteurl" id="hdn_siteurl" value="<?php echo site_url(); ?>" />

						<div id="mylogin" class="modal signup  hide fade" tabindex="-1"
							role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
							style="" >
							<div class="modal-header">
								<button id="close_btn" type="button" class="close" data-dismiss="modal"
									aria-hidden="true">
									<img
										src="<?php echo get_template_directory_uri(); ?>/images/delete.png"
										alt="" />
								</button>
								<h4 id="myModalLabel">
									Login to Minyawns
								</h4>
							</div>
							<div class="modal-body">
								<div id="div_loginmsg"></div>
								<div class="row-fluid">
									<div class="span5">


										<form name="frm_login" id="frm_login" action="" autocomplete="off" >
											<div class="control-group ">
								<input type="text" name="txt_email" id="txt_email" value="" placeholder="Email Address" class="span3"
								onblur="this.placeholder = 'Email Address'"  onfocus="this.placeholder = ''"
								autocomplete="off"
								>
											</div>
											<div class="control-group ">
					<input class="span3" type="password" name="txt_pass" id="txt_pass" value=""  onblur="this.placeholder = 'Password'"  onfocus="this.placeholder = ''" autocomplete="off"  placeholder="Password">
					
					
					
											</div>
											<div class="row-fluid">
												<div class="span4">
													
													<a type="button" href="#" class="btn btn-medium btn-block btn-inverse "
														id="btn_login"><i class="icon-unlock-alt"></i> &nbsp;Login</a>
												</div>
												<div class="span8">
													<a href="#"
														style="line-height: 42px; color: #12B13E; font-weight: bold;"
														id="btn_forgotpass">Forgot your password ?</a>
												</div>
											</div>
										</form>


									</div>
									<div class="span2">
									<b class="or">or</b>
									
									</div>
									<div class="span5 fb-login fb-deskstop">
										<h6 class="align-center" style="margin-bottom: 0px;">Login
											Using Facebook</h6>
										<p class="align-center">Get using Minyawns, faster !</p>
										<br>

										<?php /*<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>*/ ?>

										<?php

										//if(is_page('fb-connect-test')){
											jfb_output_facebook_btn();
											jfb_output_facebook_init();
											jfb_output_facebook_callback();
										/*}
										else{
											echo "<p class='align-center'><span style='color:#FA8258; font-weight:bold; font-size:18px; '>Coming soon</span></p>";
										}*/
										?>
									</div>
							
									<span id="div_msgforgotpass"></span>

									<div id="div_forgotpass" class="tab_content_login"
										style="display: none;">

										<p>Enter your username or email to reset your password.</p>
										<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form" id="frm_forgotpassword" name="frm_forgotpassword">
											<div class="username">
												<label for="user_login" class="hide"><?php _e('Username or Email'); ?>:
												</label> <input type="text" name="user_login" value=""
													size="20" id="user_login" tabindex="1001" />
											</div>
											<div class="login_fields">
												<?php //do_action('login_form', 'resetpass'); ?>
												<input type="button" id="user-submit" name="user-submit"
													value="<?php _e('Reset my password'); ?>"
													class="user-submit btn btn-large btn-block btn-inverse span2"
													tabindex="1002" />
												<?php $reset = $_GET['reset']; if($reset == true) { 
													echo '<p>A wmessage will be sent to your email address.</p>';
	} ?>
												<input type="hidden" name="redirect_to"
													value="<?php echo $_SERVER['REQUEST_URI']; ?>;?reset=true" />
												<input type="hidden" name="user-cookie" value="1" />
											</div>
										</form>
									</div>

										<div class="span6 fb-login fb-mobile">
										<h6 class="align-center" style="margin-bottom: 0px;">Login
											Using Facebook</h6>
										<p class="align-center">Get using Minyawns, faster !</p>
										<br>

										<?php echo jfb_output_facebook_btn(); ?>
									</div>

										<span id="signup_subheader">Don’t have an account? <a href="#myModal" <?php /*id="get-minon"*/ ?>  data-toggle="modal" id="link_employerregister" class="login-signup" >Sign up here</a></span>	
								</div>
							</div>

						</div>
						<!-- ENd  LOgin/forgot pass pop up -->

						<!-- modal -->
<div id="myprofilepic" class="modal hide fade cropimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        
        <h4 id="myModalLabel">Change Profile Pic</h4>

    </div>
    <input type="hidden" id="tab_identifier" />
    <div class="modal-body">
        <div style="margin:0 auto; width:500px">

            <div id="thumbs" style="padding:5px; width:500px"></div>
            <div style="width:500px" id="image_upload_body">

                <form id="cropimage" method="post" enctype="multipart/form-data">
                    <a type="button" class="btn btn-primary" id="done-cropped" style="display:none">Done? </a>
                    Upload your image <input type="file" name="files" id="min-profimage" data-user="<?php echo get_user_id(); ?>" />
                    <br>
                    <span id="div_cropmsg"> 
                        <?php /* Please drag to select/crop your picture. */ ?>
                        <p class="help-block meta">Upload an image for your profile.</p></br>
                    </span>
                </br>
                <input type="hidden" name="image_name" id="image_name" value="" />
                <img id="uploaded-image" ></img>
                <span id='preloadprocess' style="display:none"></span>
                <input type="hidden"  id="image_height">
                <input type="hidden"  id="image_width">
                <input type="hidden"  id="image_x_axis">
                <input type="hidden"  id="image_y_axis">
                <input type="hidden"  id="unique_code">
                <input type="hidden" value="<?php echo (get_user_role() == 'employer' ? '2:1' : '1:1') ?>" id="aspect_ratio"> 

            </form>

        </div>
    </div>
</div>

</div>
<!-- modal -->

