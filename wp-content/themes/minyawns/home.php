
<?php
/**
Template Name: Home Page
 */
get_header(); 

global $post;  
?>

<style type="text/css">
.fbLoginButton img
{
	margin: auto;
	display: block;
}
</style>
<input type="hidden" name="hdn_siteurl" id="hdn_siteurl" value ="<?php echo site_url(); ?>" />


<div id="innermainimage">
            <div class="row-fluid banner-content">
                <div class="span12">
                    <img src="<?php echo get_template_directory_uri() ?>/images/minyawns.png"/>
                    <div class="banner-desc">
                        Minyawans is an easy to use. on-demand,<br>
                        student labour sourcing application
                    </div>
                    <hr>
                    <div class="row-fluid">
                        <div class="span4"></div>
                        <div class="span2"><a  href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-primary"  id="link_minyawnregister" >Get a Minyawn</a></div>
                        <div class="span2"><a href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-info"  id="link_employerregister"  >Become a Minyawn</a></div>
                        <div class="span4"></div>
                    </div>	
                </div>

            </div>
            <img class="bg-background" src="<?php echo get_template_directory_uri() ?>/images/banner1.jpg"/>
        </div>
        <!--End  Banner Layout --->

        <div id="init-land" class="container">
            <div class="row-fluid">
                <div class="span12"><h3 class="heading-title">How does it work ? </h3></div>
            </div>
            <div class="row-fluid">
                <div class="span2"></div>
                <div class="span3">
                    <div class="workflow1">
                        <i class="icon-calendar-empty i-cal"></i>
                    </div>
                    <h3 class="small-header">Request a Minyawan</h3>
                    <p class="small-desc">Pick a time and describe <br> your task.</p>
                </div>
                <div class="span2">
                    <div class="workflow">
                        <i class="icon-user i-user"></i>
                    </div>
                    <h3 class="small-header">Get Work Done</h3>
                    <p class="small-desc">Take care of projects on your
                        to-do list.</p>
                </div>
                <div class="span3">
                    <div class="workflow2">
                        <i class="icon-dollar i-money"></i>
                    </div>
                    <h3 class="small-header">Profit !</h3>
                    <p class="small-desc">Enjoy having less <br>
                        work to do.</p>
                </div>
                <div class="span2"></div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="big-heading-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit </h3>
                    <p class="big-heading-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis 
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                </div>
            </div>
            
<div id="mylogin" class="modal signup  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
  <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
    <h4 id="myModalLabel">Login to <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </h4>
  </div>
  <div class="modal-body">
  <div id="div_loginmsg"></div>
    <div class="row-fluid">
	
		<div class="span6"> 
	
		
		<form name= "frm_login" id="frm_login" action="" >
		<div class="control-group ">
            <input type="text" name="txt_email"  id="txt_email"  value="" placeholder="Email Address" class="span3">
          </div>
		<div class="control-group ">
            <input type="password"  name="txt_pass"  id="txt_pass"  value="" placeholder="Password" class="span3">
          </div>
		  <div class="row-fluid">
			<div class="span4"><a href="#" class="btn btn-large btn-block btn-inverse "  id="btn_login" >Login</a></div>
				<div class="span8"><a href="#"  style=" line-height: 42px; color: #12B13E;font-weight:bold; " id="btn_forgotpass">Forget your password ?</a></div>
		  </div> 
		</form>  
		  
		  
		  </div>
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Login Using Facebook</h6>
<p class="align-center">Get using minyawns, faster !</p><br>

		<?php /*<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>*/ ?>
		
	<?php 	jfb_output_facebook_btn(); ?>
		</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<div id="div_forgotpass" class="tab_content_login" style="display:none;">

	<span id="div_msgforgotpass"></span>

	
		<p>Enter your username or email to reset your password.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="button" id="user-submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit btn btn-large btn-block btn-inverse span2" tabindex="1002" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true"  />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
		
		
		
		
		
		
		
		
		
	
	 
		<input type="hidden" name= "hdn_rest" id="hdn_reset" value="<?php if(isset($_REQUEST['reset']))     echo $_REQUEST['reset']; else echo "norequest" ?>" />
	 
		
		
		
	
		
	</div>
  </div>
  
</div>
<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
    <h4 id="myModalLabel">Sign Up to <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </h4>
  </div>
  <div class="modal-body">
  	<div id="div_signupmsg" ></div>
    <div class="row-fluid">
		<div class="span6"> 
		
			<form name="frm_signup"  id="frm_signup" action="" >
			<input type="hidden" name="signup_role" id="signup_role" value="" />
				<h6 class="align-center" style=" margin-bottom: 0px; ">
				Create an Account</h6>
		<p class="align-center">Fill out the required information Below</p>
		
				<div class="control-group ">
		            <input type="text" value="" name="signup_email"  id="signup_email"  placeholder="Email Address" class="span3">
		        </div>
				<div class="control-group ">
		            <input type="password" value="" name="signup_password"  id="signup_password"  placeholder="Password" class="span3">
		        </div>
				  <div class="control-group span6 " style=" margin-left: 0px; ">
		            <input type="text" value=""  name="signup_fname"   id="signup_fname"  placeholder="First Name" class="span3">
		          </div>
				<div class="control-group span6 ">
		            <input type="text" value=""  name="signup_lname"   id="signup_lname"  placeholder="Last Name" class="span3">
		          </div>
				  <div class="clear"></div>
				  <a href="#" class="btn btn-large btn-block btn-inverse" id="btn_signup" >Sign Up</a>
			</form>
			
			
		</div>
		
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Sign Up Using Facebook</h6>
<p class="align-center">Get using minyawns, faster !</p><br><br>

		<?php /*<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>*/?>
		<?php 	
		jfb_output_facebook_callback();
		jfb_output_facebook_init();
		jfb_output_facebook_btn(); ?>
		<br><br>
		<p class="align-center">Already a Minyawn?<a href="#"><b> Sign in here</b></a></p>
		</div>
		
	</div>
  </div>
  
</div>
 <?php
get_footer();
?>