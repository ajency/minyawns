<?php
/*
Template Name: Student
*/
get_header('student');
?>


<!-- main-content -->
<div id="innermainimage-student" class="student-innermainimage">
	<div id="home-video">
	  <span class="play-button student-play-button"></span>
	</div>
   <div class="row-fluid banner-content">
		<div class="row-fluid">
			<div class="span12">
				<div class="banner-title">Access 1-day jobs for college students</div>
				<div class="text-center b-text">
				<a href="#myModal" data-toggle="modal" class="btn btn-huge btn-green" data-toggle="modal"  id="link_minyawnregister" onclick="return true">Sign Up Free</a>
          		</div>
			</div>	
		</div>
    </div>
</div>

<!-- slider -->
<div class="owl-cover student">
  <div class="container banner-owlcarousel">
  	<div class="row-fluid">
  		<div class="span12">
  			<h4 class="text-center">OUR RECENT ACTIVITY: RECOGNIZE ANYONE?</h4>
  			<?php echo do_shortcode('[owl-carousel category="student" items="4" autoPlay="true"]'); ?>
  		</div>
  	</div>
  </div>
</div>
<!-- slider -->

<!-- how does it work -->
<div class="how-does-it-work-student">
<div class="">
   <h3 class="heading-title">How does it work?</h3>
   <p class="excerpt">Create your Profile. Click to Apply. Go work and get paid within 24 hours!</p>
   </div>
     
   <div class="container steps-3">
      	<div class="row-fluid">
          <div class="span4">
            <img src="<?php echo get_template_directory_uri(); ?>/images/HDIW1.jpg" alt="" class="img-80">
              <h4><span class="badge badge2">1</span> Create a Profile</h4>
              <p>No, we don’t need your resume. Simply fill out a few form items and some photos and you’re good to go</p>
          </div>
          <div class="span4">
             <img src="<?php echo get_template_directory_uri(); ?>/images/HDIW2.jpg" alt="" class="img-80">
              <h4> <span class="badge badge2">2</span> Hit the Apply Button</h4>
              <p>No sending resumes, no emailing hiring managers. Just hit one button for the gig you are interested in. That’s it!</p>
          </div>
          <div class="span4">
              <img src="<?php echo get_template_directory_uri(); ?>/images/HDIW3.jpg" alt="" class="img-80">
              <h4> <span class="badge badge2">3</span> Get Notified and Make Money!</h4>
              <p>Receive an email or text when you’ve been selected. Get paid within 24 hours from us online!</p>
          </div>
      </div>
   </div>

</div><hr/>
<!-- /how does it work -->

<!--ios/android-->
<div class="ios-android">
  <div>
    <h3 class="heading-title">mobile<span class="highlight"> app</span></h3>
    <p class="excerpt">Just a click away from your new job.</p>
  </div>
  <div class="container">
    <div class="row-fluid">
      <div class="span12">
        <div class="tab-content">
          <div class="tab-pane active" id="ios">
            <div class="row-fluid">
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
</div>
<!--ios/android-->

<!-- why minions -->
<div class="why-minyawns">
  <div class="why-minyawns-title">
    <h3>WHY MINYAWNS?</h3>
  </div>
  <div class="container">
    <div class="row-fluid">
      <div class="span4">
        <h4>On your Schedule</h4>
        <p>Free for a Friday? Work then, want to work Sunday? Works for us. Choose the times that work for you. </p>
      </div>
      <div class="span4">
        <h4>Simple as Clicking “Apply”</h4>
        <p>We don’t need a full on resume, heck we don’t even need you to email us. Just hit apply on your phone or on your computer and you’re automatically considered for the gig. </p>
      </div>
      <div class="span4">
        <h4>Collect Ratings and Recommendations</h4>
        <p>Build up your profile as a Freelancer and get rated and recommendations from local businesses. It’s always a great networking opportunity. </p>
      </div>
    </div>
  </div>
</div>
<!-- /why minions -->

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
<!-- /main-content -->

<script>
  jQuery(document).ready(function($) {
  $("#owl-example").owlCarousel({
   autoPlay: 3000, //Set AutoPlay to 3 seconds
      
    
      items : 4,
    itemsDesktop : [1199,4],
     itemsDesktopSmall : [980,3]
      
  });
});
</script>
<?php
get_footer();
?>

