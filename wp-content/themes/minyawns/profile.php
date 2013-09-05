
<?php
/**
  Template Name: Profile Page
 */
get_header();  ?>

<script type="text/templates" id="no-result">
    <div class="alert alert-info myjobs no-job ">
    <b style="text-align: center">No Jobs Available ! </b>&nbsp;
    There doesn't seem to be anything here.
    </div>
</script>
<script type="text/template" id="browse-jobs-table-profile">

    <div style="clear:both;">	</div>
    <div class="accordion-group">
    <div id="last-job-id" last-job="<%= post_id %>" value="<%= post_id %>"></div>
    <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<%= post_id %>">
    <div class="span12 data-title available">
    <div class="job-logo header-sub"> <div class="logo"><%= job_author_logo %></div></div>
    <div class="job-date header-sub">
    <span class="service-total-demand" data-count="0"><%= job_start_day %></span>
    <div>
    <%= job_start_month %><b class="service-client-demand" data-count="0"><%= job_start_year %></b>
    </div>
    <div class="demand"><%= job_day %></div>
    </div>
    <div class="job-time header-sub duration_mob">
    <div class="row-fluid">
    <div class="span5 mob-botm">
    <span data-count="0" class="total-exchange-count"><%= job_start_time %></span>
    <div>
    <%= job_start_meridiem %>
    </div>
    </div>
    <div class="span2">
    <b class="time-bold">to</b>
    </div>
    <div class="span5">
    <span data-count="0" class="total-exchange-count"><%= job_end_time %></span>
    <div>
    <%= job_end_meridiem %>
    </div>
    </div>
    </div>
    </div>

    <div class="job-wage header-sub">
    <ins><span class="amount">$ <%= job_wages %></span></ins>
    </div>

    <div class="job-progress profile-job header-sub">
    
    <?php if(get_user_role() == 'minyawn') { ?>
     <%  if(can_apply_job == 0 && todays_date_time < job_end_time_check) %>
        <span class="label-available">Available</span>


        <% else if (todays_date_time > job_end_time_check){%>
         <span class="label-unavailable">This job is complete</span>

        <% }else if (can_apply_job == 3){%>
         <span class="label-hired">You are hired for this job.</span>
        <% }else if (can_apply_job == 2 || can_apply_job == 1) {%>
         <span class="label-available">You have applied for this job.</span>

        <% }
        %> 
    <?php }else{ ?>

        <%  if(is_job_owner == 1 && can_apply_job == 0 && minyawns_have_applied == 0 ) %>
        <span class="label-available">No Applications yet</span>
        <%  else if(can_apply_job == 3)%>
        <span class="label-available">Minyawns Hired</span>
        <% else if(can_apply_job == 2 || minyawns_have_applied == 1)%>
                <span class="label-available">Minyawns Have Applied</span>
    <?php } ?>
    </div>


    </div>


    </div>



    </div>

    <!-- Row Div -->


</script>
<div id="myprofilepic" class="modal hide fade cropimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Change Avatar</h4>
  </div>
  <div class="modal-body">
    <div style="margin:0 auto; width:600px">

<div id="thumbs" style="padding:5px; width:600px"></div>
<div style="width:600px" id="image_upload_body">

<form id="cropimage" method="post" enctype="multipart/form-data">
 <a type="button" class="btn btn-primary" id="done-cropping" style="display:none">Done? </a>
	Upload your image <input type="file" name="files" id="photoimg" /><br><span class='load_ajax-crop-upload' style="display:none"></span>
<!--        <br>
        Please drag to select/crop your picture.
	<p class="help-block meta">Upload an image for your profile.</p></br>
	
	</br>
	<input type="hidden" name="image_name" id="image_name" value="" />
	<img id="uploaded-image" ></img>
        <input type="hidden"  id="image_height">
        <input type="hidden"  id="image_width">
        <input type="hidden"  id="image_x_axis">
       <input type="hidden"  id="image_y_axis">
       <input type="hidden" value="<?php echo (get_user_role() == 'employer' ? '2:1' : '1:1')?>" id="aspect_ratio">-->
       
</form>

</div>
</div>
  </div>
  
</div>
<div class="container">
	<div id="main-content" class="main-content bg-white">
		<div class="breadcrumb-text">
                    
                    <p id="bread-crumbs-id">
				
			<a href="<?php echo site_url() ?>/jobs/" class="view loaded">My Jobs</a>
				<a href="#" class="view loaded edit-user-profile">My Profile</a>
			</p>
		</div>
		<div class="row-fluid profile-wrapper">
		<?php //if(check_access()===true)
		//{
			 
		?>
			<div class="span12" id="profile-view">
				<div class="row-fluid min_profile">

                                        <div class="span2 <?php if(get_user_role() == 'employer'){ echo 'employer-image'; }?>">
						<a href="#myprofilepic"  id="change-avatar-span" class="change-avtar" data-toggle="modal">
							<?php 	if(get_mn_user_avatar() !== false)
										echo  get_mn_user_avatar();
									else
										echo get_avatar( get_user_id(), 168 )
							?>
							<span >Change Avatar</span>
						</a>
						<input id="change-avatar" type="file" name="files" style="visibility:hidden">
					</div>
					<div class="span8">
                                            <h4 class="name"> <?php if(get_user_role() === "employer"){ echo user_profile_company_name(); } else { user_profile_first_name()." ".user_profile_last_name();}   if(!is_numeric(check_direct_access())) {?>  <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a><?php }?></h4> 
						<div class="row-fluid profile-list">
							<?php

							if(get_user_role() === 'minyawn'): ?>


							<div class="span2">
								College :
							</div>
							<div class="span10 college">
									<?php user_college(); ?>
							</div>
								<div class="span2">
								Major :
							</div>
							<div class="span10 major">
									<?php user_college_major(); ?>
							</div>
							<div class="span2">
								Social Page :
							</div>
							<div class="span10 profileemail">
                                                            <a href='http://<?php echo user_profile_linkedin() ?>' target='_blank'><?php echo user_profile_linkedin() ?></a>
									
							</div>
							<div class="span2">
								Skills :
							</div>
							<div class="span10 user_skills">
									<?php 
                                                                        
                                                                        if((get_user_skills()!= " ")){
										$skills = explode(',',get_user_skills());
                                                                              	
											for ($skill=0;$skill<sizeof($skills);$skill++)
												echo "<span class='label label-small'>$skills[$skill]</span>";
                                                                        }
									?>
							</div>
							<?php
							else :
							?>		
							<div class="span2">
					            Location :
					        </div>
					        <div class="span10 location">
					            <?php user_location(); ?>
					        </div>
					        <div class="span2">
					           Body :
					        </div>
					        <div class="span10 profilebody">
					        	 <?php user_profile_body(); ?>
					        </div>
					        <div class="span2">
					            Company Website :
					        </div>
					        <div class="span10 company_website">
					           - <a href="<?php user_company_website(); ?>" target="_blank"><?php user_company_website(); ?></a>
					        </div>
					        <?php
							endif; 
							?>
						</div>
						
					</div>
					<?php if(get_user_role() === 'minyawn'): ?>
					<div class="span2">
						<br>
						<div class="like_btn"><br><br>
							<a href="#fakelink" style="float:left;" >
								<i class="icon-thumbs-up"></i><br>
								<b class="like"><?php user_like_count(); ?></b>
							</a> 
							<a href="#fakelink" >
								<i class="icon-thumbs-down"></i><br>
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
					</div>	
					<?php endif; ?>			
				</div>

				<hr>
				<div class="clear"></div><br>

                                <h3> <a href="<?php echo site_url() ?>/jobs">To Visit Jobs Section Click Here</a></h3><br/><br/><br/>

                                <div class="jobs_table">
            <div id="browse-jobs-table" class="table-border browse-jobs-table">
               
                <!-- Row Div header -->
                <div class="row-fluid ">
                    <div class="span12 header-title">
                        <div class="job-logo header-sub"> Logo</div>
                        <div class="job-date header-sub"> Session Date</div>
                        <div class="job-time header-sub">Duration</div>
                        <div class="job-wage header-sub">Wages</div>

                        <div class="job-progress profile-job header-sub">Progress</div>
                       

                    </div>
                </div>

                <div class="row-fluid " id="accordion22" >

                </div>

                <button class="btn load_more" id="load-more"> <div><span class='load_ajax' style="display:block"></span> <b>Load more</b></div></button>
            </div>
                        </div>
				<div class="clear"></div>
			</div>
			<div class="span12" id="profile-edit">
				<div class="row-fluid">	
					<form class="form-horizontal frm-edit" id="profile-edit-form">
					  	
						  
					  	<?php if(get_user_role() === 'minyawn'): ?>
                                            <div class="control-group">
                                                      <label class="control-label" for="inputFirst">First Name</label>
						    <div class="controls">
						      	<input type="text" id="first_name" name="first_name" placeholder="" value="<?php user_profile_first_name() ?>" class="input">
						    </div>
					  	</div>
					    <div class="control-group">
					    	<label class="control-label" for="inputlast">Last Name</label>
					    	<div class="controls">
					      		<input type="text" id="last_name"  name="last_name" placeholder="" value="<?php user_profile_last_name() ?>" class="input">
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
					  	<a href="#" class="btn btn-large btn-block btn-inverse span2 float-right" id="update-profile-info">Update Info</a>
					  	<input type="hidden" value="<?php user_id(); ?>" name="id" id="id"/>
					  	<div class="clear"></div>
					</form>
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