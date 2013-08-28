
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
    <div class="job-logo header-sub"> <%= job_author_logo %></div>
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

    <div class="job-progress header-sub">
    
     <%  if(can_apply_job == 0 && todays_date_time < job_end_time_check) %>
        <span class="label-available">Available</span>


        <% else if (todays_date_time > job_end_time_check){%>
         <span class="label-unavailable">This job is complete</span>

        <% }else if (can_apply_job == 3){%>
         <span class="label-hired">You are hired for this job.</span>
        <% }else if (can_apply_job == 2) {%>
         <span class="label-available">You have applied for this job.</span>

        <% }
        %> 
    

    </div>

    <div class="job-action header-sub">

    <div class="arrow-down">
    </div>

    </div>
    </div>
    </a>
    </div>

    <div id="collapse<%= post_id %>" class="accordion-body collapse ">
    <div class="accordion-inner">
    <div class="row-fluid header-title">
    <div class="span12">
    <h3><a href=<?php echo site_url() ?>/job/<%= post_slug %> target="_blank" > <%= post_title %> <span class="view-link"><i class="icon-search"></i> View</span></a> </h3>
    </div>
    </div>
    <div class="row-fluid job-data">
    <div class="span9 inner-data">
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Requested by :</b></div><div class="span9"> <a href="#" class="request_link"><%= job_author %></a>  </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Location :</b></div><div class="span9"><%= job_location %> </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Details :</b></div><div class="span9"><%= job_details.substring(0, 140) %> </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Tags :</b></div><div class="span9"> <% for(i=0;i<tags_count;i++){ %> <span class="label"><%= tags[i] %></span><%}%> </div>
    </div>
    </div>
    <div class="span3">
    <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-left.png">
    <div class="div-box-block">
<span class='load_ajax1' style="display:none"></span>
<?php if (get_user_role() === 'minyawn'): ?> 

            <%  if(can_apply_job == 3) %>
            <a href="#" class="required">You are hired!</a>
            <% else if(can_apply_job == 2 )%>
            <a href="#" id="unapply-job" class="btn btn-medium btn-block btn-danger red-btn" data-action="unapply" data-job-id="<%= post_id %>">Unapply</a>
            <% else if(can_apply_job == 0 ) %>
            <a href="#" id="apply-job" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Apply</a>
            
            <% else if(can_apply_job == 1 ) %>
            <a href="#" class="required">Requirement Complete</a>
  
    

    <?php
else:
    ?>
            <%  if(can_apply_job == 1 || todays_date_time > job_end_time_check) %>
            <a href="#" class="required">Requirement Complete</a>

            <% else if (todays_date_time < job_end_time_check && can_apply_job == 0){%>
            <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Select Your Minyawns</a>
            <% }else if(can_apply_job ==3 || todays_date_time > job_end_time_check ){ %>
            <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-large btn-block btn-inverse  btn-rate" data-action="apply" data-job-id="<%= post_id %>">Rate Your Minyawns</a>
            <% }
            %> 

<?php
endif;
?>

    </div>

    </div>
    </div>



    </div>

    <!-- Row Div -->


</script>
<div class="container">
	<div id="main-content" class="main-content bg-white">
		<div class="breadcrumb-text">
			<p id="bread-crumbs-id">
				<a href="#" class="view loaded edit-user-profile">My Profile</a>
			</p>
		</div>
		<div class="row-fluid profile-wrapper">
		<?php if(check_access()===true)
		{
			 
		?>
			<div class="span12" id="profile-view">
				<div class="row-fluid min_profile">

					<div class="span2">
						<a href="#" id="change-avatar-span" class="change-avtar">
							<?php 	if(get_mn_user_avatar() !== false)
										echo '<img src="' . get_mn_user_avatar() .'" width="168" height="168" />';
									else
										echo get_avatar( get_user_profile_email(), 168 )
							?>
							<span >Change Avatar</span>
						</a>
						<input id="change-avatar" type="file" name="files" style="visibility:hidden">
					</div>
					<div class="span8">
                                            <h4 class="name"> <?php if(get_user_role() === "employer"){ echo user_profile_company_name(); } else { user_profile_first_name()." ".user_profile_last_name();}   ?>  <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a></h4> 
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
										$skills = explode(',',get_user_skills());
                                                                              	
											for ($skill=0;$skill<sizeof($skills);$skill++)
												echo "<span class='label label-small'>$skills[$skill]</span>";
										
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
						<div class="like_btn gray-like"><br><br>
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
                                <div class="jobs_table">
            <div id="browse-jobs-table" class="table-border browse-jobs-table">
               
                <!-- Row Div header -->
                <div class="row-fluid ">
                    <div class="span12 header-title">
                        <div class="job-logo header-sub"> Logo</div>
                        <div class="job-date header-sub"> Session Date</div>
                        <div class="job-time header-sub">Duration</div>
                        <div class="job-wage header-sub">Wages</div>
                        <div class="job-progress header-sub">Progress</div>
                        <div class="job-action header-sub">Action</div>
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
		} 
			?>
		</div>
	</div>
</div>
<?php
 
get_footer();