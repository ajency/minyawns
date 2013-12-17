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


	
	<title><?php wp_title('|', true, 'right'); ?></title>
	
	
		 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
	<?php wp_head(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43096826-1', 'minyawns.com');
  ga('send', 'pageview');

</script>
	</head>
        <script>
            var siteurl='<?php echo site_url(); ?>';
            var logouturl='<?php echo wp_logout_url('');?>';
            var email='<?php  echo get_user_profile_email() ?>';
            var role='<?php if (get_user_role() == "minyawn"){ echo 'Minion';} else echo 'Employer' ; ?>';
            var logged_in_user_id='<?php echo get_user_id(); ?>'
            var is_logged_in='<?php echo is_user_logged_in();?>';
            var is_admin='<?php echo current_user_can( 'administrator' ); ?>';
            </script>
            <script id="IntercomSettingsScriptTag">
  window.intercomSettings = {
    // TODO: The current logged in user's email address.
    email: "john.doe@example.com",
    // TODO: The current logged in user's sign-up date as a Unix timestamp.
    created_at: 1234567890,
    app_id: "713aa6b2e5840eb65bd9bd214a03b5ba8c7a11b9"
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://static.intercomcdn.com/intercom.v1.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

<body <?php body_class('logged-out'); ?> >
	<div class=" pbl mtn top-menu">
	<?php

					if (is_user_logged_in() == TRUE) {
                            ?>
		<div class="bottom-menu  bottom-menu-inverse top-menu">
		
				<div class="row">
					<div  class="small-tag-line ">
						<p>Minyawns is an easy to use, on-demand, reliable way to find work or help fast.</p>
					</div>
			
					<?php

					if (is_user_logged_in() == TRUE) {
                            ?>
					<div class=" notify <?php if(get_user_role() == 'employer'){ echo 'employer-icon'; }?>  ">
					<div class="pull-right">
						<div id="logged-in">
						
						<div class="user-profile">
									<b><?php echo get_logged_in_email(); ?></b><br>
									Role :<?php echo get_logged_in_role(); ?>
									</div>
						 <div class="profile-pic">
						 <a id="user-popdown" > 
									 <?php 
									if(get_user_avatar() !== false)
										echo get_user_avatar() ;
									else
										echo get_avatar(get_user_id(), 168 ) ?>
									</a>
									</div>
									
									<!--                   
							<a id="user-popdown" href="javascript:void(0);"> <?php 
									if(get_mn_user_avatar() !== false)
										echo get_mn_user_avatar() ;
									else
										echo get_avatar( get_user_id(), 168 ) ?> <b class="caret"></b>
							
                             -->                           </a>
						</div>
						<div class="data-link">
							<a class="" href="<?php echo site_url() ?>/profile"><i class="icon-user"></i> View Profile</a>
						</div>
							<div class="data-link">
							<a class="" href="<?php  echo wp_logout_url(''); ?>"><i class="icon-unlock"></i> Logout</a>
						</div>
							<div class="data-link">
							<a href="<?php echo site_url(); ?>/helpfaqs/" title="Help and FAQ" target="_blank"><i class="icon-question-sign"></i> Help</a>
						</div>
						</div>
							<div class="clear"></div>
					</div>
				
				
				
					

					<?php } ?>
                    </div>
         
            </div> <!-- /bottom-menu-inverse -->
				<div class="top-menu-header">
		<a href="<?php echo site_url(); ?>">
		<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt=""  class="minions-logo"/> 
		</a>
		<div class="main-menu">
		<ul class="inline">
				<li><b>Browse:</b></li>
				<li id="browse"><a id="browse" href="<?php echo site_url()?>/jobs/#browse">All Jobs </a></li>
                                <li id="my_jobs"><a id="my_jobs" href="<?php echo site_url()?>/jobs/#my-jobs" >My Jobs</a></li>
				<li id="directory"><a href="<?php echo site_url() ?>/minyawns-directory">Minions Directory</a></li>
				<li class="green-btn-top"   >
				 <?php if (get_user_role() === 'minyawn'): ?>
				<i class="icon-edit"></i>&nbsp;<a href="<?php echo site_url() ?>/profile/"> Update Your Profile</a>
				   <?php endif; ?>	
				    <?php if (get_user_role() === 'employer'): ?>
				<i class="icon-plus-sign" ></i><a href="<?php echo site_url() ?>/add-job/">&nbsp; Create a job</a>
				   <?php endif; ?>
				   </li>
				
		</ul>
		


		</div>
		<div class="dropdown mobile-menu">
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse Menu <i class="icon-reorder"></i></a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
  
				<li id="browse"><a id="browse" href="<?php echo site_url()?>/jobs/#browse">All Jobs </a></li>
                                <li id="myjobs"><a id="my_jobs" href="<?php echo site_url()?>/jobs/#my-jobs" >My Jobs</a></li>
				<li id="directory" ><a href="<?php echo site_url() ?>/minyawns-directory">Minions Directory</a></li>
				<li >
				 <?php if (get_user_role() === 'minyawn'): ?>
				<a href="#"> Update Your Profile</a>
				   <?php endif; ?>	
				    <?php if (get_user_role() === 'employer'): ?>
					<a href="#"> Create a job</a>
				   <?php endif; ?>
				   </li>
  </ul>
</div>
		<div class="clear"></div>
	</div>
			<?php } else { ?>
					<div class="bottom-menu  bottom-menu top-menu home-menu">
			<div class="container">
				<div class="row">
					<div class="span2 brand">
						<a href="<?php echo site_url(); ?>"><img
							src="<?php echo get_template_directory_uri(); ?>/images/logo.png"
							alt="" /> </a>
					</div>
					<div class="span4"></div>
					

					<div class="span2 upper-link ">
						<!-- <a href="#myModal"  data-toggle="modal">Sign Up </a> &nbsp; &nbsp; 	-->
						<a href="#mylogin" data-toggle="modal" id="btn__login"><i class="icon-signin"></i> Login </a>

					</div>
					

                    </div>
                </div>
            </div> <!-- /bottom-menu-inverse -->
			
			
				<?php } ?>


        </div>

        
        
        
        
        
        
        
        
        
        
  <?php

					if (is_user_logged_in() == FALSE) {
                            ?>      
        
        
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
									<p class="align-center">Get using Minions, faster !</p>
									<br>

									<?php /*<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>*/ ?>

									<?php 	jfb_output_facebook_callback();
									jfb_output_facebook_init();
									jfb_output_facebook_btn();
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
											<?php do_action('login_form', 'resetpass'); ?>
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
									<p class="align-center">Get using Minions, faster !</p>
									<br>

									<?php /*<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>*/ ?>

									<?php 	jfb_output_facebook_callback();
									jfb_output_facebook_init();
									jfb_output_facebook_btn();
									?>
								</div>
									<span id="signup_subheader">Don’t have an account? <a href="#myModal" <?php /*id="get-minon"*/ ?>  data-toggle="modal" id="link_employerregister" class="login-signup" >Sign up here</a></span>	
							</div>
						</div>

					</div>
					<!-- ENd  LOgin/forgot pass pop up -->
 

					<?php } ?>

                    </div>
                </div>
            </div> <!-- /bottom-menu-inverse -->

        </div>

 
