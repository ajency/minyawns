<?php
get_header();

global $minyawn_job;

?>
<div class="container">
	<div class="tab-content">
		<div class="tab-pane active" id="tab2">
		   <div class="breadcrumb-text">
		      <p>
		         <a href="#">My Jobs</a>
		         <a href="#single-jobs" class="view  edit-job-data"><?php echo get_the_title() ?></a>
                          <?php if(get_user_role() === 'employer'): ?> 
                          <a href="#edit-job-form" class="edit loaded edit-job-data"><i class="icon-edit"></i> Edit</a>
                          <?php endif; ?>
		      </p>
		   </div>
		   <div   style="height: 680px; ">
					<div id="single-jobs" class="span12" style=" margin-left: 0px; width: 100%; ">
		   <div  class="row-fluid  list-jobs single-jobs ">
		 
		      <div class="span12 jobs-details">
		         <div class="span2 img-logo"> <img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/> </div>
		         <div class="span3 minyawns-select">
		            <span><?php echo $minyawn_job->get_job_applied_minyawns(); ?></span>
		            <div><b>Minyawns Have Applied</b></div>
		         </div>
		         <div class="span3 jobs-date">
                             <div class="posteddate"> Posted Date : <span><?php echo $minyawn_job->get_job_posted_date(); ?></span></div>
		            <div class="jobsdate"> Jobs Date : <span><?php echo $minyawn_job->get_job_date(); ?></span></div>
		         </div>
		         <div class="span3 job-duration">
		            <div class="row-fluid">
		               <div class="span5">
		                  <span data-count="0" class="total-exchange-count"><?php echo $minyawn_job->get_job_start_time(); ?></span>
		                  <div>
		                    <?php echo $minyawn_job->get_job_start_time_ampm() ?>
		                  </div>
		               </div>
		               <div class="span2">
		                  <b class="time-bold">to</b>
		               </div>
		               <div class="span5">
		                  <span data-count="0" class="total-exchange-count"><?php echo $minyawn_job->get_job_end_time(); ?></span>
		                  <div>
		                    <?php echo $minyawn_job->get_job_end_time_ampm() ?>
		                  </div>
		               </div>
		            </div>
		         </div>
		         <div class="span1 wages">
		            $<?php echo $minyawn_job->get_job_wages(); ?>
		         </div>
		      </div>
		      <div class="span12 expand">
		         <div class="row-fluid jobdesc">
		            <div class="span3 jobsimg"> <img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/></div>
		            <div class="span9 job-details"><?php echo $minyawn_job->get_job_details() ?></div>
		         </div>
		         <?php if(get_user_role() === 'minyawn'): ?> 
		         	<hr class="border-color">
		         	<img class="bottom-arrow" src="<?php echo get_template_directory_uri() ?>/images/bottom-arrow.png">
		         
                                <?php if($minyawn_job->can_apply == 0) : ?>
			         	<a href="#" id="apply-job" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<?php echo $minyawn_job->ID; ?>">Apply</a>
			         <?php elseif($minyawn_job->can_apply == 2) : ?>
			         	<a href="#" id="unapply-job" class="btn btn-medium btn-block btn-danger red-btn" data-action="unapply" data-job-id="<?php echo $minyawn_job->ID; ?>">Unapply</a>
			         <?php elseif($minyawn_job->can_apply == 1) : ?>
			         	<a href="#" class="btn btn-medium btn-block btn-success red-btn">Requirement Complete</a>
			         <?php endif;
			     else:  
                                //show all applied minyanws data
			     	include_once 'applied_minyaws.php';
			     endif;
			     ?>
		   </div>
		</div>
		</div>
                    <div id="edit-job-form" class="span12" style=" margin-left: 0px; width: 100%; " >
					
                        <form id="job-form" class="form-horizontal">
                            
                            <input type="hidden" value="<?php echo $minyawn_job->get_job_id(); ?>" name="id"></input>
                             <div class="control-group small">

                                <label class="control-label" for="inputtask">Tasks</label>
                                <div class="controls ">
                                   <!-- <input type="text" id="job_task" name="job_task" value="<?php echo get_the_title() ?>" placeholder="" class="span3">-->
									<textarea class="span6" name="job_task" rows="10" id="job_task" maxlength="100" cols="4" placeholder="" style="height:70px;"><?php echo get_the_title() ?></textarea>
                                </div>
                            </div>
                            <div class="control-group small float-left ">
                                <label class="control-label" for="inputtask">Start</label>
                                <div class="controls">
                                    <div class="input-prepend input-datepicker">
                                        <button type="button" class="btn"><span class="fui-calendar"></span></button>
                                        <input type="text" class="span1" name="job_start_date" value="<?php echo $minyawn_job->get_job_date(); ?>" id="job_start_date">
                                    </div>

                                </div>
                            </div>
                            <div class="input-append bootstrap-timepicker">
                                <input id="job_start_time" type="text" value="<?php echo $minyawn_job->get_start_time_eform() ?>" class="timepicker-default input-small" name="job_start_time" >
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                            <div class="clear"></div>
                            <div class="control-group small float-left">
                                <label class="control-label" for="inputtask">End</label>
                                <div class="controls">
                                    <div class="input-prepend input-datepicker">
                                        <button type="button" class="btn"><span class="fui-calendar"></span></button>
                                        <input type="text"  name="job_end_date" class="span1" value="<?php echo $minyawn_job->get_job_end_date(); ?>" id="job_end_date">
                                    </div>
                                </div>

                            </div>
                            <div class="input-append bootstrap-timepicker">
                                <input id="job_end_time" type="text" class="timepicker-default input-small" value="<?php echo $minyawn_job->get_start_time_eform() ?>" name="job_end_time">
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                            <div class="clear"></div>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Required</label>
                                <div class="controls ">
                                    <input type="text" name="job_required_minyawns" id="job_required_minyawns" placeholder="" value="<?php echo $minyawn_job->get_job_required_minyawns(); ?>" class="spinner">
                                </div>
                            </div>


                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Wages</label>

                                <div class="controls small">
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-dollar"></i></span>
                                        <input class="span2" id="job_wages" type="text" name="job_wages" value="<?php echo $minyawn_job->get_job_wages(); ?>">
                                    </div>
                                </div>


                            </div>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Location</label>
                                <div class="controls ">
                                    <input type="text" name="job_location" id="job_location" value="<?php echo $minyawn_job->get_job_location(); ?>" placeholder="" class="span9">
                                </div>
                            </div>

                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Tags</label>
                                <div class="controls ">
                                    <input  name="job_tags" id="job_tags" value="<?php echo $minyawn_job->get_job_tags(); ?>" placeholder="" class="tm-input tagsinput">
                               </div>
                            </div>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Details</label>
                                <div class="controls ">
                                    <textarea class="span6" name="job_details" rows="10" id="job_details" cols="4" placeholder="" style="height:70px;"><?php echo $minyawn_job->get_job_details() ?></textarea>
                                </div>
                            </div>
                            <hr>
                            <a id="update-job" href="#" class="btn btn-large btn-block btn-inverse span2 float-right" >Submit</a>
                            <div class="clear"></div>
                        </form>
                    </div>
					 </div>
	</div>
</div>
</div>
<?php
get_footer();