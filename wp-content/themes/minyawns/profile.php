
<?php
/**
  Template Name: Profile Page
 */
get_header();
require 'templates/_jobs.php';
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {

        if (is_logged_in.length === 0) {
            jQuery("#change-avatar-span").attr("href", "#")
            jQuery("#change-avatar-span").find("span").remove();
        }

        jQuery("#tab_identifier").val('1');
        
        $(".inline li").removeClass("selected");
        
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
                <a href="<?php echo site_url() ?>/profile/" class="view loaded">My Profile</a>
               
<!--                <a href="#" class="view loaded edit-user-profile"><?php if(get_user_id()== get_current_user_id()) echo "My"; else if(strlen(user_profile_company_name())>0) echo mb_convert_case(user_profile_company_name(), MB_CASE_TITLE, "UTF-8"); else echo mb_convert_case(user_profile_first_name(), MB_CASE_TITLE, "UTF-8"); ?></a>-->
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
                           
                           
                            if(get_mn_user_avatar() !== false){
		              ?><img src="<?php echo get_mn_user_avatar() ?>"/><?php 
                              
                            }else{
				echo get_avatar(get_user_id(), 168 );
                             }
                             ?>
                        </a> <?php if(is_facebook_user() === 'false' && get_current_user_id() == get_user_id()){ ?>
						  <a href="#myprofilepic"  id="change-avatar-span" class="change-avtar avtar-btn" data-toggle="modal">Change Profile Pic</a>
                        <?php }?>
						</div>
                            <?php if (is_user_logged_in()) { ?>              
                        
                       
                                                  <input id="change-avatar" type="file" name="files" style="display:none;">
                            <?php }?>
                    </div>
                    <div class="span10">
					  <?php if (get_user_role() === 'minyawn'): ?>
					<div class="social-link profile-social-link"> 
				
					
					<a href='http://<?php echo user_profile_linkedin() ?>' target='_blank'><i class="icon-linkedin"></i></a></div>
    <?php endif; ?>		                      
					  <h4 class="name"> <?php
                            if (get_user_role() === "employer") {
                                echo user_profile_company_name();
                            } else {
                                user_profile_first_name() . " " . user_profile_last_name();
                            } if (!is_numeric(check_direct_access())) {
                                ?>  <a href="<?php echo site_url() ?>/edit-profile" id="edit-user-profile" class="edit"><i class="icon-edit"></i> Edit</a><?php } ?>

								<?php
                                                      
                                                            if(is_user_verified()=== 'Y'){ ?>	
                                                        <span class="minyawnverified"><img src="<?php echo get_template_directory_uri(); ?>/images/verify.png"  style="margin-top: -7px;"/> Minyawn verified </span> 
                                                       
                                                        <i class="icon-question-sign verfied-help"  id="example"></i> 
                                                         <?php }?>

							

								</h4> 
								 <?php if (get_user_role() === 'employer'): ?>
								<div class="employer-body">
								
								 <?php echo user_profile_body(); ?>
								</div>
								<?php endif; ?>	
								
								
                     <div class="profiledata ">
					  <?php if (get_user_role() === 'minyawn'): ?>
                                   <ul class="college-data inline">
									<li class="college_data">
								   College : <b>  <?php echo user_college(); ?></b>
								   </li>
								   <li class="major_data">
								   Major : <b>  <?php echo user_college_major(); ?></b>
								   </li>
								   </ul>
                     <?php
                            else :
                                ?>	
								<ul class="college-data inline">
									<li class="location">
								   Location : <b>    <?php echo user_location(); ?></b>
								   </li>
								   <li class="website">
								   Company Website : <b>  <a href="http://<?php user_company_website(); ?>" target="_blank"><?php echo user_company_website(); ?></a></b>
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
<!--                            <span class="userrev">User reviews <a href='javascript:void(0)' id='example_right' class='commentsclick' rel='popover'  user-id="<?php echo user_id(); ?>"  data-html='true'></a><span class='load_ajax_profile_comments' style="display:none; float:right"></span></span> -->
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
				<p>All your Jobs are listed below</p>
				<div class="row-fluid accordion">
					<div class="span9">
						<ul class="unstyled job-view-list" id="accordion24">
						<dl class="accordion">
                            <dt class="avial">
                                             <a href="#"> Wash My Car  <span>View More</span></a>
                               </dt>
						 <dd>  <li class="_li job-open ">
						  
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
						   </dd>
						    <dt class="non-avial">
                                             <a href="#"> The template has been conceived with a proper balance UI & UX in order to offer an excellent  <span>View More</span></a>
                               </dt>
						    <dd>
                           <li class="_li job-open accord-content">
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
                           </li>  </dd>
						    <dt class="avial">
                                             <a href="#"> The template has been conceived with a proper balance UI & UX in order to offer an excellent  <span>View More</span></a>
                               </dt>
						    <dd>
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
                           </li> </dd>
						  <a href="#" class="btn load-btn" style="width:99%;"><i class="icon-undo"></i> Load more</a>
						  </dl>
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
          
            <div class="clear"></div>
            <?php
//} 
            ?>
        </div>
    </div>
</div>
<?php
get_footer();