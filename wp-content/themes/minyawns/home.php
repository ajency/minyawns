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

                        Minyawns is an easy to use. on-demand. reliable way to find work help fast.<br>
                        Backed by University of Washington students, designed for business professionals

                    </div>
                    <hr>
                    <div class="row-fluid">
                        <div class="span4"></div>
                        <div class="span2"><a  href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-primary"  id="link_employerregister" >Get a Minion </a></div>
                        <div class="span2"><a href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-info"  id="link_minyawnregister"  >Become a Minion</a></div>
                        <div class="span4"></div>
                    </div>	
                </div>

            </div>
			<div class="bg-overflow">
            <img class="bg-background" src="<?php echo get_template_directory_uri() ?>/images/banner1.jpg"/>
			</div>
        </div>
        <!-- End  Banner Layout -->
			
			<div class="video-home ">
			<div class="container">
				<div class="row-fluid ">
				<div class="span1">
				 
				</div>
				<div class="span5">
				 <a  href="#video1"  data-toggle="modal"><img src="<?php echo get_template_directory_uri() ?>/images/minyawns-students.png"/></a>
				  <a  href="#video1"  data-toggle="modal"  style="color: #34495E;"> <h3>Minyawns For Students</h3></a>
				</div>
				<div id="video1" class="modal hide fade video-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-body">
						<p><iframe width="530" height="351" src="http://www.powtoon.com/embed/gbbkC7yIduS/" frameborder="0" allowfullscreen></iframe></p>
					  </div>
					  <div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					</div>
				</div>
				<div class="span5">
					 <a  href="#video2"  data-toggle="modal"> <img src="<?php echo get_template_directory_uri() ?>/images/minyawns-bussiness.png"/></a>
				 <a  href="#video2"  data-toggle="modal" style="color: #34495E;"> <h3>Minyawns For Businesses</h3></a>
				 <div id="video2" class="modal hide fade video-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-body">
						<p><iframe width="530" height="351" src="http://www.powtoon.com/embed/gdPRX5igKP7/" frameborder="0" allowfullscreen></iframe></p>
					  </div>
					  <div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					</div>
				</div>
				</div>
				<div class="span1">
				 
				</div>
				</div>
			</div>
			</div>
		
		
		
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
                    <h3 class="small-header">Request a Minion</h3>
                    <p class="small-desc">Pick a time, place, price and <br>describe your task.</p>
                </div>
                <div class="span2">
				  <div class="workflow2">
                        <i class="icon-heart i-money"></i>
                    </div>
                    <h3 class="small-header">Pick your favorite</h3>
                    <p class="small-desc">Put your minion to work when they arrive.</p>
                    </div>
                <div class="span3">
                  <div class="workflow">
                        <i class="icon-user i-user"></i>
                    </div>
                    <h3 class="small-header">Get Work Done</h3>
                    <p class="small-desc">Sit back, relax and enjoy <br>checking off your to-do list.</p>
                </div>
						
						
                </div>
                <div class="span2"></div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="big-heading-title">The power and resources of an elite billion-dollar institution, awaiting your command. </h3>
                    <p class="big-heading-desc">Minyawns - minions so good you can yawn- is an online service that is revolutionizing traditional staffing temp agencies through on-demand short time minions. 
Businesses and Individual Professionals can post tasks and immediately receive assistance from a crowd of highly intelligent and motivated university students that want to prove themselves. With over 165 majors, our students literally cover anything you would expect or need. Additionally Minyawns provides a marketplace for students to strengthen resumes and gain experience, while business can help mold the future generation.</p>
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
				  <button href="#" class="btn btn-large btn-block btn-inverse" id="btn_signup"  type="button">Sign Up</button>
			</form>
			
			
		</div>
		
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Sign Up Using Facebook</h6>
<p class="align-center">Get using Minions, faster !</p><br><br><br>


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
