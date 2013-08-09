
<?php
/**
  Template Name: Profile Page
 */
get_header();  ?>

<div class="container">
	<div id="main-content" class="main-content bg-white">
		<div class="breadcrumb-text">
			<p id="bread-crumbs-id">
				<a href="#" class="view edit-user-profile">My Profile</a>
			</p>
		</div>
		<div class="row-fluid profile-wrapper">
			<div class="span12" id="profile-view">
				<div class="row-fluid min_profile">

					<div class="span2">
						<a href="#" class="change-avtar">
							<?php echo get_avatar( get_user_profile_email(), 168 ); ?>
							<span>Change Avatar</span>
						</a>
					</div>
					<div class="span8">
						<h4 class="name"> <?php user_profile_name(); ?>  <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a></h4> 
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
									<?php user_profile_email(); ?>
									<?php 
										$socials = get_user_social_pages();
										if(is_array($socials))
										{	
											foreach ($socials as $social)
												echo "<a href='#'>$social</a>";
										}
									?>
							</div>
							<div class="span2">
								Skills :
							</div>
							<div class="span10 user_skills">
									<?php 
										$skills = get_user_skills();
										if(is_array($skills))
										{	
											foreach ($skills as $skill)
												echo "<span class='label label-small'>$skill</span>";
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
					        <div class="span2 profilebody">
					           Body :
					        </div>
					        <div class="span10">
					        	 <?php user_profile_body(); ?>
					        </div>
					        <div class="span2">
					            Company Website :
					        </div>
					        <div class="span10 company_website">
					           - <a href="<?php user_company_website(); ?>"><?php user_company_website(); ?></a>
					        </div>
					        <?php
							endif; 
							?>
						</div>
						
					</div>
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
				</div>

				<hr>
				<div id="my-history" class="row-fluid">
					<div class="span12">
						<section id="no-more-tables">
							<table class="qlabs_grid_container tablesorter jobs_table">
								<thead>
									<tr class="header_row">
										<td colspan="7" class="header_cell">
											<div class="row-fluid">
												<div class="span12">
													<h3 class="page-title">My History</h3>
													<!-- header label -->
													Applied, pending and completed job history
												</div>
											</div>
										</td>
									</tr>
									<tr class="subheader_row">
										<th
											class="subheader_cell awm_exchange_service_tlt service_tlt headerSortDown">Logo</th>
										<th
											class="subheader_cell awm_exchange_service_demand headerSortDown">Session
											Date</th>
										<th
											class="subheader_cell awm_exchange_service_supply headerSortDown">Duration</th>
										<th
											class="subheader_cell awm_exchange_service_discount headerSortDown">Wages</th>
										<th class="subheader_cell awm_exchange_services_action">Ratings</th>
									</tr>
								</thead>
								<tbody class="data_container">
									<tr class="data_even">
										<!-- table 1-->
										<td colspan="7">
											<table class="ins_table">
												

											</table>
										</td>
									</tr>

								</tbody>
							</table>
						</section>
						<br>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="span11" id="profile-edit">
				<form class="form-horizontal frm-edit" id="profile-edit-form">
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
				  	<?php if(get_user_role() === 'minyawn'): ?>
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
				    		<input name="user_skills" id="user_skills" class="tagsinput " value="<?php echo implode(',',get_user_skills()); ?>"  style="width:60%;"/>
				    	</div>
				  	</div>
				  	<div class="control-group">
				    	<label class="control-label" for="LinkedIn">LinkedIn url</label>
				    	<div class="controls">
				     		<input type="text" id="linkedin"  name="linkedin" placeholder="" value="<?php user_profile_linkedin(); ?>" class="input">
				    	</div>
				  	</div>
				  <?php else : ?>
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
				      		<textarea type="text" id="profilebody"  name="profilebody"  placeholder="" class="input" ><?php user_profile_body(); ?></textarea>
				    	</div>
				  	</div>
				 	<?php endif; ?>
				  	<!--
				   	<div class="control-group">
				    	<label class="control-label" for="LinkedIn">Upload a photo</label>
				    	<div class="controls">
				     		<div class="form-group">
				      			<label for="exampleInputFile">You can upload a JPG, GIF or PNG file ( File size limit is 4MB )</label>
				      			<input type="file" id="exampleInputFile" id="profileimage" name="profileimage">
							</div>
				    	</div>
				  	</div>-->
				  	<hr>
				  	<a href="#" class="btn btn-large btn-block btn-inverse span2" id="update-profile-info">Update Info</a>
				  	<input type="hidden" value="<?php user_id(); ?>" name="id" id="id"/>
				  	<div class="clear"></div>
				</form>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php
 
get_footer();