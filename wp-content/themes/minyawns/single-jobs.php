<?php
get_header();

global $minyawn_job;
$minyawn_job = new Minyawn_Job(get_the_ID());
var_dump($minyawn_job);
?>
<div class="container">
	<div class="tab-content">
		<div class="tab-pane active" id="tab2">
		   <div class="breadcrumb-text">
		      <p>
		         <a href="myjobs.html">My Jobs</a>
		         <a href="#"><?php echo get_the_title() ?></a>
		      </p>
		   </div>
		   <div class="row-fluid list-jobs single-jobs">
		      <div class="span12 jobs-details">
		         <div class="span2 img-logo"> <img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/> </div>
		         <div class="span3 minyawns-select">
		            <span>0</span>
		            <div><b>Minyawns Have Applied</b></div>
		         </div>
		         <div class="span3 jobs-date">
		            <div class="posteddate"> Posted Date : <span><?php echo get_job_posted_date(); ?></span></div>
		            <div class="jobsdate"> Jobs Date : <span><?php echo get_job_date(); ?></span></div>
		         </div>
		         <div class="span3 job-duration">
		            <div class="row-fluid">
		               <div class="span5">
		                  <span data-count="0" class="total-exchange-count">11:00</span>
		                  <div>
		                     pm
		                  </div>
		               </div>
		               <div class="span2">
		                  <b class="time-bold">to</b>
		               </div>
		               <div class="span5">
		                  <span data-count="0" class="total-exchange-count">2:00</span>
		                  <div>
		                     pm
		                  </div>
		               </div>
		            </div>
		         </div>
		         <div class="span1 wages">
		            $100
		         </div>
		      </div>
		      <div class="span12 expand">
		         <div class="row-fluid jobdesc">
		            <div class="span3 jobsimg"> <img src="<?php echo get_template_directory_uri() ?>/images/livefyre-logo.png"/></div>
		            <div class="span9 job-details"><?php echo get_job_details() ?></div>
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
	</div>
</div>
<?php
get_footer();