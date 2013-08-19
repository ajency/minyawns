<?php
if(is_user_logged_in())
	wp_redirect(site_url()."/profile/");
/**
Template Name: Home Page
 */
get_header(); 


?>
<div id="innermainimage">
            <div class="row-fluid banner-content">
                <div class="span12">
                    <img class="log-img" src="<?php echo get_template_directory_uri() ?>/images/minyawns.png"/>
                    <div class="banner-desc">
                        Minyawans is an easy to use. on-demand,<br>
                        student labour sourcing application
                    </div>
                    <hr>
                    <div class="row-fluid">
                        <div class="span4"></div>
                        <div class="span2"><a  href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-primary"  id="link_employerregister" >Get a Minyawn</a></div>
                        <div class="span2"><a href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-info"  id="link_minyawnregister"  >Become a Minyawn</a></div>
                        <div class="span4"></div>
                    </div>	
                </div>

            </div>
            <img class="bg-background" src="<?php echo get_template_directory_uri() ?>/images/banner1.jpg"/>
        </div>
        <!-- End  Banner Layout -->

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
            

<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
  <div class="modal-header">
        <button type="button" id="signup_popup_close" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
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
		            <input type="text" value=""  name="signup_fname"   id="signup_fname"  placeholder="Name" class="span3">
		          </div>
				<div class="control-group span6 ">
		            <input type="text" value=""  name="signup_lname"   id="signup_lname"  placeholder="Company Name" class="span3">
		          </div>
				  <div class="clear"></div>
				  <a href="#" class="btn btn-large btn-block btn-inverse" id="btn_signup" >Sign Up</a>
			</form>
			
			
		</div>
		
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Sign Up Using Facebook</h6>
<p class="align-center">Get using minyawns, faster !</p><br><br><br>


		<?php 	
		
		jfb_output_facebook_btn(); ?>
		<br><br>
		<p class="align-center"><span id="div_alreadyregister">Already registered to Minyawn?</span><a href="#" id="lnk_signin"><b> Sign in here</b></a></p>
		</div>
		
	</div>
  </div>
  
</div>
 <?php
get_footer();
