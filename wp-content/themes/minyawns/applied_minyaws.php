		<br /><br />
		<div class="row-fluid minyawns-grid">
            <ul class="thumbnails">
            <?php foreach($minyawn_job->minyawns as $minyawn): ?>
               <li class="span3">
                  <div class="thumbnail">
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
                        <?php foreach($minyawn['user_skills'] as $skill): ?>
                        <span class="label label-small"><?php echo $skill ?></span>
                        <?php endforeach; ?>
                        <hr>
                        <div class="dwn-btn">
                           <div class="onoffswitch">
                              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="<?php echo $minyawn['user_login']?>" checked>
                              <label class="onoffswitch-label" for="<?php echo $minyawn['user_login']?>">
                                 <div class="onoffswitch-inner"></div>
                                 <div class="onoffswitch-switch"></div>
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
               </li>
               <?php endforeach; ?>
            </ul>
         </div>
         <hr class="border-color">
         <img class="bottom-arrow" src="<?php echo get_template_directory_uri() ?>/images/bottom-arrow.png">
         <a href="#fakelink" class="btn btn-medium btn-block green-btn btn-success ">Confirm & Hire</a>
 