<?php
get_header();

global $minyawn_job;
$single_job=new Minyawn_Job(get_the_ID());

?>
<div class="container">
	<div class="tab-content">
		<div class="tab-pane active" id="tab2">
		   <div class="breadcrumb-text">
		      <p>
		         <a href="myjobs.html">My Jobs</a>
		         <a href="#" class="view loaded edit-job-data"><?php echo get_the_title() ?></a>
                         <a href="#" class="edit  edit-job-data"><i class="icon-edit"></i> Edit</a>
		      </p>
		   </div>
		   <div id="single-jobs" class="row-fluid  list-jobs single-jobs ">
		      <div class="span12 jobs-details">
		         <div class="span2 img-logo"> <img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/> </div>
		         <div class="span3 minyawns-select">
		            <span><?php echo $single_job->get_job_required_minyawns(); ?></span>
		            <div><b>Minyawns Have Applied</b></div>
		         </div>
		         <div class="span3 jobs-date">
                             <div class="posteddate"> Posted Date : <span><?php echo $single_job->get_job_posted_date(); ?></span></div>
		            <div class="jobsdate"> Jobs Date : <span><?php echo $single_job->get_job_date(); ?></span></div>
		         </div>
		         <div class="span3 job-duration">
		            <div class="row-fluid">
		               <div class="span5">
		                  <span data-count="0" class="total-exchange-count"><?php echo $single_job->get_job_start_time(); ?></span>
		                  <div>
		                    <?php echo $single_job->get_job_start_time_ampm() ?>
		                  </div>
		               </div>
		               <div class="span2">
		                  <b class="time-bold">to</b>
		               </div>
		               <div class="span5">
		                  <span data-count="0" class="total-exchange-count"><?php echo $single_job->get_job_end_time(); ?></span>
		                  <div>
		                    <?php echo $single_job->get_job_end_time_ampm() ?>
		                  </div>
		               </div>
		            </div>
		         </div>
		         <div class="span1 wages">
		            $<?php echo $single_job->get_job_wages(); ?>
		         </div>
		      </div>
		      <div class="span12 expand">
		         <div class="row-fluid jobdesc">
		            <div class="span3 jobsimg"> <img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/></div>
		            <div class="span9 job-details"><?php echo $single_job->get_job_details() ?></div>
		         </div>
		         <hr>
		         <?php /*
		         <div class="row-fluid minyawns-grid">
		            <ul class="thumbnails">
		               <li class="span3">
		                  <div class="thumbnail">
		                     <div class="caption">
		                        <img src="images/profile.jpg" />
		                        <div class="rating">
		                           <a href="#fakelink">
		                           <i class="icon-thumbs-up"></i> 100
		                           </a>
		                           <a href="#fakelink"  class="icon-thumbs">
		                           <i class="icon-thumbs-down"></i> 100
		                           </a>
		                        </div>
		                        <h4> Nullam Dolor</h4>
		                        <div class="collage"> University of Washington Civil and Enviormental Engineering </div>
		                        <div class="social-link">
		                           Shenw@uv.edu -<a href="#"> LinkedIn </a> - <a href="#">Behance </a>
		                        </div>
		                        <span class="label label-small">Social media</span>
		                        <span class="label label-small">Marketing </span>
		                        <span class="label label-small">Writing Publishing online</span>
		                        <span class="label label-small">Blogging</span>
		                        <span class="label label-small">Data-entry</span>
		                        <span class="label label-small">Brainstorming</span>
		                        <span class="label label-small">Documentdrafting</span>
		                        <hr>
		                        <div class="dwn-btn">
		                           <div class="onoffswitch">
		                              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
		                              <label class="onoffswitch-label" for="myonoffswitch">
		                                 <div class="onoffswitch-inner"></div>
		                                 <div class="onoffswitch-switch"></div>
		                              </label>
		                           </div>
		                        </div>
		                     </div>
		                  </div>
		               </li>
		            </ul>
		         </div>
		         <hr class="border-color">
		         <img src="images/bottom-arrow.png" class="bottom-arrow" />
		         <a href="#fakelink" class="btn btn-medium btn-block green-btn btn-success ">Confirm & Hire</a>
		      </div>
		      */ ?>
		   </div>
		</div>
                    <div id="edit-job-form" class="" style="display:none;">
<!--                        <div id="success_msg" style="background-color:greenyellow;display:none;">Job added</div>-->
                        <div id="ajax-load" class="modal_ajax_large" style="display:none"></div>
                        <form id="job-form" class="form-horizontal">
<input type="hidden" value="" id="user_skills"></input>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Tasks</label>
                                <div class="controls ">
                                    <input type="text" id="job_task" name="job_task" value="<?php echo get_the_title() ?>" placeholder="" class="span3">
                                </div>
                            </div>
                            <div class="control-group small float-left ">
                                <label class="control-label" for="inputtask">Start</label>
                                <div class="controls">
                                    <div class="input-prepend input-datepicker">
                                        <button type="button" class="btn"><span class="fui-calendar"></span></button>
                                        <input type="text" class="span1" name="job_start_date" value="" id="job_start_date">
                                    </div>

                                </div>
                            </div>
                            <div class="input-append bootstrap-timepicker">
                                <input id="job_start_time" type="text" class="timepicker-default input-small" name="job_start_time" >
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
                                        <input type="text"  name="job_end_date" class="span1" value="" id="job_end_date">
                                    </div>
                                </div>

                            </div>
                            <div class="input-append bootstrap-timepicker">
                                <input id="job_end_time" type="text" class="timepicker-default input-small" name="job_end_time">
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                            <div class="clear"></div>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Required</label>
                                <div class="controls ">
                                    <input type="text" name="job_required_minyawns" id="job_required_minyawns" placeholder="" value="<?php echo $single_job->get_job_required_minyawns(); ?>" class="spinner">
                                </div>
                            </div>


                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Wages</label>

                                <div class="controls small">
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-dollar"></i></span>
                                        <input class="span2" id="job_wages" type="text" name="job_wages" value="<?php echo $single_job->get_job_wages(); ?>">
                                    </div>
                                </div>


                            </div>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Location</label>
                                <div class="controls ">
                                    <input type="text" name="job_location" id="job_location" value="<?php echo $single_job->get_job_location(); ?>" placeholder="" class="span3">
                                </div>
                            </div>

                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Tags</label>
                                <div class="controls ">
                                    <input  name="job_tags" id="job_tags" value="" placeholder="" class="tm-input tagsinput">
                               </div>
                            </div>
                            <div class="control-group small">
                                <label class="control-label" for="inputtask">Details</label>
                                <div class="controls ">
                                    <textarea class="span6" name="job_details" rows="10" id="job_details" cols="4" placeholder="" style="height:70px;"><?php echo $single_job->get_job_details() ?></textarea>
                                </div>
                            </div>
                            <hr>
                            <a id="add-job" href="#" class="btn btn-large btn-block btn-inverse span2" >Submit</a>
                            <div class="clear"></div>
                        </form>
                    </div>
	</div>
</div>
<?php
get_footer();