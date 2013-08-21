
<?php
/**
  Template Name: Profile Page
 */
get_header();  ?>

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
                                            <h4 class="name"> <?php user_profile_first_name()." ".user_profile_last_name()   ?>  <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a></h4> 
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
												echo "<a href='#' target='_blank'>$social</a>";
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
				<div id="my-history" class="row-fluid">
					<div class="span12">
						<section id="no-more-tables">
							<?php $jobs = new MN_User_Jobs(array('user_id' => get_user_id())); ?>

							<?php if($jobs->have_jobs()): ?>
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
									<tr class="subheader_row profile">
										<th
											class="subheader_cell awm_exchange_service_tlt service_tlt headerSortDown profile-logo">Logo</th>
										<th
											class="subheader_cell awm_exchange_service_demand headerSortDown profile-date">Session
											Date</th>
										<th
											class="subheader_cell awm_exchange_service_supply headerSortDown profile-time">Duration</th>
										<th
											class="subheader_cell awm_exchange_service_discount headerSortDown profile-wages">Wages</th>
											<th class="subheader_cell awm_exchange_service_discount headerSortDown profile-status">Status </th>
										<th class="subheader_cell awm_exchange_services_action profile-rating">Ratings</th>
									</tr>
								</thead>
								<tbody class="data_container">
									<tr class="data_even">
										<!-- table 1-->
										<td colspan="7">
											<table class="ins_table profile">
												 <tr class="data_even completed">
														<td class="data_cell awm_service_title profile-logo" >
															<img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/>
														</td>
														<td class="data_cell awm_service_demand profile-date">
														   <span class="service-total-demand" data-count="1">10</span>
														   <div>
															 June<b  class="service-client-demand" data-count="1">2013</b>
														   </div>
														   <div class="demand"> Thusrday</div>
														</td>
														<td  class="data_cell awm_service_supply duration_mob profile-time">
															 <div class="row-fluid">
														  <div class="span5">
															<span data-count="0" class="total-exchange-count">8:00</span>
															   <div>
																 am
															   </div>
															</div>
														  <div class="span2">
															<b class="time-bold">to</b>
														</div>
														<div class="span5">
															 <span data-count="0" class="total-exchange-count">12:00</span>
																<div>
																pm
																</div>
														 </div>
														   </div>
														</td>
														<td   class="data_cell awm_service_discount profile-wages">
														   <ins><span class="amount">$28</span></ins>
														</td>
														<td   class="data_cell awm_service_discount profile-status">
														  <!--<span class="label label-small label-success">Completd</span>-->
													<span class="label label-small label-important">Pending</span>
														 <!-- <span class="label label-small label-warning">Applied</span> -->
														</td>
													   <td   class="data_cell awm_service_action rating profile-rating">
														 <span class="ratings"> +1</span>
														</td>
													 </tr>
											</table>
										</td>
									</tr>

								</tbody>
							</table>
						<?php else: ?>

							<!--show html here if user doesn't have any jobs-->

							<div class="alert alert-info myjobs ">
								<h4 style="text-align: center">No Jobs Available</h4>
								<hr>
								There doesn't seem to be anything here. you can apply for jobs
                                                                on the '<B>Browse Jobs</B>' page <a href="<?php echo site_url();?>/jobs/"
									class="btn btn-large btn-block btn-success default-btn">Take Me
									There</a>
							</div>


							<?php endif; ?>
						</section>
						<br>
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
					    		<input name="user_skills" id="user_skills" class="tagsinput " value="<?php echo get_user_skills(); ?>"  style="width:60%;"/>
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
                                                      <label class="control-label" for="inputFirst">Company Name</label>
						    <div class="controls">
                                                        <input type="text" id="first_name" name="first_name" placeholder="" value="<?php user_profile_first_name() ?>" class="input">
                                                        
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