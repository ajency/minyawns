<?php
   if(is_user_logged_in())
   	wp_redirect(site_url()."/profile/");
   /**
   Template Name: Home Page
    */
   get_header(); 
   
   ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
    $('#powtoon-frame').load(function(){
        $(this).show();
      
    });

    $('#click1').on('click', function(){
      
        $('#powtoon-frame').attr('src', 'http://www.powtoon.com/embed/gbbkC7yIduS?autoplay=1');    
    });
    
     $('#powtoon-frame1').load(function(){
        $(this).show();
      
    });

    $('#click').on('click', function(){
      
        $('#powtoon-frame1').attr('src', 'http://www.powtoon.com/embed/gdPRX5igKP7?autoplay=1');    
    });
});
    </script>
<div id="innermainimage">

<div id="home-video">
  <img  data-video="http://www.youtube.com/embed/niu4tNbD6IY?autoplay=1&vq=hd720" title="Play Video" />
  <span class="play-button"></span>
</div>

   <div class="row-fluid banner-content">
    
     

   
		 <div class="row-fluid">
				<div class="span12">
					<div class="banner-title">Need some extra hands for a day?</div>
					<div class="banner-desc">Access a network of reliable college workers</div>
					<div class="text-center b-text">
					<a class="btn btn-huge btn-green" href="#myModalBiz" data-toggle="modal" id="link_employerregister" onclick="return true">Join Free Today</a>
          			
		  </div>
				</div>
			
		 </div>
		
      </div>

      
	
   	<!-- <div class="row-fluid learn-more-btn">
				<div class="span12 learn-more">
				<a href="#pliip" class="jumper"> Learn More
				<br>
				<i class="icon-chevron-down"></i>
				</a>
				</div>
				</div> -->
   <!-- <div class="bg-overflow">
		
   </div> -->
</div>
<!-- slider -->
<div class="owl-cover">	
	<div class="container banner-owlcarousel">
		<div class="row-fluid">
			<div class="span12">
				<h4 class="text-center">OUR LATEST WORK</h4>
				<?php echo do_shortcode('[owl-carousel category="business" items="4" autoPlay="true"]'); ?>
			</div>
		</div>
	</div>
</div> <!-- /owl-cover -->
<!-- slider -->
<div id="pliip" class="how-does-it-work">
<div class="">
   <h3 class="heading-title">How does it work?</h3>
   <p class="excerpt">Post your gig. wait for students to apply, review their profiles, and put them to work!</p>
   </div>
     
   <div class="container steps-3">
      <div class="row-fluid">
         <div class="span4">
		 	 <div class="step1-1"></div>
            
            <h4><span class="badge badge2">1</span> Post one-day jobs</h4>
            <p>Describe what you need to get done, when you want help, and how much you are willing to pay.</p>
         </div>
         <div class="span4">
           <div class="step2-2"></div>
            <h4> <span class="badge badge2">2</span> Review your applicants</h4>
            <p>We're talking about professional, reliable, competent and sociable young college students looking for work.</p>
         </div>
         <div class="span4">
               <div class="step3-3"></div>
            <h4> <span class="badge badge2">3</span> Get the help you need.</h4>
            <p>Get productive, end your to-do list and get help for your event.</p>
         </div>
      </div>
      <br>
	 
   </div>
  <!-- <h4 class="video-title"> Revolutionize the way you get things done.</h4>
   <div class="row-fluid">
			<div class="span3"></div>
			
			<div class="span3">
			<a id="click1" href="#video1"  data-toggle="modal" class="btn btn-normal btn-huge btn-block btn-primary" ><i class="icon-youtube-play"></i> &nbsp; Minyawns For Students</a>
			</div>
			<div class="span3">
			
			<a id="click"  href="#video2"  data-toggle="modal" class="btn btn-normal btn-huge btn-block btn-info" ><i class="icon-youtube-play"></i> &nbsp; Minyawns For Businesses</a>
			</div>
			<div class="span3">
			
			</div>
			
   </div> -->
   
</div>

<!-- <div class="customers">
    <div>
      <h3 class="heading-title">Here's Our Customers</h3>
      <p class="excerpt">Simply and effectively bridging the gap between businesses and minyawns.</p>
   </div>
 <div class="slider1">
      <div class="slide cus_1"></div>
    <div class="slide cus_2"></div>
    <div class="slide cus_3"></div>
    <div class="slide cus_4"></div>
    <div class="slide cus_5"></div>
    <div class="slide cus_6"></div>
    <div class="slide cus_7"></div>
    <div class="slide cus_8"></div>
    <div class="slide cus_9"></div>
    <div class="slide cus_10"></div>
    <div class="slide cus_11"></div>
    <div class="slide cus_12"></div>
    <div class="slide cus_13"></div>
    <div class="slide cus_14"></div>
    <div class="slide cus_15"></div>
   
   </div><br><br> 
   <div class="clients-gallery">
   	<?php /*echo do_shortcode('[Best_Wordpress_Gallery id="1" gal_title="clients"]'); */?>
   </div>
</div> -->

<!--<div class="what-we-can-do">
     <div id="down"></div>
     <div class="stamp">
   		<img src="<?php echo get_template_directory_uri() ?>/images/span4_N.png"/>
   	</div>
   <div class="">
      <h3 class="heading-title">What can we do?</h3>
      <p class="excerpt">The minyawns have superpowers, find out what they are.</p>
   </div>
 
   <div class="container">
   
      <div class="row-fluid m-80">
         <!--<div class="span8">
            <br>
			<div class="row-fluid">
				<div class="span12">
					<ul class="unstyled minyawn-category">
						<li>
						<div class="list-data">
							<div class="icon-data"><i class="icon-briefcase"></i> <span>Office Work</span>
							</div>	
							<div class="data-info">
								
							Data Entry<br>
							Newsletter<br>
							Email Organization<br>
							Mailing Calenders<br>
							Personal Assistance
							
							</div>
							<div class="clear"></div>
							</div>
						</li>
						<li>
						<div class="list-data">
							<div class="icon-data"><i class="icon-wrench"></i><span>	LABOR</span></div>	
							<div class="data-info">
								
							Moving<br>
							Yardwork<br>
							reorganization <br>
							extra hand
							
							</div>
							<div class="clear"></div></div>
						</li>
						<li>
						<div class="list-data">
							<div class="icon-data"><i class="icon-group"></i><span>MARKETING	</span></div>	
							<div class="data-info">
							AD FLYER HANDOUT<br>
							IN PERSON PROMOTION<br>
							 Booth sales<br>
							TWITTER MARKETING
							
							</div>
							<div class="clear"></div></div>
						</li>
						<li>
						<div class="list-data">
							<div class="icon-data"><i class="icon-flag-checkered"></i> <span>Event	</span></div>	
							<div class="data-info">
								
							 HANDYMAN/WOMEN<br>
							EVENT STUFF<br>
							SERVER/HOSTESS<br>
							BOUNCER / SECURITY GUARD<br>
							BABY SITTER

							
							</div>
							<div class="clear"></div></div>
						</li>
					</ul>
				
				</div>
				
			</div>
     <!--      <div id="myCarousel" class="carousel slide">
               <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
               </ol>
              
               <div class="carousel-inner">
                  <div class="active item">
                     <img src="<?php echo get_template_directory_uri() ?>/images/slider1.png" data-interval="500" data-slide-to="0" />
                     <div class="carousel-caption">
                        <h4>Almost anything !</h4>
                        <p>From simple tasks like office work, labor jobs, and event set-up to ones that need more specialty, our minyawns can do it all. You may just need an extra hand, our minyawns are capable of learning quickly on the job.
                        </p>
                     </div>
                  </div>
                  <div class="item">
                     <img src="<?php echo get_template_directory_uri() ?>/images/slider2.png" data-interval="500" data-slide-to="1" />
                     <div class="carousel-caption">
                        <h4>Make you feel in charge!</h4>
                        <p>Our Minyawns are equipped with the valuable skills from top universities. It's like having power and resources of an élite billion-dollar institution, awaiting your command.</p>
                     </div>
                  </div>
                  <div class="item">
                     <img src="<?php echo get_template_directory_uri() ?>/images/slider3.png" data-interval="500"  data-slide-to="2" />
                     <div class="carousel-caption">
                        <h4>We are safe, reliable, and easy!</h4>
                        <p>We take safety and reliability seriously. We aren't Craigslist but we are backed by motivated college students just looking for some extra money for books and snacks.</p>
                     </div>
                  </div>
               </div>
            </div>
		</div>-->
		<!--<div class="span4">
			<div class="back-satisfication">
				<div class="text">
					We are so sure that Minyawns will be the best decision you have ever made. If you are not satisfied for any 
					reason <img src="<?php echo get_template_directory_uri() ?>/images/satisfication.png" align="right"/>at all we will fully refund every cent you spent, 
					no questions asked.<br><br>
					<h4>Sign up and we'll demolish your to-do list today.</h4>
				</div>
				<button href="#myModal"  data-toggle="modal" class="btn btn-large btn-info" type="button">Get started now!</button>
			</div>
		</div>-->
		
		<!--<div class="span6">
			<div class="row-fluid">
			<div class="span4 wwcd-1 width100">
			
			</div>
			<div class="span8 m100">
		<h5 class="white">THE BIZ GURU</h5>
		<p class="white">The Biz Guru is here to represent your business. A personable Minyawn can help you sell your business through cold-calls, data-entry, marketing and more.</p>
			</div>
			</div>
		</div>
		
		<div class="span6">
			<div class="row-fluid">
			<div class="span4 wwcd-2 width100">
			
			</div>
			<div class="span8 m100">
			<h5 class="white">THE TESTER</h5>
			<p class="white">Perfect for any tech company trying to test their product. Schedule a group of testers for market research and genuine feedback.</p>
			</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid m-50">
			<div class="span4 wwcd-3 width100">
			
			</div>
			<div class="span8 m100">
			<h5 class="white">THE TECHIE</h5>
			<p class="white">Anything tech related -computers, phones, etc. Our techies can help you now, and teach you how to solve future problem.</p>
			</div>
			</div>
		</div>
		
		<div class="span6">
			<div class="row-fluid m-50">
			<div class="span4 wwcd-4 width100">
			
			</div>
			<div class="span8 m100">
			<h5 class="white">THE SERVER</h5>
			<p class="white">Good looking, outgoing, and know how to please your guests. Use them for any fancy event you to ensure a good time.</p>
			</div>
			</div>
		</div>
		</div>
   </div>

 
</div>-->
<!--ios/android-->
<!-- <div class="ios-android">
	<div>
		<h3 class="heading-title">mobile<span class="highlight"> app</span></h3>
		<p class="excerpt">Just a click away from your new job.</p>
	</div>
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<div class="tab-content">
					<div class="tab-pane active" id="ios">
						<div class="row">
							<div class="span8">
								<h1>iOS App</h1>	
								<p>Minyawns App is an easy to use,on-demand, reliable way for University of Washington students to easily find part time jobs. The app allows students to search for jobs,apply to them by uploading their photo and check the status of their application. Minyawns can access their account with by logging in with the facebook account or using the web app credentials </p>
								<a href="https://itunes.apple.com/us/app/minyawns/id951685419?mt=8"><img src="<?php echo get_template_directory_uri() ?>/images/app-store.png"/></a>
							</div>
							<div class="span4">
								<img src="<?php echo get_template_directory_uri() ?>/images/ios.png"/>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="android">
						<div class="row">
							<div class="span8">
								<h1>Android App</h1>
								<p>Minyawns App is an easy to use,on-demand, reliable way for University of Washington students to easily find part time jobs. The app allows students to search for jobs,apply to them by uploading their photo and check the status of their application. Minyawns can access their account with by logging in with the facebook account or using the web app credentials </p>
								<a href="https://play.google.com/store/apps/details?id=com.minyawns.minyawnsdelivered&hl=en"><img src="<?php echo get_template_directory_uri() ?>/images/google-play.png"/></a>
							</div>
							<div class="span4">
								<img src="<?php echo get_template_directory_uri() ?>/images/android.png"/>
							</div>
						</div>
					</div>
				</div>
				<ul class="nav nav-tabs" id="myTab2">
					<li class="active ios"><a href="#ios">iOS</a></li>
					<li class="android"><a href="#android"> Android</a></li>
				</ul>
			</div>
		</div>
	</div>
</div> -->

<!--ios/android-->
<!--<div id="down-green"></div>-->
<!-- <div class="features">
<div class="">
            <h3 class="heading-title">Features</h3>
            <p class="excerpt">Check out what you have access to once you sign up. Access to hire local college students</p>
			</div>
			
   <div class="container">
      <div class="row-fluid">
         <div class="span12">
		 
            <ul class="nav nav-tabs" id="myTab">
               <li class="active"><a href="#home">Add a job</a></li>
               <li><a href="#profile"> Select your minyawn</a></li>
               <li><a href="#messages"> Secure payment</a></li>
               <li><a href="#settings">Mobile compatible</a></li>
            </ul>
			testing-
		<ul class="breadcrumbb">
			<li class="active"><a href="#home">Add a job</a></li>
            <li><a href="#profile"> Select your minyawn</a></li>
            <li><a href="#messages"> Secure payment</a></li>
            <li><a href="#settings">Mobile compatible</a></li>
		</ul>
			testing
            <div class="tab-content">
               <div class="tab-pane active" id="home">
                  <h3>Don't procrastinate, give those annoying tasks to the minyawns.</h3>
                  <p class="excerpt">It's really simple</p>
				  <div class="tooltip-left">
						<div class="data">
						<h4>Eye-catching job title</h4>
						<p class="data-content">Grab the attention of relevant minyawns with an awesome job title</p>
						</div>
						<img src="<?php echo get_template_directory_uri() ?>/images/tooltip.png"/>
					</div>
					
					<div class="tooltip-right-2">
						<div class="data">
						<h4>Pay what you want</h4>
						</div>
						
					</div>
					
					<div class="tooltip-right">
					<img src="<?php /*echo get_template_directory_uri()*/ ?>/images/tooltip-right.png"/>
						<div class="data">
						<h4>Pick 'em here
						<p class="data-content-3">Select the minyawns you feel are most suitable for your job.</p></h4>
						</div>
						
					</div>
                  <img src="<?php /*echo get_template_directory_uri()*/ ?>/images/laptop-screen_min.jpg" class="img-center"/>
               </div>
               <div class="tab-pane" id="profile"><br><br><br>
				 <div class="row-fluid">
						
						<div class="span7">
						<img src="<?php /*echo get_template_directory_uri()*/ ?>/images/selection.jpg"/>
						</div>
						<div class="span4">
						<br><br><br><br>
						<h3 class="a-left">Hire minyawns with skills required for the job.</h3><br>
						<p align="left" style="font-size: 15px;">Get assistance from a crowd of highly intelligent and motivated university students that want to prove themselves. With over 165 majors, our students literally cover anything you would expect or need. </p>
						</div>
						<div class="span1">
						
						</div>
						
					</div><br><br>
			
			   </div>
               <div class="tab-pane" id="messages">
					<br><br>
					<div class="row-fluid">
						<div class="span1">
						</div>
						<div class="span5">
						<img src="<?php /*echo get_template_directory_uri()*/ ?>/images/paypal1.jpg"/>
						</div>
						<div class="span4">
						<br><br><br><br>
						<img src="<?php /*echo get_template_directory_uri()*/ ?>/images/paypal2.jpg" class="img-center"/>
						<br><br>
						<p align="center" style="font-size: 15px;">You can pay with a credit card or check. We will bill you after the job is complete. We are partnered up with Paypal inc. and our transactions are fully secure.</p>
						</div>
						<div class="span2">
						</div>
					</div>
				<br><br>
				
			   </div>
               <div class="tab-pane" id="settings">
			   <img src="<?php /*echo get_template_directory_uri()*/ ?>/images/minyawns-mobile.jpg" class="img-center"/>
			  
			   </div>
            </div>
         </div>
      </div>
   </div>
</div> -->

<div class="customer">
   <div class="bg-title-gray">
      <h3 class="heading-title">Meet the <span class="highlight">500 Minyawns</span>   </h3>
      <p class="excerpt">The minyawns are thoroughly vetted University of Washington students.</p>
   </div>

 <div class="container">
   <div class="row-fluid minyawns-grid1 minyawns-gridhome">
   
      <ul class="thumbnails owl-carousel"  id="owl-example">
       <?php
        $homepage_users = get_users_for_homepage_footer();
        foreach($homepage_users as $homepage_user){

          $homepage_user_data = get_minyawn_profile($homepage_user,'');

           

          ?>
         <li class="span3 thumbspan show-minyawn"   item-id="<?php echo $homepage_user_data["user_id"];?>">
		
            <div class="thumbnail " id="thumbnail-10">
               <div class="m1" onClick="return true">
                  <div class="caption">
                     <div class="minyawns-img">
                        <?php echo $homepage_user_data["user_avatar"];?>
                     </div>
                     <h4> <?php echo $homepage_user_data["minion_name"];?></h4>
                     <div class="collage"><?php echo   $homepage_user_data["college"];?></div>
                      
                      <div class="social-link profile-social-link">
                      <?php if ($homepage_user_data["linkedin"] !="" ){?>
                      <?php if( strpos($homepage_user_data["linkedin"] ,"https://") == false  &&   strpos($homepage_user_data["linkedin"] ,"http://")  == false  ){
                          $linkedinUrl = "http://".$homepage_user_data["linkedin"];
                      }
                      else{
                          $linkedinUrl = $homepage_user_data["linkedin"];
                      }
                      ?>
 
 
                      <a href='<?php echo $linkedinUrl; ?>' target='_blank'><i class='icon-linkedin'></i></a>
                      <?php }  ?>
 
 
                      <?php if ($homepage_user_data["facebook_link"] !=""  ){?>

 
                      <?php if( strpos($homepage_user_data["facebook_link"] ,"https://")  == false  &&   strpos($homepage_user_data["facebook_link"] ,"http://")  == false  ){
                          $facebook_linkUrl = "http://".$homepage_user_data["facebook_link"];
                      }
                      else{
                          $facebook_linkUrl = $homepage_user_data["facebook_link"];
                      }
                      ?>
 
                      <a href='<?php echo $facebook_linkUrl;?>' target='_blank'  class="icon-facebook-a"><i class='icon-facebook'></i></a>
 
                      <?php  } ?></div>
 
					<div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> <?php echo $homepage_user_data["rating_positive"] ;?>
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down"></i> <?php echo $homepage_user_data["rating_negative"] ;?>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="m2">
                  <div class="caption">
                     <div class="minyawns-img">
                        <?php echo $homepage_user_data["user_avatar"];?>
                     </div>
                     <div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> <?php echo $homepage_user_data["rating_positive"] ; ?>
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down" ></i> <?php echo $homepage_user_data["rating_negative"] ;?>
                        </a>
                     </div>
                     <h4><?php echo $homepage_user_data["minion_name"];?></h4>
                     <div class="collage"> <?php echo $homepage_user_data["college"];?> </div>
 <div class="collage"> <?php echo $homepage_user_data["major"];?></div>
                     
                   <div class="social-link profile-social-link">
                      <?php if ($homepage_user_data["linkedin"] !="" ){?>
                      <?php if( strpos($homepage_user_data["linkedin"] ,"https://")  == false  &&   strpos($homepage_user_data["linkedin"] ,"http://")  == false  ){
                          $linkedinUrl = "http://".$homepage_user_data["linkedin"];
                      }
                      else{
                          $linkedinUrl = $homepage_user_data["linkedin"];
                      }
                      ?>
 
                      <a href='<?php echo $linkedinUrl; ?>' target='_blank'><i class='icon-linkedin'></i></a>
                      <?php } ?>
 
                      <?php if ($homepage_user_data["facebook_link"] !=""  ){?>

 
                      <?php if( strpos($homepage_user_data["facebook_link"] ,"https://")  == false  &&   strpos($homepage_user_data["facebook_link"] ,"http://")  == false  ){
                          $facebook_linkUrl = "http://".$homepage_user_data["facebook_link"];
                      }
                      else{
                          $facebook_linkUrl = $homepage_user_data["facebook_link"];
                      }
                      ?>
 
                      <a href='<?php echo $facebook_linkUrl;?>' target='_blank'  class="icon-facebook-a"><i class='icon-facebook'></i></a>
                      <?php }  ?></div>
                    
					 <div class="tags">
					 Tags:<br><?php $skills = explode(",",$homepage_user_data["skills"]) ;
             foreach($skills as $skill){
              ?><span class="label label-small"><?php echo $skill;?></span><?php
             }
             ?>
					</div>
                  </div>
               </div>
            </div>
		
         </li>
         <?php
         }?>
         <span class="load_ajaxsingle_job_minions" style="display: none;"></span>
      </ul>
   
   </div>
</div>
</div> 

<!-- client section -->
<div class="client-section">
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<h4 class="text-center client-section-title">Just some of our many Clients that have used Minyawns to find Reliable Workers</h4>
				<img src="<?php echo get_template_directory_uri(); ?>/images/ClientsLogoBanner.jpg" alt=""/> 
			</div>
		</div>
	</div>
</div><!--/client-section-->
<!-- /client section -->

<!-- mailchimp -->
<div id="mc_embed_signup">
	<form action="//minyawns.us3.list-manage.com/subscribe/post?u=0660fd96b7b6a95cb7582944a&amp;id=9a257065b4" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
	    <div id="mc_embed_signup_scroll">
		<label for="mce-EMAIL">Want to improve your professional skills? Sign up for tips on how to be business likable!</label>
		<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
	    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
	    <div style="position: absolute; left: -5000px;"><input type="text" name="b_0660fd96b7b6a95cb7582944a_9a257065b4" tabindex="-1" value=""></div>
	    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
	    </div>
	</form>
</div>
<!-- /mailchimp -->
<div id="down-gray"></div>
<!--	<div class="customer_bg"><br>
	 <div class="">
      <h3 class="heading-title">Have a look at some of the tasks posted</h3>
      <p class="excerpt">C'mon don't be shy, you know you want to.</p>
   </div>
   <div class="container">
		<div class="row-fluid">
		<div class="span6">
			<h3 class="recent-job-header"> Recent Jobs</h3>
			<ul class="unstyled recent-jobs">
				<li>
					<div class="row-fluid">
					<div class="span9">
							<a href="#" class="rj-title">Teaching and helping students with science classes</a>
							<div class="rj-location"><i class="icon-map-marker"></i>1410 NE Campus Pkwy Seattle</div>
						</div>
						<div class="span3">
							<b class="rj-price">$ 1000 </b>
							<span class="label label-info">Job Open</span>
							<p> 2 days ago</p>
						</div>
					</div>
				</li>
				<li>
				<div class="row-fluid">
					<div class="span9">
							<a href="#" class="rj-title">Teaching and helping students with science classes</a>
							<div class="rj-location"><i class="icon-map-marker"></i>1410 NE Campus Pkwy Seattle</div>
						</div>
						<div class="span3">
							<b class="rj-price">$ 1000 </b>
							<span class="label label-info">Job Open</span>
							<p> 2 days ago</p>
						</div>
					</div>
				
				</li>
				<li>
					<div class="row-fluid">
					
						<div class="span9">
							<a href="#" class="rj-title">Teaching and helping students with science classes</a>
							<div class="rj-location"><i class="icon-map-marker"></i>1410 NE Campus Pkwy Seattle</div>
						</div>
						<div class="span3">
							<b class="rj-price">$ 1000 </b>
							<span class="label label-info">Job Open</span>
							<p> 2 days ago</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="span6">
			<h3 class="recent-job-header"> Completed Jobs</h3>
			<ul class="unstyled recent-jobs">
				<li>
					<div class="row-fluid">
					
						<div class="span9">
							<a href="#" class="rj-title">Teaching and helping students with science classes</a>
							<div class="rj-location"><i class="icon-map-marker"></i>1410 NE Campus Pkwy Seattle</div>
						</div>
						<div class="span3">
							<b class="rj-price">$ 1000 </b>
							<span class="label label-success">Completed</span>
							<p> 2 days ago</p>
						</div>
					</div>
				</li>
				<li>
				<div class="row-fluid">
						<div class="span9">
							<a href="#" class="rj-title">Teaching and helping students with science classes</a>
							<div class="rj-location"><i class="icon-map-marker"></i>1410 NE Campus Pkwy Seattle</div>
						</div>
						<div class="span3">
							<b class="rj-price">$ 1000 </b>
							<span class="label label-success">Completed</span>
							<p> 2 days ago</p>
						</div>
					</div>
				
				</li>
				<li>
					<div class="row-fluid">
					<div class="span9">
							<a href="#" class="rj-title">Teaching and helping students with science classes</a>
							<div class="rj-location"><i class="icon-map-marker"></i>1410 NE Campus Pkwy Seattle</div>
						</div>
						<div class="span3">
							<b class="rj-price">$ 1000 </b>
							<span class="label label-success">Completed</span>
							<p> 2 days ago</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
		</div>
		<div class="browse-all"><a href="#"> Browse All Tasks</a></div>
		  <div class="sign-up-txt">
  What are you waiting for?<br>
<span>
  The power and resources of an elite billion-dollar institution is only a click away. </span>
<br>

<button href="#myModal"  data-toggle="modal" class="btn btn-huge btn-block btn-info" type="button">Get started now!</button>
  </div>
   </div><br>
  
  </div>
  <div id="down-green"></div>-->
  
</div>
  	<div id="video1" class="modal hide fade video-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
   		  <div class="modal-body">
   			<p><iframe id="powtoon-frame" width="530" height="351" src="" frameborder="0" allowfullscreen></iframe></p>
   		  </div>
   		  <div class="modal-footer">
   			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   		</div>
           
   	</div>
	  	 <div id="video2" class="modal hide fade video-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
   		  <div class="modal-body">
   			<p><iframe id="powtoon-frame1" width="530" height="351" src="" frameborder="0" allowfullscreen></iframe></p>
   		  </div>
                     
   		  <div class="modal-footer">
   			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   		</div>
   	</div>
<!-- End  Banner Layout -->
<!--
   <div class="video-home ">
   <div class="container">
   	<div class="row-fluid ">
   	<div class="span1">
   	 
   	</div>
   	<div class="span5">
   	 <a  href="#video1"  data-toggle="modal"><img src="<?php echo get_template_directory_uri() ?>/images/minyawns-students.png"/></a>
   	  <a  href="#video1"  data-toggle="modal"  style="color: #34495E;"> <h3>Minyawns For Students</h3></a>
   	</div>
 
   	<div class="span5">
   		 <a  href="#video2"  data-toggle="modal"> <img src="<?php echo get_template_directory_uri() ?>/images/minyawns-bussiness.png"/></a>
   	 <a  href="#video2"  data-toggle="modal" style="color: #34495E;"> <h3>Minyawns For Businesses</h3></a>
 
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
                    <h3 class="small-header">Request a Minyawn</h3>
                    <p class="small-desc">Pick a time, place, price and <br>describe your task.</p>
                </div>
                <div class="span2">
   	  <div class="workflow2">
                        <i class="icon-heart i-money"></i>
                    </div>
                    <h3 class="small-header">Pick your favorite</h3>
                    <p class="small-desc">Put your minyawn to work when they arrive.</p>
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
                    <p class="big-heading-desc">Minyawns - minions so good you can yawn- is an online service that is revolutionizing traditional staffing temp agencies through on-demand short time minyawns. 
   Businesses and Individual Professionals can post tasks and immediately receive assistance from a crowd of highly intelligent and motivated university students that want to prove themselves. With over 165 majors, our students literally cover anything you would expect or need. Additionally Minyawns provides a marketplace for students to strengthen resumes and gain experience, while business can help mold the future generation.</p>
                </div>
            </div>
            
   <div class="minyawns-satisfication">
   		<div class="container">
   			<div class="row-fluid">
   				<div class="span2"><img src="<?php echo get_template_directory_uri();?>/images/satisfication.png" class="satisfication"/></div>
   				<div class="span10"><h4>We are so sure that our Minyawns will be the best decision you have ever made. If you are not satisfied for any reason at all we will fully refund every cent you spent, no questions asked.</h4></div>
   			</div>
   		</div>
   
   </div>
   <div class="container">
   			<div class="row-fluid">
   				<ul class="thumbnails thumbnails-satisfication">
   				  <li class="span3">
   					<div class="thumbnail">
   					<img src="<?php echo get_template_directory_uri();?>/images/labour.png"/>
   					<br>
   					<p>Whether it's a simple yard work job, or need extra help moving. We got you covered!</p>
   					</div>
   				  </li>
   				   <li class="span3">
   				   <div class="thumbnail">
   				  <img src="<?php echo get_template_directory_uri();?>/images/techcomputer.png"/>
   					<br><p>We have elite programmers who can do anything from build your website, manage your twitter accounts, and even advanced SEO.</p>
   					</div>
   				  </li>
   				   <li class="span3">
   				   <div class="thumbnail">
   				   <img src="<?php echo get_template_directory_uri();?>/images/event.png"/>
   					<br><p>Planning a wedding, birthday party, or corporate event? Our clean shaven, presentable yet young and friendly minyawns make the perfect assistant no matter what the</p>
   					</div>
   				  </li>
   				   <li class="span3">
   				   <div class="thumbnail">
   				   <img src="<?php echo get_template_directory_uri();?>/images/officework.png"/>
   					<br><p>Home office or small business, our computer savvy and fast fingered University students can write reports, copy, file, and anything else you can imagine!</p>
   					</div>
   				  </li>
   				 
   				</ul>
   			</div>
   		</div>
   -->



<!-- learn more Get a Minyawn  -->
<div id="getminion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Why do you need minyawns?</h5>
  </div>
  <div class="modal-body">
    <p>Clearly university students have some sort of skill after tens of thousands of dollars, and multiple millennia’s of sitting in lecture halls. We believe that whatever job you need to get right now, don’t procrastinate, hire a minyawn.
</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   </div>
</div>

<!-- learn more Become a minyawn  -->
<div id="becomeminion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Perks of being a minyawn.</h5>
  </div>
  <div class="modal-body">
    <p>Get extra spending cash without having to commit to a part-time job. No need for countless hours of browsing, newspaper classifieds, google searches, and responding to human experiments; Simply sign up as a minyawn, browse jobs, select the one you like, show up, complete the job and get paid. Its that simple.
</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   </div>
</div>


 
<script>
jQuery(document).ready(function($) {
	$("#owl-example").owlCarousel({
   autoPlay: 3000, //Set AutoPlay to 3 seconds
      
	  
      items : 4,
	  itemsDesktop : [1199,4],
	   itemsDesktopSmall : [980,3]
      
  });
});

 jQuery(document).ready(function($) {
$("#home-video img, #home-video span.play-button").on("click", function() {
  $("#home-video").css("min-height","600px");
  var video = '<iframe id="video-player" width="100%" height="600px" src="' + $("#home-video img").attr('data-video') + '" frameborder="0" allowfullscreen wmode="opaque"></iframe>';
  $(video).insertAfter($("#home-video img"));
  $("#home-video span.play-button").hide();
  // $(".banner-owlcarousel").hide();
  $(".banner-title, .banner-desc, .b-text").hide();
  var closebtn = '<span class="close-button"></span>';
  $(closebtn).insertAfter($(this));
  
  $("#home-video span.close-button").on("click", function() {
    $("#home-video").css("min-height","100px");
    $("#video-player").remove();
    $(this).remove();
    $("#home-video span.play-button").show();
  });
});
});
</script>
<?php 
get_footer(); 
