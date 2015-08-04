<?php
/**
  Template Name: Profile Page
 */
  get_header();
  require 'templates/_jobs.php';
  ?>
  <script type="text/javascript">


  function showUserGallery(userid){
  //alert('profile image clicked for '+userid);
  jQuery.get(SITEURL+"/api/photos/user/"+userid, {}, function(collection)  { 

   console.log(collection);
 });
}






  jQuery(document).ready(function($) {




    if (is_logged_in.length === 0) {
        jQuery("#change-avatar-span").attr("href", "#")
        jQuery("#change-avatar-span").find("span").remove();
    }

    jQuery("#tab_identifier").val('1');
    
    $(".inline li").removeClass("selected");
    fetch_my_jobs(logged_in_user_id);
    $("#example_right").on('click', function() {

        $(".load_ajax_profile_comments").show();
        var Fetchusercomments = Backbone.Collection.extend({
            model: Usercomments,
            url: SITEURL + '/wp-content/themes/minyawns/libs/job.php/getcomments'
        });

        window.fetchc = new Fetchusercomments;
        window.fetchc.fetch({
            data: {
                minion_id: $("#example_right").attr("user-id")
                            //job_id: jQuery("#job_id").val()
                        },
                        success: function(collection, response) {

                            console.log(collection.models);
                            var html;
                            if (collection.length > 0) {
                                var template = _.template(jQuery("#comment-popover").html());
                                _.each(collection.models, function(model) {


                                    html = template({result: model.toJSON()});
                            //jQuery(".thumbnails").animate({left: '100px'}, "slow").prepend(html);
                        });

                                $(".load_ajax_profile_comments").hide();
                                $("#example_right").popover({placement: 'left', trigger: 'click', content: html}).popover('show');
                                ;


                            }
                        }
                    });

$(".close").live("click",function(){
    
    $("#example_right").popover('hide');
});

});

jQuery('#example').popover(
{
   placement : 'bottom',
   html : true,
   trigger : 'hover',
   content : '<div id="profile-data" class="verfied-content">We personally verify Minyawn profiles to help you be sure that they are who they claim to be and they are safe to do business with. Minyawns with out Verified status have yet to go through the personal verification process</div>',
}
);

});
</script>

<div id="myprofilepic" class="modal hide fade cropimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <?php if (is_user_logged_in() == TRUE)  ?>
        <h4 id="myModalLabel">Change Profile Pic</h4>

    </div>
    <input type="hidden" id="tab_identifier" />
    <div class="modal-body">
        <div style="margin:0 auto; width:500px">

            <div id="thumbs" style="padding:5px; width:500px"></div>
            <div style="width:500px" id="image_upload_body">

                <form id="cropimage" method="post" enctype="multipart/form-data">
                    <a type="button" class="btn btn-primary" id="done-cropping" style="display:none">Done? </a>
                    Upload your image <input type="file" name="files" id="photoimg" data-user="<?php echo get_user_id(); ?>" /><br><span class='load_ajax-crop-upload' style="display:none"></span>
                    <br>
                    <span id="div_cropmsg"> 
                        <?php /* Please drag to select/crop your picture. */ ?>
                        <p class="help-block meta">Upload an image for your profile.</p></br>
                    </span>
                </br>
                <input type="hidden" name="image_name" id="image_name" value="" />
                <img id="uploaded-image" ></img>
                <input type="hidden"  id="image_height">
                <input type="hidden"  id="image_width">
                <input type="hidden"  id="image_x_axis">
                <input type="hidden"  id="image_y_axis">
                <input type="hidden" value="<?php echo (get_user_role() == 'employer' ? '2:1' : '1:1') ?>" id="aspect_ratio"> 

            </form>

        </div>
    </div>
</div>

</div>
<div class="container main-content-profile">
    <div id="main-content" class="main-content  " >
        <div class="breadcrumb-text">

            <p id="bread-crumbs-id">

                <a href="<?php echo site_url() ?>/jobs/" class="view loaded">My Jobs</a>
                <a href="<?php echo site_url() ?>/profile/" class="view loaded">My Profile</a>
                
                <!--                <a href="#" class="view loaded edit-user-profile"><?php if(get_user_id()== get_current_user_id()) echo "My"; else if(strlen(user_profile_company_name())>0) echo mb_convert_case(user_profile_company_name(), MB_CASE_TITLE, "UTF-8"); else echo mb_convert_case(user_profile_first_name(), MB_CASE_TITLE, "UTF-8"); ?></a>-->
            </p>
        </div>  
    </div>  
    <div class="row-fluid profile-wrapper">
        <?php
            //if(0check_access()===true)
            //{
        
        if (is_user_logged_in()   ||  get_user_id() !="" ) {
         
            ?>
            <div  id="profile-view">
               <?php
               
               if (get_logged_in_role() == 'Minion') {

                    //Check if minion profile complete or not
                if(!minyawns_complete_profile()){
                 echo '<div class="alert alert-msg">   Attract more job offers with a complete profile.Simply <a href="'.site_url().'/edit-profile"  class="" >click here. </a> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
             }

         }
         ?>
         <?php
         
         if (get_logged_in_role() == 'Employer') {

                        //Check if employer profile complete or not
            if(!employer_complete_profile()){
                echo '<div class="alert alert-msg"> Complete your profile 
                and get more applications from eager minyawns. Simply <a href="'.site_url().'/edit-profile"  class="" >Click Here</a> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';

            }
            
        }
        ?>

        <h4 class=" span12 job-view content-section uppercase-title lh-md">
            <div class="row-fluid">
                <div class="span5">
                   <i class="icon-briefcase"></i> To Visit Jobs Section <a href="<?php echo site_url() ?>/jobs/#browse" class=""> Click Here</a> 
               </div>
               <div class="span7 normal-txt">
                  <?php
                  if (get_user_role() === "employer") {
                               // echo user_profile_company_name();
                              //  $display_name = user_profile_company_name();
                  } else {
                               // echo user_profile_first_name() . " " . user_profile_last_name();

                              //  $display_name = user_profile_first_name() . " " . user_profile_last_name();
                  } if (!is_numeric(check_direct_access())) {
                    ?>
                    <?php if (get_user_role() === 'minyawn'): ?>
                    <span class="pull-left">Updating your profile with your Profile picture, Skills and Short Bio helps<br> Employer to know you well </span> 
                <?php endif; ?> 
                <?php if (get_user_role() === 'employer'): ?>
                <span class="pull-left">Complete your profile and get more applications from eager minyawns. </span> 
            <?php endif; ?> 
            <a href="<?php echo site_url() ?>/edit-profile" id="edit-user-profile" class="edit btn btn-primary pull-right"><i class="icon-edit"></i> EDIT PROFILE</a><?php } ?>
        </div>
        <div class="clear"></div>
    </h4>
    
    <div class="row-fluid ">
        <div class="span12 min_profile content-section <?php if (get_user_role() === 'employer'): ?> employe-detail <?php endif; ?>	">

            <div class="span2 ">
               <div id="change-avt" class="<?php
               
               if (get_user_role() == 'employer') {
                echo 'employer-image';
            }
            ?>">

            <?php if(is_facebook_user() === 'false' && get_current_user_id() == get_user_id()){ ?>
            <a href="#myprofilepic"  id="change-avatar-span" class="change-avtar" data-toggle="modal">
              <?php } else { ?>
               <a class="fancybox change-avtar" rel="group" href="<?php echo get_mn_user_avatar() ?>">
              <?php } ?>
              
                <?php
                
                
                if(get_mn_user_avatar() !== false){
                    ?><img src="<?php echo get_mn_user_avatar() ?>"/> <?php 
                    
                }else{
                    echo get_avatar(get_user_id(), 168 );
                }
                ?>
            </a> <?php if(get_current_user_id() == get_user_id()){ ?>
            <a href="#myprofilepic"  id="change-avatar-span" class="change-avtar avtar-btn" data-toggle="modal"><i class="icon-camera"></i></a>
            <?php } ?>
        </div>
        <?php if (is_user_logged_in()) { ?>              
        
        
        <input id="change-avatar" type="file" name="files" style="display:none;">
        <?php }?>

        <!--Ratings --><br>
        <?php if (get_user_role() === 'minyawn'): ?>
        <div class="right-wideget-bar">
          
         
            <div  id="profile-view1">
              Ratings &nbsp;&nbsp;&nbsp;
              <div class="like_btn">
                <a href="#fakelink" >
                    <i class="icon-thumbs-up"></i>
                    <b class="like"><?php user_like_count(); ?></b>
                </a> 
                <a href="#fakelink" >
                    <i class="icon-thumbs-down"></i>
                    <b class="dislike"><?php user_dislike_count(); ?></b>
                </a> 
            </div>
            <!-- Mobile View Like Button -->

            <div class="mobile_like_btn">
                <a href="#fakelink" >
                    <i class="icon-thumbs-up"></i>
                    <b class="like"><?php user_like_count(); ?></b>
                </a> 
                <a href="#fakelink" class="red" >
                    <i class="icon-thumbs-down"></i>
                    <b class="dislike"><?php user_dislike_count(); ?></b>
                </a> 
            </div>
            
            <?php if(count(get_object_id(get_user_id())) > 0){ ?>
            <!--                            <span class="userrev">User reviews <a href='javascript:void(0)' id='example_right' class='commentsclick' rel='popover'  user-id="<?php echo user_id(); ?>"  data-html='true'></a><span class='load_ajax_profile_comments' style="display:none; float:right"></span></span> -->
            <!-- Mobile View Like Button -->
            <?php }?>
        </div>  
        
    </div>
<?php endif; ?> 
<!--Ratings -->



</div>
<div class="span10">
  <div class="row-fluid">
    <div class="span6">
      <h4 class="name"> <?php
 if (get_user_role() === "employer") {
    echo user_profile_company_name();
    $display_name = user_profile_company_name();
} else {
    echo user_profile_first_name() . " " . user_profile_last_name();

    $display_name = user_profile_first_name() . " " . user_profile_last_name();
} if (!is_numeric(check_direct_access())) {
    ?>  <?php } ?>

    <?php
    
    if(is_user_verified()=== 'Y'){ ?> 
    <span class="minyawnverified"><img src="<?php echo get_template_directory_uri(); ?>/images/verify.png"  style="margin-top: -7px;"/> Minyawn verified </span> 
    
    <i class="icon-question-sign verfied-help"  id="example"></i> 
    <?php }?>

    

</h4>
    </div>


<?php if (get_user_role() === 'minyawn'){ ?>
    <div class="span6 cust-span6">
      <div class="min-job-details">
        <div class="row-fluid">
          <div class="span4">
            <div class="jobs-completed">
              <div class="job-no"><?php echo get_user_completed_job(); ?></div>
              <div class="job-status">Completed</div>
              <p>Jobs</p>
            </div>
          </div>
          <div class="span4">
            <div class="time-warp">
              <div class="time-circle"><?php echo get_user_punctuality_percent(); ?></div>
              <p>On time</p>
            </div>

          </div>
          <div class="span4">
            <div class="missed-job">
              <div class="missed-job-no">
                <?php echo get_user_missed_job(); ?>
              </div>
              <p>Missed Job</p>
            </div>

          </div>
        </div>
      </div>
    </div>
<?php } ?>



  </div>
  
 

<div class="clearfix"></div> 
<?php if (get_user_role() === 'minyawn'): ?>
    <?php echo user_college(); ?>
<?php endif; ?> 

<br>
<div class="row-fluid">
    <div class="span6">		
       <div class="profiledata ">
         
         <?php if (get_user_role() === 'minyawn'): ?>
         <br>
         <ul class="college-data unstyled">
            
             <li class="major_data">
                 <span> Major in : </span> <b> <?php echo user_college_major(); ?></b>
             </li>

            <?php if(is_user_logged_in()){ ?> 
             <li class="major_data">
                 <span> Email :  </span> <b> <a href="mailto:<?php user_profile_email();?>" target="_top">
                 <?php user_profile_email(); ?>
             </a>
         </b>
     </li>
     <?php } ?>

     <?php if(current_user_can( 'manage_options' ) || get_current_user_id() == get_user_id()){ ?>
     <li class="major_data">
         <span> Telephone no : </span> <b> <?php echo get_user_telephone_no(); ?>
     </b>
 </li>
 <?php } ?>

</ul>
<?php
else :
    ?>	
<ul class="college-data unstyled">
   <li class="location">
     Location : <b>    <?php echo user_location(); ?></b>
 </li>
 <li class="website">
     Company Website : <b>  <a href="http://<?php user_company_website(); ?>" target="_blank"><?php echo user_company_website(); ?></a></b>
 </li>

 <?php if(is_user_logged_in()){ ?>
 <li class="website">
     Email : <b>  <a href="mailto:<?php user_profile_email();?>" target="_blank"><?php echo user_profile_email(); ?></a></b>
 </li>
 <?php } ?>

<?php if(current_user_can( 'manage_options' ) || get_current_user_id() == get_user_id()){ ?>
     <li class="major_data">
         <span> Telephone no : </span> <b> <?php echo get_user_telephone_no(); ?>
     </b>
 </li>
 <?php } ?>

</ul>


<?php
endif;
?>
<?php if (get_user_role() === 'minyawn'): ?>
    <div class="social-link profile-social-link"> 
        
        <?php  if(strlen(user_profile_id_linkedin()) >0 ){ ?>
        <a href='http://<?php echo user_profile_linkedin() ?>' target='_blank'><i class="icon-linkedin"></i></a> 
        <?php  }?>
        
        <?php  if(strlen(user_profile_id_facebook()) >0 ){ ?>
        <a href='http://<?php echo user_profile_facebook() ?>' target='_blank' class="icon-facebook-a"><i class="icon-facebook"></i></a> 
        <?php } ?>    
    </div>                           
<?php endif; ?> 

</div>
</div>
<div class="span6">
    
   <?php if (get_user_role() === 'minyawn'): ?>
   
   <div class="list-box">
    <h3 class="uppercase-title">Skills &nbsp; <a data-toggle="tooltip" title="Minyawn's Areas of Expertise" id="element4"><i class="icon-question-sign text-info"></i></a> </h3>
    <?php
    if ((get_user_skills() != " ")) {
        $skills = explode(',', get_user_skills());

        for ($skill = 0; $skill < sizeof($skills); $skill++)
            echo "<span class='label label-small'>$skills[$skill]</span>";
    }
    ?>
</div>

<?php endif; ?> 



</div>
</div>
<?php if (get_user_role() === 'employer'): ?>
    <br>
    <h3 class="uppercase-title">Short Description <a id="hide" class="anchor">(Show Information)</a> </h3>
    <br>
    <div class="short-bio text-muted" id="me">
        <?php echo user_profile_body(); ?> 
    </div>
    
<?php endif; ?> 

<?php if (get_user_role() === 'minyawn' && get_minyawns_short_bio() != ""): ?>
    <h3 class="uppercase-title">Short Description <a id="hide" class="anchor">(Show Information)</a> </h3>
    <br>
    <div class="short-bio text-muted" id="me">
     <?php echo get_minyawns_short_bio(); ?>
 </div>
<?php endif; ?> 
</div>


</div>
</div>
<div class="clear"></div><br>




<div class="row-fluid accordion">
   <div class="span9">
       
    <div class="row-fluid ">
        <div class="span12 content-section">
            
            <h3 class="uppercase-title">
                <?php if (get_user_role() == 'minyawn'): ?>
                <i class="icon-briefcase "></i> &nbsp; Testimonials &nbsp; <a data-toggle="tooltip" title="Hear what past employers had to say about this Minyawns work!"><i class="icon-question-sign text-info"></i></a>
            <?php endif; ?> 
            <?php if (get_user_role() == 'employer'): ?>
            <i class="icon-briefcase "></i> &nbsp; Job List &nbsp; <a data-toggle="tooltip" title="Job list" id="element3"><i class="icon-question-sign text-info"></i></a>
        <?php endif; ?> 
    </h3>
    <br>

     <?php if (get_user_role() == 'employer'){ ?>
    <ul class="unstyled job-view-list  test" id="accordion24">
      <dl class="accordion">
       
        <a href="#" class="btn load-btn" style="width:99%;"><i class="icon-undo"></i> Load more</a>
    </dl>
</ul> <?php } ?>




<?php if (get_user_role() == 'minyawn'){ ?>
<!-- New Testimonials -->
<ul class="unstyled job-view-list" id="testimonials24">


<?php
$testimonials = get_minyawns_testimonials(get_user_id());
foreach($testimonials as $testimonial){
?>



    <li class="_li job-closed" >


     <div class="row-fluid mobile-hide" >
        <div class="span9 ">
           <div class="row-fluid " data-toggle="collapse-next" data-parent="#accordion24" >
            <div class="span1" >
                <div class="job-date" >
                    <b id="mf181"><?php echo $testimonial['day']; ?></b>
                    <?php echo $testimonial['month']; ?>
                </div>
            </div>
            <div class="span11 border-right job-details" >
                <?php echo $testimonial['comment']; ?></p><span class="rating_span text-left"> - <a href="<?php echo $testimonial['employer']['url']; ?>"><?php echo $testimonial['employer']['name']; ?></a></span>
                <hr>
                <div class="row-fluid">
                    <div class="span6">
                       <b>Jobs Photo: </b><br>
                        <?php
                    $photos = $testimonial['photos'];
                    foreach($photos as $photo){ ?>
                    <a class="fancybox" rel="group" href="<?php echo $photo['large_url']; ?>"><img src="<?php echo $photo['url']; ?>" width="50px"/></a>
                    <?php } ?>
                      
                   </div>    
                   <div class="span6">
                    <b>Job Type: </b><br>

                    <?php
                    $categories = $testimonial['category'];
                    $cats = array();
                    foreach($categories as $category){
                      $cats[] = '<span class="category-link" style="cursor: pointer; cursor: hand;" onclick="filter_categories('.$category->term_id.','.$category->name.')">'.$category->name.'</span>';
                    }
                    echo implode(" ",$cats);
                     ?>

                    
                </div> 
            </div>    
            <p>



            </div>
        </div>
    </div>


    <div class="span3">

      <div class="st-moile-span1" id="mf196">

        <?php
        if($testimonial['rating'] == '1'){ ?>
        <div class="well-done" id="mf197"><i class="icon-thumbs-up" id="mf198"></i>You Have Been Rated <br id="mf199"><b id="mf200">Well Done</b><div class="clear" id="mf201"></div><div id="mf202">  
        <?php }else if($testimonial['rating'] == '-1'){ ?>
        <div class="terrible" id="mf197"><i class="icon-thumbs-down" id="mf198"></i>You Have Been Rated <br id="mf199"><b id="mf200">Terrible</b><div class="clear" id="mf201"></div><div id="mf202">  
        <?php }else{ ?>
        <div></div>
        <?php } ?>
        
        <!--notifications-->
        <?php if($testimonial['punctuality'] == 'L'){ ?>
        <div class="notification"><i class="icon-time" style="color:#E71C1C"></i> Arrived late</div>
        <?php }else if($testimonial['punctuality'] == 'M'){ ?>
        <div class="notification"><i class="icon-ban-circle" style="color:#E71C1C"></i> Missed Job</div>
        <?php }else{ ?>
        <div class="notification"><i class="icon-time"></i> Arrived on time</div>
        <?php } ?>

    </div>

 </div> 


</div> 
</div>


</div>
</li>

<?php } ?>  


</ul>

<!-- New Testimonials -->
<?php } ?>






</div> 
</div> 
</div>



<div class="span3">
  <!-- Video -->
  <?php if (get_user_role() === 'minyawn'){ ?>
  <div class="row-fluid width-fix">
    <div class="span12 content-section">
      <h3 class="uppercase-title"><i class="icon-video"></i> &nbsp; Video Profile &nbsp;<a data-toggle="tooltip" title="This is a quick 30 seconds Intro Video of Minyawn" id="element"><i class="icon-question-sign text-info"></i></a></h3>
      <br>
      <?php if (is_user_logged_in() && get_user_intro_video_id() == "") { ?>   
      <div class="normal-txt" id="novideotext">
        <ul >
          <li>We love close ups, but suggest you sit at arms length.</li>
          <li>You’ve got 30 seconds, so keep an eye on time.</li>
          <li>Look In camera to create personal connection</li>
        </ul>
        <br>
        <a class="btn btn-primary" data-target="#recordvideo" data-toggle="modal">UPLOAD VIDEO</a>
      </div>
      <?php } ?>

      <div class="normal-txt" id="tempuploadtext" style="display:none;">
        <ul >
          <li>We love close ups, but suggest you sit at arms length.</li>
          <li>You’ve got 30 seconds, so keep an eye on time.</li>
          <li>Look In camera to create personal connection</li>
        </ul>
        <br>
        <a class="btn btn-primary" data-target="#recordvideo" data-toggle="modal">UPLOAD VIDEO</a>
      </div> 

      <!--  When Video Is added -->
      <div> 
        <br>


        <div id="profileintrowrap">

        </div>
        <?php if( get_user_intro_video_id() != ""){ ?>

        <div id="profilevideowrap">
        <iframe width="100%" height="180" src="https://www.youtube.com/embed/<?php echo get_user_intro_video_id(); ?>" frameborder="0" allowfullscreen></iframe>
        <?php if (is_user_logged_in()){ ?>
        <br><div > <a data-target="#recordvideo" data-toggle="modal"><i class="icon-play-sign"></i>  Record Video </a> <span class="pull-right"><i class="icon-trash" style="cursor:pointer;" onClick="delteIntroVideo('<?php echo get_user_intro_video_id(); ?>');"></i></span></div>
        <?php } ?>
         </div>

        <?php } ?>

      </div>

    </div>

    <?php } ?>

  </div>
  <!-- <br> -->
<!-- Video -->

<div class="row-fluid ">
    <div class="span9 content-section width-fix-div">
      <h3 class="uppercase-title"><!-- <i class="icon-picture"></i> --> &nbsp; Gallery &nbsp;<a data-toggle="tooltip" title="A collection of Selfies and Job Photos by Minyawn. Click on an image to view them. " id="element1"><i class="icon-question-sign text-info"></i></a></h3>
      <br>
      <form>
        <?php $upload_nonce = wp_create_nonce("upload_photo_".get_current_user_id()); ?>
        <?php $delete_nonce = wp_create_nonce("delete_photo_".get_current_user_id()); ?>
        <?php
        if(is_super_admin( get_current_user_id() )){
            $user_admin = 'true';
        }else{
            $user_admin = 'false';
        }
        ?>
        <input type="hidden" id="upload_nonce" name="upload_nonce" value="<?php echo $upload_nonce; ?>" />
        <input type="hidden" id="delete_nonce" name="delete_nonce" value="<?php echo $delete_nonce; ?>" />
        <input type="hidden" name="userid" value="<?php echo get_user_id();?>" />
        <?php if (is_user_logged_in()) { ?>  
        <div class="normal-txt">
            <ul >
                <li>Take your camera, click and upload</li>
                <li>Selfie is trending, can we see one of yours</li>
                <li>Look In camera to create personal connection</li>
            </ul>
        </div>
        <?php } ?>
        <div class=" author-data" id="upload" style="display:none" user-id="<?php echo get_user_id();?>" user-admin="<?php echo $user_admin; ?>">

            
         
            <div id="drop">
              
              <a class="btn btn-primary">Upload Photo</a>
              <input type="file" name="photo" multiple />
          </div>

          <ul>
              <!-- The file uploads will be shown here -->
          </ul>
          
      </div>
  </form>

  <!-- <div class="row-fluid" id="photo-grid" style="display:none"> -->

  <div align="left" id="photos_title" class="photos-title" style="display:none"> <h7><?php if(get_current_user_id()==get_user_id()){ ?>My<?php } else{ echo $display_name."'s"; }?> Photos</h7></div>
  <div class="isotope">
      <div class="grid-sizer-prof"></div>
      
      
  </div>


</div>
</div>




             <!--   <div class="jobs_table">
                    <div id="browse-jobs-table" class=" browse-jobs-table">


                          <ul class="unstyled job-view-list" id="accordion24">

                        </ul>

                        <button class="btn load_more load_more_profile" id="load-more"> <div><span class='load_ajax' style="display:block"></span> <b>Load more</b></div></button>
                    </div>
                </div>-->
                <div class="clear"></div>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>
    <?php
}else{
    ?>
    <div class="alert alert-info " style="width:70%;margin:auto;border: 10px solid rgba(204, 204, 204, 0.57);margin-top:10%;margin-bottom:10%">
        <div class="row-fluid">
            <div class="span3"><br><img src="<?php echo get_template_directory_uri(); ?>/images/403error.jpg"/></div>
            <div class="span9"> <h4 >No Access</h4>
                <hr>
                Sorry, you aren't allowed to view this page. If you are logged in and believe you should have access to this page, send us an email at <a href="mailto:support@minyawns.com">support@minyawns.com</a> with your username and the link of the page you are trying to access and we'll get back to you as soon as possible. 
                <br>
                <a <?php /* commented on 19june2014 href="#mylogin" */ ?>  href="javascript:void(0)"   data-toggle="modal" id="btn__login_oaccess" class="btn btn-large  btn-success default-btn"  >Login</a>
                <a <?php /* commented on 19june2014 href="#mylogin" */ ?>  href="javascript:void(0)"   data-toggle="modal" id="link__minyawnregister" class="btn btn-large  btn-success default-btn auto-width-btn"  >SignUp as Minyawn</a>
                <a <?php /* commented on 19june2014 href="#mylogin" */ ?>  href="javascript:void(0)"   data-toggle="modal" id="link__employerregister" class="btn btn-large  btn-success default-btn auto-width-btn"  >SignUp as Business</a>
                
                <div class="clear"></div></div>
            </div>
        </div>
        <?php
    } 
    ?>
</div>
</div>
</div>









<!-- Intro Video Modal -->
<?php if( get_user_intro_video_id()!=""){ ?>
<div id="introvideo" class="modal hide fade video-pop in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
    <iframe id="videowrap" frameborder="0" allowfullscreen="1" title="YouTube video player" width="530" height="350" src="https://www.youtube.com/embed/<?php echo get_user_intro_video_id(); ?>?enablejsapi=1&origin=<?php echo $_SERVER['HTTP_HOST']; ?>"></iframe>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>

</div>
<?php } ?>
<!-- End Intro Video Modal -->





<!-- Modal for record video with webcam -->
<div id="recordvideo" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:9999">
    <div  >
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
   
    </div>
    <input type="hidden" id="tab_identifier" value="1">
    <div class="modal-body">
        <div style="margin:0 auto; width:489px">
            <div id="widget"></div>

            <div id="processvideo" style="display:none">
                <div id="preloadprocess"></div>
                <div class="videoprocess-text">Processing Video...</div>
            </div>

            <div id="videoadderror" style="display:none"></div>

        </div>
    </div>

</div>
<!-- yutube webcam upload modal End -->













<!-- Youtube video recording with webcam and upload script -->
<script>
      // 2. Asynchronously load the Upload Widget and Player API code.
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. Define global variables for the widget and the player.
      // The function loads the widget after the JavaScript code has
      // downloaded and defines event handlers for callback notifications
      // related to the widget.
      var widget;
      var player;
      function onYouTubeIframeAPIReady() {
        widget = new YT.UploadWidget('widget', {
          width: 500,
          events: {
            'onUploadSuccess': onUploadSuccess,
            'onProcessingComplete': onProcessingComplete
          }
        });
      }

      // 4. This function is called when a video has been successfully uploaded.
      function onUploadSuccess(event) {
        //alert('Video ID ' + event.data.videoId + ' was uploaded and is currently being processed.');
        document.getElementById('widget').style.display = 'none';
        document.getElementById('processvideo').style.display = 'block';
      }

      // 5. This function is called when a video has been successfully processed.
      function onProcessingComplete(event) {
      
      //Call function to do the actual process
      addUserVideo(event.data.videoId);
       }






      function addUserVideo(videoid)
      {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
          xmlhttp=new XMLHttpRequest();
        }
        else
        {
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {

            if(xmlhttp.responseText == 'ok'){

              document.getElementById('recordvideo').style.display = 'none';
              document.getElementsByClassName('modal-backdrop')[0].style.display = 'none';

        //Hide upload video message
        if (document.getElementById("novideotext")) {
        document.getElementById('novideotext').style.display = 'none';
        }

        //Hide the existing video
        if (document.getElementById("profilevideowrap")) {
          document.getElementById("profilevideowrap").innerHTML = "";
        }
        

        //Scroll to the video div
        document.getElementById('profileintrowrap').scrollIntoView();

        //Render video
        player = new YT.Player('profileintrowrap', {
          height: 150,
          width: 240,
          videoId: videoid,
          events: {}
        });


        /*var vidDiv = document.getElementById('introprofilevidwrap');
        var delBtn = document.createElement('div');
        delBtn.id = 'deletevideobtn';     
        delBtn.innerHTML = 'X';
        delBtn.setAttribute("onclick","delteIntroVideo('"+videoid+"');");
        vidDiv.appendChild(delBtn);*/
        

      }else{

        
        //Hide video process message
        document.getElementById('processvideo').style.display = 'none';

        //Display error message div
        document.getElementById('videoadderror').style.display = 'block';

        //Add error message to div
        document.getElementById("videoadderror").innerHTML=xmlhttp.responseText;
          
            }
          }
        }
        xmlhttp.open("GET","<?php echo get_template_directory_uri(); ?>/youtube-data.php?action=add&videoid="+videoid+"&userid=<?php echo get_current_user_id(); ?>&nonce=<?php echo wp_create_nonce('addvideotousermeta'); ?>",true);
        xmlhttp.send();
      }



      function delteIntroVideo(videoid)
      {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
          xmlhttp=new XMLHttpRequest();
        }
        else
        {
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {

            if(xmlhttp.responseText == 'ok'){

              document.getElementById("profilevideowrap").innerHTML = "";

               //Display upload video text
               document.getElementById('tempuploadtext').style.display = 'block';

      }else{

        //Alert with error message 
        alert(xmlhttp.responseText);
          
            }
          }
        }
        xmlhttp.open("GET","<?php echo get_template_directory_uri(); ?>/youtube-data.php?action=delete&videoid="+videoid+"&userid=<?php echo get_current_user_id(); ?>&nonce=<?php echo wp_create_nonce('deletevideousermeta'); ?>",true);
        xmlhttp.send();
      }



    </script>










<?php
get_footer();