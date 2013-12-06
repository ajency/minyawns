
<?php
/**
  Template Name: Profile Page
 */
get_header();
require 'templates/_jobs.php';
?>
<script>
    jQuery(document).ready(function($) {

        if (is_logged_in.length === 0) {
            jQuery("#change-avatar-span").attr("href", "#")
            jQuery("#change-avatar-span").find("span").remove();
        }

        jQuery("#tab_identifier").val('1');
        
         $("#example_right").live('click', function() {

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
					content : '<div id="profile-data" class="verfied-content">We personally verify Minion profiles to help you be sure that they are who they claim to be and they are safe to do business with. Minions with out Verified status have yet to go through the personal verification process</div>',
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
                    Upload your image <input type="file" name="files" id="photoimg" /><br><span class='load_ajax-crop-upload' style="display:none"></span>
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
<div class="container">
    <div id="main-content" class="main-content bg-white" >
        <div class="breadcrumb-text">

            <p id="bread-crumbs-id">

                <a href="<?php echo site_url() ?>/jobs/" class="view loaded">My Jobs</a>
                <a href="#" class="view loaded edit-user-profile">Profile</a>
               
                <a href="#" class="view loaded edit-user-profile"><?php if(get_user_id()== get_current_user_id()) echo "My"; else if(strlen(user_profile_company_name())>0) echo mb_convert_case(user_profile_company_name(), MB_CASE_TITLE, "UTF-8"); else echo mb_convert_case(user_profile_first_name(), MB_CASE_TITLE, "UTF-8"); ?></a>
            </p>
        </div>
		  
        <div class="row-fluid profile-wrapper">
            <?php
            //if(check_access()===true)
            //{
            ?>
            <div class="span12" id="profile-view">
                	<?php
                                                                   
                 if (get_user_role() == 'minyawn') {
				   echo '<div class="alert alert-msg">   Attract more job offers with a complete profile.Simply <a href="#" id="edit-user-profile" class="edit-user-profile" >click here. </a> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				 }
                    ?>
				<?php
                                                                   
                    if (get_user_role() == 'employer') {
					
			 echo '<div class="alert alert-msg"> Complete your profile 
and get more applications from eager minions. Simply <a href="#" id="edit-user-profile" class="edit-user-profile" >Click Here</a> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';

 }
                    ?><h4 class="job-view"><i class="icon-briefcase"></i> To Visit Jobs Section <a href="<?php echo site_url() ?>/jobs" class=""> Click Here</a></h4>
                <div class="row-fluid min_profile  <?php if (get_user_role() === 'employer'): ?> employe-detail <?php endif; ?>	">

                    <div class="span2 ">
					<div id="change-avt" class="<?php
                                                                   
                    if (get_user_role() == 'employer') {
                        echo 'employer-image';
                    }
                    ?>">
                        <a href="#myprofilepic"  id="change-avatar-span" class="change-avtar" data-toggle="modal">
						
                            <?php
                            
                            
                            if (get_mn_user_avatar() !== false)
                                echo get_mn_user_avatar();
                            else
                                echo get_avatar(get_user_id(), 168)
                                ?>
</a> <?php if(is_facebook_user() === 'false'){ ?>
						  <a href="#myprofilepic"  id="change-avatar-span" class="change-avtar avtar-btn" data-toggle="modal">Change Profile Pic</a>
                        <?php }?>
						</div>
                            <?php if (is_user_logged_in()) { ?>              
                        
                       
                                                  <input id="change-avatar" type="file" name="files" style="display:none;">
                            <?php }?>
                    </div>
                    <div class="span10">
					  <?php if (get_user_role() === 'minyawn'): ?>
					<div class="social-link"><i class="icon-twitter"></i>   <a href='http://<?php echo user_profile_linkedin() ?>' target='_blank'><i class="icon-linkedin"></i></a></div>
    <?php endif; ?>		                      
					  <h4 class="name"> <?php
                            if (get_user_role() === "employer") {
                                echo user_profile_company_name();
                            } else {
                                user_profile_first_name() . " " . user_profile_last_name();
                            } if (!is_numeric(check_direct_access())) {
                                ?>  <a href="#"id="edit-user-profile" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a><?php } ?>

								

							<?php
                                                      
                                                         if(is_user_verified()=== 'Y'){ ?>	
                                                        <span class="label Minyawnverified"><i class="icon-ok-sign"></i> Minyawn verified </span>
                                                        <i class="icon-question-sign verfied-help"  id="example"></i> 
                                                         <?php }?>

								</h4> 
								 <?php if (get_user_role() === 'employer'): ?>
								<div class="employer-body">
								
								 <?php user_profile_body(); ?>
								</div>
								<?php endif; ?>	
								
								
                     <div class="profiledata ">
					  <?php if (get_user_role() === 'minyawn'): ?>
                                   <ul class="college-data inline">
									<li>
								   College : <b>  <?php user_college(); ?></b>
								   </li>
								   <li>
								   Major : <b>  <?php user_college_major(); ?></b>
								   </li>
								   </ul>
                     <?php
                            else :
                                ?>	
								<ul class="college-data inline">
									<li>
								   Location : <b>    <?php user_location(); ?></b>
								   </li>
								   <li>
								   Company Website : <b>  <a href="<?php user_company_website(); ?>" target="_blank"><?php user_company_website(); ?></a></b>
								   </li>
								   </ul>
								
								
								 <?php
                            endif;
                            ?>
					 
					 </div>

                    </div>
                  
                 		
                </div>
<div class="clear"></div><br>
 <?php if (get_user_role() === 'minyawn'): ?>
				<div class="row-fluid">
					<div class="span2">
						<div class="right-wideget-bar">
							<h3>Ratings</h3>
							<?php if (get_user_role() === 'minyawn'): ?>
                        <div  id="profile-view1">
                         
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
                            <span class="userrev">User reviews <a href='javascript:void(0)' id='example_right' class='commentsclick' rel='popover'  user-id="<?php echo user_id(); ?>"  data-html='true'></a><span class='load_ajax_profile_comments' style="display:none; float:right"></span></span> 
                            <!-- Mobile View Like Button -->
                            <?php }?>
                        </div>	
                    <?php endif; ?>	
						</div>
					
					</div>
					<div class="span10">
						<div class="list-box">
							<h3>Skills</h3>
							 <?php
                                    if ((get_user_skills() != " ")) {
                                        $skills = explode(',', get_user_skills());

                                        for ($skill = 0; $skill < sizeof($skills); $skill++)
                                            echo "<span class='label label-small'>$skills[$skill]</span>";
                                    }
                                    ?>
						</div>
					</div>
				</div>
				    <?php endif; ?>		
				
				<hr>
				<h4><i class="icon-briefcase"></i> &nbsp; Job List</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed </p>
				<div class="row-fluid">
					<div class="span9">
						<ul class="unstyled job-view-list" id="accordion2">
                           <li class="_li job-open">
						    <div class="jobs-rating">
								<div class="well-done">
								<i class="icon-thumbs-up"></i>You Have Been Rated <br><b>Well Done</b>
									<div class="clear"></div><br>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, se magna aliqua. </p>
								<span> - Jogn Schwell</span>
								</div>
							  </div>
                              <div class="row-fluid">
                                 <div class="span9 ">
                                    <div class="row-fluid bdr-gray">
                                      <div class="span12 job-details">
                                          <div class="job-title">
                                             <h5><a href="#" target="_blank"> Wash My Car  </a></h5>
                                          </div>
                                          <div class="job-meta">
                                             <ul class="inline">
                                                <li><i class="icon-calendar"></i> 28 November, 2013 </li>
                                                <li><i class="icon-time"></i> 4:08 &nbsp;pm to 4:08  &nbsp;pm</li>
                                                <li class="no-bdr"><i class="icon-map-marker"></i> 1410 NE Campus Pkwy Seattle</li>
                                             </ul>
                                          </div>
                                          <p> I am a recent graduate of Dalhousie University with a combined Honours in Chemistry and Biology. Teaching and helping students with science classes [....]</p>
                                       </div>
                                    </div>
                                    <div class="additional-info">
                                       <div class="row-fluid">
                                          <div class="span6"><span> Category :</span><br><a href="#"> Workshop</a>, <a href="#"> Cleaning</a>,  <a href="#"> Washing Car</a>,  <a href="#"> College Students</a></div>
                                          <div class="span6"> <span> Tags :</span> <br><span class="label">cleaning</span> <span class="label">Washing</span><span class="label">cleaning</span> <span class="label">Washing</span><span class="label">Mathematics</span></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="span3 status">
                                    <div class="st-fluid">
                                       <div class="st-moile-span1">
                                          <div class="st-wages"> wages <b>$3000</b></div>
                                       </div>
                                       <div class="st-moile-span2">
                                          <div class="st-status open">Applications Open.</div>
                                          <div class="st-meta">12 Days to Go</div>
                                       </div>
                                       <div class="clear"></div>
                                    </div>
                                    <div class="st-footer">
                                       <div class="st-applicant">No Applications yet. </div>
                                       <a href="#fakelink" class="btn btn-primary">
                                       <i class="icon-location-arrow"></i>
                                       Send Invites
                                       </a>
                                    </div>
                                 </div>
                              </div>
							 
                           </li>
                           <li class="_li job-open">
						    <div class="jobs-rating">
								<div class="terrible">
								<i class="icon-thumbs-down"></i>You Have Been Rated <br><b>Terrible</b>
									<div class="clear"></div><br>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, se magna aliqua. </p>
								<span> - Jogn Schwell</span>
								</div>
							  </div>
                              <div class="row-fluid">
                                 <div class="span9">
                                    <div class="row-fluid bdr-gray">
                                      <div class="span12 job-details">
                                          <div class="job-title">
                                             <h5><a href="#" target="_blank">The template has been conceived with a proper balance
                                                UI &amp; UX in order to offer an excellent  </a>
                                             </h5>
                                          </div>
                                          <div class="job-meta">
                                             <ul class="inline">
                                                <li><i class="icon-calendar"></i> 28 November, 2013 </li>
                                                <li><i class="icon-time"></i> 4:08 &nbsp;pm to 4:08  &nbsp;pm</li>
                                                <li class="no-bdr"><i class="icon-map-marker"></i> 1410 NE Campus Pkwy Seattle</li>
                                             </ul>
                                          </div>
                                          <p> I am a recent graduate of Dalhousie University with a combined Honours in Chemistry and Biology. Teaching and helping students with science classes  [....]</p>
                                       </div>
                                    </div>
                                    <div class="additional-info">
                                       <div class="row-fluid">
                                          <div class="span6"><span> Category :</span><br><a href="#"> Workshop</a>, <a href="#"> Cleaning</a>,  <a href="#"> Washing Car</a>,  <a href="#"> College Students</a></div>
                                          <div class="span6"> <span> Tags :</span> <br><span class="label">cleaning</span> <span class="label">Washing</span><span class="label">cleaning</span> <span class="label">Washing</span><span class="label">Mathematics</span></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="span3 status">
                                    <div class="st-fluid">
                                       <div class="st-moile-span1">
                                          <div class="st-wages"> wages <b>$3000</b></div>
                                       </div>
                                       <div class="st-moile-span2">
                                          <div class="st-status open">Applications Open.</div>
                                          <div class="st-meta">12 Days to Go</div>
                                       </div>
                                       <div class="clear"></div>
                                    </div>
                                    <div class="st-footer">
                                       <div class="st-minyawn">
                                          2
                                          <div class="st-selected-box">
                                             <div class="arrow-up1"></div>
                                             <ul class="unstyled">
                                                <li>
                                                   <img src="images/iconsult1.png"><a href="#" class="minyawn-name">Lisa Farmaro</a>
                                                   <a id="vote-up" href="#fakelink" employer-vote="1" job-id="616"><i class="icon-thumbs-up"></i>2</a>
                                                   <a id="vote-down" href="#fakelink" class="icon-thumbs" employer-vote="-1" job-id="616"><i class="icon-thumbs-down"></i>1</a>
                                                   <div class="clear"></div>
                                                </li>
                                                <li>
                                                   <img src="images/iconsult2.png"><a href="#" class="minyawn-name">Maria Donwell </a>
                                                   <a id="vote-up" href="#fakelink" employer-vote="1" job-id="616"><i class="icon-thumbs-up"></i>2</a>
                                                   <a id="vote-down" href="#fakelink" class="icon-thumbs" employer-vote="-1" job-id="616"><i class="icon-thumbs-down"></i>1</a>
                                                   <div class="clear"></div>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="st-applicant">Minions have applied.  </div>
                                       <a href="#fakelink" class="btn btn-primary">
                                       <i class="icon-check"></i>
                                       Select Minions
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </li>
                           <li class="_li job-open">
						       <div class="jobs-rating">
								<div class="not-rated">
								<div class="msg">You have been <br>not yet rated</div>
									<i class="icon-thumbs-up"></i><i class="icon-thumbs-down"></i>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, se magna aliqua.  </p>
							
								</div>
							  </div>
                              <div class="row-fluid">
                                 <div class="span9">
                                    <div class="row-fluid bdr-gray">
                                      <div class="span12 job-details">
                                          <div class="job-title">
                                             <h5><a href="#" target="_blank">The template has been conceived with a proper balance
                                                UI &amp; UX in order to offer an excellent  </a>
                                             </h5>
                                          </div>
                                          <div class="job-meta">
                                             <ul class="inline">
                                                <li><i class="icon-calendar"></i> 28 November, 2013 </li>
                                                <li><i class="icon-time"></i> 4:08 &nbsp;pm to 4:08  &nbsp;pm</li>
                                                <li class="no-bdr"><i class="icon-map-marker"></i> 1410 NE Campus Pkwy Seattle</li>
                                             </ul>
                                          </div>
                                          <p> I am a recent graduate of Dalhousie University with a combined Honours in Chemistry and Biology. Teaching and helping students with science classes  [....]</p>
                                       </div>
                                    </div>
                                    <div class="additional-info">
                                       <div class="row-fluid">
                                          <div class="span6"><span> Category :</span><br><a href="#"> Workshop</a>, <a href="#"> Cleaning</a>,  <a href="#"> Washing Car</a>,  <a href="#"> College Students</a></div>
                                          <div class="span6"> <span> Tags :</span> <br><span class="label">cleaning</span> <span class="label">Washing</span><span class="label">cleaning</span> <span class="label">Washing</span><span class="label">Mathematics</span></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="span3 status">
                                    <div class="st-fluid">
                                       <div class="st-moile-span1">
                                          <div class="st-wages"> wages <b>$3000</b></div>
                                       </div>
                                       <div class="st-moile-span2">
                                          <div class="st-status closed">Applications Closed</div>
                                          <div class="st-meta">Maximum number of minions have applied.</div>
                                       </div>
                                       <div class="clear"></div>
                                    </div>
                                    <div class="st-footer">
                                       <div class="st-minyawn">
                                          3
                                          <div class="st-selected-box">
                                             <div class="arrow-up1"></div>
                                             <ul class="unstyled">
                                                <li>
                                                   <img src="images/iconsult1.png"><a href="#" class="minyawn-name">Lisa Farmaro</a>
                                                   <a id="vote-up" href="#fakelink" employer-vote="1" job-id="616"><i class="icon-thumbs-up"></i>2</a>
                                                   <a id="vote-down" href="#fakelink" class="icon-thumbs" employer-vote="-1" job-id="616"><i class="icon-thumbs-down"></i>1</a>
                                                   <div class="clear"></div>
                                                </li>
                                                <li>
                                                   <img src="images/iconsult2.png"><a href="#" class="minyawn-name">Maria Donwell </a>
                                                   <a id="vote-up" href="#fakelink" employer-vote="1" job-id="616"><i class="icon-thumbs-up"></i>2</a>
                                                   <a id="vote-down" href="#fakelink" class="icon-thumbs" employer-vote="-1" job-id="616"><i class="icon-thumbs-down"></i>1</a>
                                                   <div class="clear"></div>
                                                </li>
                                                <li>
                                                   <img src="images/iconsult3.png"><a href="#" class="minyawn-name">Richard Screwll </a>
                                                   <a id="vote-up" href="#fakelink" employer-vote="1" job-id="616"><i class="icon-thumbs-up"></i>2</a>
                                                   <a id="vote-down" href="#fakelink" class="icon-thumbs" employer-vote="-1" job-id="616"><i class="icon-thumbs-down"></i>1</a>
                                                   <div class="clear"></div>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="st-applicant">Minions have applied.  </div>
                                       <a href="#fakelink" class="btn btn-primary">
                                       <i class="icon-check"></i>
                                       Select Minions
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </li>
						  <a href="#" class="btn load-btn" style="width:99%;"><i class="icon-undo"></i> Load more</a>
						   </ul>
					</div>
					<div class="span3">
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
            <div class="span12" id="profile-edit" style="height:502px;">
                <div class="row-fluid">	
                    <div class="span8">
                    <form class="form-horizontal frm-edit" id="profile-edit-form">


                        <?php if (get_user_role() === 'minyawn'): ?>
                            <div class="control-group">
                                <label class="control-label" for="inputFirst">First Name</label>
                                <div class="controls">
                                    <input type="text" id="first_name" name="first_name" placeholder="" value="<?php user_profile_first_name() ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputlast">Last Name</label>
                                <div class="controls">
                                    <input type="text" id="last_name"  name="last_name" placeholder="" value="<?php echo user_profile_last_name() ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputemail">Email</label>
                                <div class="controls">
                                    <input type="text" id="profileemail" disabled  name="profileemail" placeholder="" value="<?php user_profile_email() ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inptcollege">College</label>
                                <div class="controls">
                                    <input type="text" id="college"  name="college" placeholder="" value="<?php user_college() ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputmajor">Major</label>
                                <div class="controls">
                                    <input type="text" id="major"  name="major" placeholder="" value="<?php user_college_major() ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputskill">Skill</label>
                                <div class="controls">

                                    <input name="user_skills2" id="user_skills2" class="tagsinput1" value="<?php echo get_user_skills(); ?>"  style="width:60%;"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="LinkedIn">LinkedIn url</label>
                                <div class="controls">
                                    <input type="text" id="linkedin"  name="linkedin" placeholder="www.linkedin.in/username" value="<?php user_profile_linkedin(); ?>" class="input">
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="control-group">
                                <label class="control-label" for="inputFirst">Company Name</label>
                                <div class="controls">
                                    <input type="text" id="company_name" name="company_name" placeholder="" value="<?php echo user_profile_company_name() ?>" class="input">

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputbody">Location</label>
                                <div class="controls">
                                    <input type="text" id="location"  name="location" placeholder="" value="<?php user_location(); ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputbody">Company Website</label>
                                <div class="controls">
                                    <input type="text" id="company_website"  name="company_website" placeholder="" value="<?php user_company_website(); ?>" class="input">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputbody">Profile Body</label>
                                <div class="controls">
                                    <textarea rows="5" type="text" id="profilebody"  name="profilebody"  placeholder="" class="input" style=" width: 90% !important; " ><?php user_profile_body(); ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <a href="#" class="btn btn-large btn-block btn-inverse span3 float-right" id="update-profile-info"><i class="icon-refresh"></i>&nbsp; Update Info</a>
                        <input type="hidden" value="<?php user_id(); ?>" name="id" id="id"/>
                        <div class="clear"></div>
                    </form>
                   </div> 
                   <div class="span4">
                       <div class=" widget-sidebar">
							<?php
                                                                   
                    if (get_user_role() == 'employer') {
							echo '<h5>
							Stand out from the crowd with a complete profile</h5>
							<hr>
							Did you know? Adding your logo makes your profile 7 time more likely to have more applications. Simple updates like these make a difference.
							Here are quick steps to create a complete profile and ensure you’re putting your best foot forward:<br><br>
							Fill in the details on your left.<br>
							Add your company logo (.jpg image)<br><br>
							Click on Update Info to save your profile. ';
							} 
							
							?>
							<?php
                                                                   
                    if (get_user_role() == 'minyawn') {
							
							echo 'Complete profiles usually get more attention from employers, making you a more eligible candidate. Create more opportunities for yourself to earn extra money, and bag amazing ratings and reviews from your employers.
<br><br>
							If you have any issues, please feel free to drop us an email on <a href="mailto:support@minyawns">support@minyawns</a>';
							
							} ?>
							
                       </div>
                   </div>
                </div>
            </div>
            <div class="clear"></div>
            <?php
//} 
            ?>
        </div>
    </div>
</div>
<?php
get_footer();