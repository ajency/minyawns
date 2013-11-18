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
            Minyawns is an easy to use, on-demand, reliable way to find work or help fast.<br>
Backed by University of Washington students and designed for business professionals.
         </div>
         <hr>
         <div class="row-fluid">
            <div class="span4"></div>
            <div class="span2"><a  href="#myModal" <?php /*id="get-minon"*/ ?>  data-toggle="modal"   class="btn btn-huge btn-block btn-primary"  id="link_employerregister"  onClick="return true">Get a Minion <div class="tooltip1"><b>Why do you need minions?</b>Clearly university students have some sort of skill after tens of thousands of dollars, and multiple millennia’s of sitting in lecture halls. We believe that whatever job you need to get right now, don’t procrastinate, hire a minion.</div></a></div>
			
            <div class="span2"><a <?php /*id="become-minon"*/ ?>  href="#myModal"  data-toggle="modal"  class="btn btn-huge btn-block btn-info"  id="link_minyawnregister" onClick="return true"  >Become a Minion<div class="tooltip1"><b>Perks of being a minion.</b>Get extra spending cash without having to commit to a part-time job. No need for countless hours of browsing, newspaper classifieds, google searches, and responding to human experiments; Simply sign up as a minion, browse jobs, select the one you like, show up, complete the job and get paid. Its that simple.
</div></a></a>
			
			</div>
            <div class="span4"></div>
         </div>
		 <div class="row-fluid">
				<div class="span12 learn-more">
					<a  href="#pliip" class="jumper"> Learn More
					<br> 
					<i class="icon-chevron-down"></i>
					</a>
					
				</div>
		 </div>
      </div>
   </div>
   <div class="bg-overflow">
      <img class="bg-background" src="<?php echo get_template_directory_uri() ?>/images/banner1.jpg"/>
   </div>
</div>
<div id="pliip" class="how-does-it-work">
<div class="">
   <h3 class="heading-title">How does it work?</h3>
   <p class="excerpt">Go from being burdened with menial jobs to doing more awesome stuff.</p>
   </div>
     
   <div class="container steps-3">
      <div class="row-fluid">
         <div class="span4">
            <img src="<?php echo get_template_directory_uri() ?>/images/responsivescreen.jpg"/>
            <h4><span class="badge badge2">1</span> Post gigs</h4>
            <p>Describe what you need to get done, when you want help, and how much you are willing to pay.</p>
         </div>
         <div class="span4">
            <img src="<?php echo get_template_directory_uri() ?>/images/magnefine-glass.jpg"/>
            <h4> <span class="badge badge2">2</span> Pick your minion</h4>
            <p>We're talking about professional, reliable, competent, clean and sociable young college students looking for work.</p>
         </div>
         <div class="span4">
            <img src="<?php echo get_template_directory_uri() ?>/images/reachout.jpg"/>
            <h4> <span class="badge badge2">3</span> Get work done</h4>
            <p>Get productive and end your to-do list, 100% satisfaction guaranteed.</p>
         </div>
      </div>
      <br><br>
	  <h6 class="s-bold">To make things even more simple, watch our video walk-through.</h6>
	  <br>
	  <div class="row-fluid">
			<div class="span3"></div>
			<div class="span3"><button href="#video1"  data-toggle="modal" class="btn btn-large btn-primary pull-right" type="button"><i class="icon-youtube-play"></i> &nbsp;&nbsp;Minyawns for students</button></div>
			<div class="span3"><button href="#video2"  data-toggle="modal" class="btn btn-large btn-info" type="button"><i class="icon-youtube-play"></i> &nbsp;&nbsp;Minyawns for businesses</button></div>
			<div class="span3"></div>
			
	  </div><br><br>
   </div>
   
</div>
<div class="what-we-can-do">
     <div id="down"></div>
   <div class="">
      <h3 class="heading-title">What can we do?</h3>
      <p class="excerpt">The minions have superpowers, find out what they are.</p>
   </div>
 
   <div class="container">
      <div class="row-fluid">
         <div class="span8">
            <br>
           <div id="myCarousel" class="carousel slide">
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
                        <p>From simple tasks like office work, labor jobs, and event set-up to ones that need more specialty, our minions can do it all. You may just need an extra hand, our minions are capable of learning quickly on the job.
                        </p>
                     </div>
                  </div>
                  <div class="item">
                     <img src="<?php echo get_template_directory_uri() ?>/images/slider2.png" data-interval="500" data-slide-to="1" />
                     <div class="carousel-caption">
                        <h4>Make you feel in charge!</h4>
                        <p>Our Minions are equipped with the valuable skills from top universities. Its like having power and resources of an élite billion-dollar institution, awaiting your command.</p>
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
		</div>
		<div class="span4">
			<div class="back-satisfication">
				<div class="text">
					We are so sure that Minyawns We will be the best decision you have ever made. If you are not satisfied for any 
					reason <img src="<?php echo get_template_directory_uri() ?>/images/satisfication.png" align="right"/>at all we will fully refund every cent you spent, 
					no questions asked.<br><br>
					<h4>Sign up and we'll demolish your to-do list today.</h4>
				</div>
				<button href="#myModal"  data-toggle="modal" class="btn btn-large btn-info" type="button">Get started now!</button>
			</div>
		</div>
      </div>
   </div>

 
</div>
<div id="down-green"></div><br>
<div class="features">
<div class="">
            <h3 class="heading-title">Features</h3>
            <p class="excerpt">Check out what you have access to once you sign up.</p>
			</div>
			
   <div class="container">
      <div class="row-fluid">
         <div class="span12">
		 
            <ul class="nav nav-tabs" id="myTab">
               <li class="active"><a href="#home">Add a job</a></li>
               <li><a href="#profile"> Select your minion</a></li>
               <li><a href="#messages"> Secure payment</a></li>
               <li><a href="#settings">Mobile compatible</a></li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane active" id="home">
                  <h3>Don't procrastinate, give those annoying tasks to the minion.</h3>
                  <p class="excerpt">Its really simple</p>
				  <div class="tooltip-left">
						<div class="data">
						<h4>Your eye catching job title</h4>
						Grab the attention of relevant minions with an awesome job title
						</div>
						<img src="<?php echo get_template_directory_uri() ?>/images/tooltip.png"/>
					</div>
					
					<div class="tooltip-right">
					<img src="<?php echo get_template_directory_uri() ?>/images/tooltip-right.png"/>
						<div class="data">
						<h4>Pick 'em here</h4>
						Select the minions you feel are most suitable for your job.
						</div>
						
					</div>
                  <img src="<?php echo get_template_directory_uri() ?>/images/laptop-screen.jpg" class="img-center"/>
               </div>
               <div class="tab-pane" id="profile"><br><br><br>
				 <div class="row-fluid">
						
						<div class="span7">
						<img src="<?php echo get_template_directory_uri() ?>/images/selection.jpg"/>
						</div>
						<div class="span4">
						<br><br><br><br>
						<h3 class="a-left">Hire minions with skills required for the job.</h3><br>
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
						<img src="<?php echo get_template_directory_uri() ?>/images/paypal1.jpg"/>
						</div>
						<div class="span4">
						<br><br><br><br>
						<img src="<?php echo get_template_directory_uri() ?>/images/paypal2.jpg" class="img-center"/>
						<br><br>
						<p align="center" style="font-size: 15px;">You can pay with a credit card or check. We will bill you after the job is complete. We are partnered up with Paypal inc. and our transactions are fully secure.</p>
						</div>
						<div class="span2">
						</div>
					</div>
				<br><br>
				
			   </div>
               <div class="tab-pane" id="settings">
			   <img src="<?php echo get_template_directory_uri() ?>/images/minyawns-mobile.jpg" class="img-center"/>
			  
			   </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="customer">
   <div class="bg-title-gray">
      <h3 class="heading-title">Meet the <span class="highlight">500 Minions</span>  that signed up last week. </h3>
      <p class="excerpt">The minions are thoroughly vetted University of Washington students.</p>
   </div>
  <br><br><br>
 
   <div class="row-fluid minyawns-grid1">
      <ul class="thumbnails" style="left: 100px;">
         <li class="span3" id="10"  onclick="window.open('http://www.minyawns.com/profile/297/')">
		
            <div class="thumbnail" id="thumbnail-10">
               <div class="m1" onClick="return true">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/297/minyawn297_944587_487396288005796_927335437_n.jpg" >
                     </div>
                     <h4> Ketfa Inthathirath</h4>
                     <div class="collage">University of Washington</div>
                    
                     <div class="social-link">
                        www.linkedin.com/pub/ketfa-inthathirath/74/b9b/a9a
                     </div>
					<div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 0
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down"></i> 0
                        </a>
                     </div>
                  </div>
               </div>
               <div class="m2">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/297/minyawn297_944587_487396288005796_927335437_n.jpg">
                     </div>
                     <div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 0
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down" ></i> 0
                        </a>
                     </div>
                     <h4>Ketfa Inthathirath</h4>
                     <div class="collage"> University of Washington Civil and 
Enviormental Engineering </div>
 <div class="collage"> Biology</div>
                     
                     <div class="social-link">
                      www.linkedin.com/pub/ketfa-inthathirath/74/b9b/a9a
                     </div>
                    
					 <div class="tags">
					 Tags:<br>
						<span class="label label-small">Interpersonal Skills</span>
						<span class="label label-small">Leadership</span>
						<span class="label label-small">Public Speaking</span>
						
					</div>
                  </div>
               </div>
            </div>
		
         </li>
		    <li class="span3" id="10" onclick="window.open('http://www.minyawns.com/profile/214/')" >
            <div class="thumbnail" id="thumbnail-10">
               <div class="m1" onClick="return true">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/214/minyawn214_dabeach.jpg" >
                     </div>
                     <h4> Jonathan Hodge</h4>
                     <div class="collage"> University of Washington</div>
                    
                     <div class="social-link">
                       https://www.facebook.com/jonny.hodge.39
                     </div>
					<div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 1
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down"></i> 0
                        </a>
                     </div>
                  </div>
               </div>
               <div class="m2">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/214/minyawn214_dabeach.jpg">
                     </div>
                     <div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 1
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down" ></i> 0
                        </a>
                     </div>
                     <h4>Jonathan Hodge</h4>
                     <div class="collage">University of Washington </div>
					  <div class="collage"> Philosophy</div>
                     
                     <div class="social-link">
                       https://www.facebook.com/jonny.hodge.39
                     </div>
                     <div class="social-link">
                      jonny5.myles@gmail.com
                     </div>
					 <div class="tags">
					 Tags:<br>
						<span class="label label-small">Welding</span>
						<span class="label label-small">Worked a lot of Manual Labor</span>
						<span class="label label-small">Construction</span>
						
					</div>
                  </div>
               </div>
            </div>
         </li>
		        <li class="span3" id="10" onclick="window.open('http://www.minyawns.com/profile/298/')" >
            <div class="thumbnail" id="thumbnail-10">
               <div class="m1" onClick="return true">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/298/minyawn298_Resized.jpg" >
                     </div>
                     <h4>Theresa Wang</h4>
                     <div class="collage"> University of Washington</div>
                    
                     <div class="social-link">
                        http://www.linkedin.com/pub/theresa-wang/78/971/843
                     </div>
					<div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 0
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down"></i> 0
                        </a>
                     </div>
                  </div>
               </div>
               <div class="m2">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/298/minyawn298_Resized.jpg">
                     </div>
                     <div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 0
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down" ></i> 0
                        </a>
                     </div>
                     <h4>Theresa Wang</h4>
                     <div class="collage"> University of Washington </div>
                    <div class="collage">  Biochemistry, Public Health</div>
                     <div class="social-link">
                      http://www.linkedin.com/pub/theresa-wang/78/971/843
                     </div>
                   
					 <div class="tags">
					 Tags:<br>
						<span class="label label-small">Public Speaking</span>
						<span class="label label-small">Leadership</span>
						<span class="label label-small">Teamwork</span>
						<span class="label label-small">Event Planning</span>
					</div>
                  </div>
               </div>
            </div>
         </li>
		       <li class="span3" id="10"  onclick="window.open('http://www.minyawns.com/profile/345/')">
            <div class="thumbnail" id="thumbnail-10">
               <div class="m1" onClick="return true">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/345/minyawn345_Lirra.jpg" >
                     </div>
                     <h4> Lirra Zullo</h4>
                     <div class="collage"> University of Washington</div>
                    
                     <div class="social-link">
                        www.linkedin.com/pub/lirra-zullo/7b/b21/804
                     </div>
					<div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 0
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down"></i> 0
                        </a>
                     </div>
                  </div>
               </div>
               <div class="m2">
                  <div class="caption">
                     <div class="minyawns-img">
                        <img alt="" src="http://www.minyawns.com/wp-content/uploads/user-avatars/345/minyawn345_Lirra.jpg">
                     </div>
                     <div class="rating">
                        <a href="#fakelink" id="thumbs_up_10">
                        <i class="icon-thumbs-up"></i> 0
                        </a>
                        <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                        <i class="icon-thumbs-down" ></i> 0
                        </a>
                     </div>
                     <h4>Lirra Zullo</h4>
                     <div class="collage"> University of Washington </div>
                   <div class="collage">   Psychology</div>
                     <div class="social-link">
                      www.linkedin.com/pub/lirra-zullo/7b/b21/804
                     </div>
                    
					 <div class="tags">
					 Tags:<br>
						<span class="label label-small">Social-marketing</span>
						<span class="label label-small">Video</span>
						<span class="label label-small">Team</span>
						<span class="label label-small">Documentdrafting</span>
					</div>
                  </div>
               </div>
            </div>
         </li>
         <span class="load_ajaxsingle_job_minions" style="display: none;"></span>
      </ul>
   </div>

	<br><br><br>
	<div class="customer_bg">
	 <div class="">
      <h3 class="heading-title">97% of customers recommend Minyawns</h3>
      <p class="excerpt">Simply and effectively bridging the gap between businesses and minions.</p>
   </div>
   <div class="slider1">
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture1.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture2.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture3.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture4.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture5.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture6.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture7.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture8.png"></div>
      <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/Picture9.png"></div>
   </div><br><br><br><br>
  </div>
  <div id="down-green"></div>
  <div class="sign-up-txt">
  What are you waiting for?<br>
<span>
  The power and resources of an elite billion-dollar institution is only a click away. </span>
<br>
<br>
<button href="#myModal"  data-toggle="modal" class="btn btn-large btn-primary " type="button">Get started now!</button><br><br>
  </div>
</div>
  	<div id="video1" class="modal hide fade video-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   		  <div class="modal-body">
   			<p><iframe width="530" height="351" src="http://www.powtoon.com/embed/gbbkC7yIduS/" frameborder="0" allowfullscreen></iframe></p>
   		  </div>
   		  <div class="modal-footer">
   			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   		</div>
   	</div>
	  	 <div id="video2" class="modal hide fade video-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   		  <div class="modal-body">
   			<p><iframe width="530" height="351" src="http://www.powtoon.com/embed/gdPRX5igKP7/" frameborder="0" allowfullscreen></iframe></p>
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
<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri();?>/images/pattern-bg.png)">
   <div class="modal-header">
      <button type="button" id="signup_popup_close" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
      <span id="div_signupheader"><h4 id="myModalLabel">Sign Up to Minyawns </h4></span>
   </div>
   <div class="modal-body">
  
      <div id="div_signupmsg" ></div>
      <div class="row-fluid">
         <div class="span5">
            <form name="frm_signup"  id="frm_signup" action="" >
               <input type="hidden" name="signup_role" id="signup_role" value="" />
               <h6 class="align-center" style=" margin-bottom: 0px; ">
                  Create an Account
               </h6>
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
                 <div class="control-group ">
                  <input type="text" value="" name="signup_company"  id="signup_company"  placeholder="Company Name" class="span3">
               </div>
               <div class="clear"></div>
               <button href="#" class="btn btn-large btn-block btn-inverse" id="btn_signup"  type="button">Sign Up</button>
            </form>
         </div>
		  <div class="span1">
			<b class="or">or</b>
		  </div>
         <div class="span6">
            <h6 class="align-center" style=" margin-bottom: 0px; ">
               Sign Up Using Facebook
            </h6>
            <p class="align-center">Get using Minions, faster !</p>
            <br><br><br>
            <?php 	
               jfb_output_facebook_btn(); ?>
            <br><br>
            <p class="align-center"><span id="div_alreadyregister">Already registered at Minyawns?</span><a href="#" id="lnk_signin"><b> Sign in here</b></a></p>
         </div>
      </div>
	   <span id="div_signup_subheader"></span>
   </div>
</div>


<!-- learn more Get a Minion  -->
<div id="getminion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Why do you need minions?</h5>
  </div>
  <div class="modal-body">
    <p>Clearly university students have some sort of skill after tens of thousands of dollars, and multiple millennia’s of sitting in lecture halls. We believe that whatever job you need to get right now, don’t procrastinate, hire a minion.
</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   </div>
</div>

<!-- learn more Become a minion  -->
<div id="becomeminion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Perks of being a minion.</h5>
  </div>
  <div class="modal-body">
    <p>Get extra spending cash without having to commit to a part-time job. No need for countless hours of browsing, newspaper classifieds, google searches, and responding to human experiments; Simply sign up as a minion, browse jobs, select the one you like, show up, complete the job and get paid. Its that simple.
</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   </div>
</div>


 

<?php
get_footer();