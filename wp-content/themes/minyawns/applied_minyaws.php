 
<div class="row-fluid minyawns-grid">
    <ul class="thumbnails">
        <?php  
            foreach ($minyawn_job->minyawns as $minyawn):
               
                ?>
                <li id="hire-thumb<?php echo $minyawn['user_id'] ?>" <?php if ($minyawn['user_job_status'] == "hired") { ?>class="span3 minyans-select" <?php } else { ?>class="span3" <?php } ?>>
                    <div class="thumbnail " >
                        <div class="caption">
                            <?php if ($minyawn['image'] !== false): ?>
                                <img src="<?php echo $minyawn['image']; ?>" />
                            <?php else : ?>
                                <?php echo get_avatar($minyawn['user_email'], 168); ?>
        <?php endif; ?>
                            <div class="rating">
                                <a href="#fakelink">
                                    <i class="icon-thumbs-up"></i> <?php echo $minyawn['rate_like']; ?>
                                </a>
                                <a href="#fakelink"  class="icon-thumbs">
                                    <i class="icon-thumbs-down"></i> <?php echo $minyawn['rate_dislike']; ?>
                                </a>
                            </div>
                            <h4> <?php echo $minyawn['profile_name']; ?></h4>
                            <div class="collage"> <?php echo $minyawn['college']; ?> </div>
                            <div class="social-link">
                            <?php echo $minyawn['user_email']; ?> -<a href="<?php echo $minyawn['linkedin']; ?>" target="_BLANK"> <?php echo $minyawn['linkedin']; ?> </a> 
                            </div>
                            <?php if (is_array($minyawn['user_skills'])) {
                                foreach ($minyawn['user_skills'] as $skill): ?>
                                    <span class="label label-small"><?php echo $skill ?></span>
            <?php endforeach;
        } ?>
                            <hr>

<?php
	  if(get_user_role() == "employer"){
                                 ?>

                            <div class="dwn-btn">
                                <div class="roundedTwo">
                                    <input type="checkbox" id="roundedTwo<?php echo $minyawn['user_id'] ?>" value="<?php echo $minyawn['user_id'] ?>"  data-user-id="<?php echo $minyawn['user_id'] ?>" data-job-id="<?php echo $minyawn['user_to_job'] ?>"    name="confirm-miny[]"  id="<?php echo $minyawn['user_login'] ?>" <?php if ($minyawn['user_job_status'] == "hired") { ?>checked  disabled class="minyans-select" <?php } ?> />
                                    <label for="roundedTwo<?php echo $minyawn['user_id'] ?>"> </label>Select Donec id elit
                                </div>
                            </div>
                      <?php }?>


                        </div>
                    </div>
                </li>
    <?php endforeach;
    
    function show_single_user($jobId,$minyawn_job){
?>
            <li class="span3">
                <div class="thumbnail">

                    <div class="caption">
                        <img src="<?php echo get_template_directory_uri() ?>/images/profile.png"/>
                        <div class="rating">
                            <a href="#fakelink">
                                <i class="icon-thumbs-up"></i> 0
                            </a>

                            <a href="#fakelink"  class="icon-thumbs">
                                <i class="icon-thumbs-down"></i> 0
                            </a>
                        </div>
                         <?php 
                      if(get_user_role() == "minyawn"){ 
                         if($minyawn_job->check_minyawn_job_status($jobId) == 3){ ?>
                                
                                <a href="#" class="btn btn-medium btn-block btn-success red-btn">You are hired</a>
                                
                         <?php }else if($minyawn_job->check_minyawn_job_status($jobId) == 0 ) : ?>
			         	<a href="#" id="apply-job" class="btn btn-medium btn-block  btn-primary" data-action="apply" data-job-id="<?php echo $minyawn_job->ID; ?>">Apply</a>
			         <?php elseif($minyawn_job->check_minyawn_job_status($jobId) == 2 ) : ?>
			         	<a href="#" id="unapply-job" class="btn btn-medium btn-block  btn-danger red-btn" data-action="unapply" data-job-id="<?php echo $minyawn_job->ID; ?>">Unapply</a>
			         <?php elseif($minyawn_job->check_minyawn_job_status($jobId) == 1 ) : ?>
			         	<a href="#" class="btn btn-medium btn-block btn-success red-btn">Requirement Complete</a>
			         <?php endif;
                      }
                                 ?>
                        <div class="collage">"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</div>


                        <hr>
                        <div class="dwn-btn">
                            
                        </div>
                    </div>
                </div>
            </li>
    <?php } ?>

    </ul>
</div>
<?php if(get_user_role() == "employer" && $minyawn['user_job_status'] != "hired") { ?>
<a href="#fakelink" id="confirm-hire"  class="btn btn-medium btn-block green-btn btn-success" <?php if(count($minyawn_job->minyawns) == 0){?>style="display:none" <?php } ?> >Confirm & Hire</a>
<span class='load_ajax4' style="display:none"></span>
<?php } ?>