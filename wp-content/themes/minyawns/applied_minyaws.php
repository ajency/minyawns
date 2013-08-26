	
		<div class="row-fluid minyawns-grid">
            <ul class="thumbnails">
            <?php foreach($minyawn_job->minyawns as $minyawn): ?>
               <li class="span3 minyans-select">
                  <div class="thumbnail " id="hire-thumb<?php echo $minyawn['user_id']?>">
                     <div class="caption">
                         <?php if($minyawn['image'] !== false): ?>
                        <img src="<?php echo $minyawn['image']; ?>" />
                        <?php else : ?>
                        <?php echo get_avatar($minyawn['user_email'],168); ?>
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
                        <?php  if(isset($minyawn['user_skills'])){foreach($minyawn['user_skills'] as $skill): ?>
                        <span class="label label-small"><?php echo $skill ?></span>
                        <?php endforeach; } ?>
                        <hr>
                        
                          
                               
                              
                              <div class="dwn-btn">
					 <div class="roundedTwo">
						  <input type="checkbox" id="roundedTwo<?php echo $minyawn['user_id']?>" data-user-id="<?php echo $minyawn['user_id']?>" data-job-id="<?php echo $minyawn['user_to_job']?>"    name="confirm-miny[]"  id="<?php echo $minyawn['user_login']?>" <?php if($minyawn['user_job_status'] == "hired"){ ?>checked class="minyans-select" <?php }?> >
						  <label for="roundedTwo<?php echo $minyawn['user_id']?>"> </label>Select Donec id elit
					  </div>
				</div>
                              
                          
           
                     </div>
                  </div>
               </li>
               <?php endforeach; ?>
            </ul>
         </div>
        
         <a href="#fakelink" id="confirm-hire"  class="btn btn-medium btn-block green-btn btn-success ">Confirm & Hire</a>
 