<?php
/**
 * Template Name: Homepage
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ajency
 * @subpackage Better_Rentals
 */

global $wpdb ;


get_header(); ?>
			<input type="hidden" name="hdn_siteurl" id="hdn_siteurl" value ="<?php echo site_url(); ?>" />
<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
    <h4 id="myModalLabel">Sign Up to <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </h4>
  </div>
  <div class="modal-body">
    <div class="row-fluid">
		<div class="span6"> 
		
			<form name="frm_signup"  id="frm_signup" action="" >
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
				  <a href="#fakelink" class="btn btn-large btn-block btn-inverse" id="btn_signup" >Sign Up</a>
			</form>
			
			
		</div>
		
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Sign Up Using Facebook</h6>
<p class="align-center">Get using minyawns, faster !</p><br><br>

		<?php /*<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>*/?>
		<?php 	jfb_output_facebook_btn(); ?>
		<br><br>
		<p class="align-center">Already a Minyawn?<a href="#"><b> Sign in here</b></a></p>
		</div>
		
	</div>
  </div>
  
</div>

<div id="mylogin" class="modal signup  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
  <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
    <h4 id="myModalLabel">Login to <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </h4>
  </div>
  <div class="modal-body">
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
			<div class="span4"><a href="#fakelink" class="btn btn-large btn-block btn-inverse "  id="btn_login" >Login</a></div>
				<div class="span8"><a href="#"  style=" line-height: 42px; color: #12B13E;font-weight:bold; ">Forget your password ?</a></div>
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
		
	</div>
  </div>
  
</div>
			
    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-select.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-switch.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/flatui-checkbox.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/flatui-radio.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.tagsinput.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.placeholder.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.stacktable.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/application.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.pep.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.dragsort-0.5.1.js"></script>
	
	
		<script src="<?php echo get_template_directory_uri(); ?>/js/awm-custom.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js"></script>
	
  </body>
</html>	
			


<?php get_footer(); ?>