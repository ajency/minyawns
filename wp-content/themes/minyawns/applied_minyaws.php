<?php /*<link rel="stylesheet" type="text/css" href="http://localhost/minyawns/wp-content/themes/minyawns/adaptive_paypal/samples/Common/sdk.css" />
<script type="text/javascript" src="http://localhost/minyawns/wp-content/themes/minyawns/adaptive_paypal/samples/Common/sdk_functions.js"></script>
<script type="text/javascript" src="http://localhost/minyawns/wp-content/themes/minyawns/adaptive_paypal/samples/Common/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="http://localhost/minyawns/wp-content/themes/minyawns/adaptive_paypal/samples/Common/jquery.qtip-1.0.0-rc3.min.js"></script>
*/?>
 <script src="https://www.paypalobjects.com/js/external/dg.js" type="text/javascript"></script>
<?php	
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url = dirname('http://' . $serverName . ':' . $serverPort . $_SERVER['REQUEST_URI']);
	$returnUrl = $url . "/adaptive_paypal/samples/ExecutePayment.php";
	$cancelUrl =  $url . "/";
?>
			<form action="<?php echo site_url().'/adaptive-payment/'; ?>" method="post">
				<input type='hidden' name="actionType" id="actionType" value="PAY" readonly="readonly"/>
				<input type='hidden' name="returnUrl" id="returnUrl" value="<?php echo $returnUrl;?>" />			
				<input type='hidden' name="cancelUrl" id="cancelUrl" value="<?php echo $cancelUrl;?>" />
				<input type='hidden' name="currencyCode"  id="currencyCode"value="USD" />
				<input type="hidden" name="receiverEmail[]" id="receiveremail_0" value="platfo_1255612361_per@gmail.com">
				<input type="hidden" name="receiverAmount[]" id="amount_0" value="1.0" class="smallfield">
				<?php /*<input type="submit" name = "submitBtn" value="Submit" />*/ ?>
				<input type='hidden' name='hdn_jobwages' id='hdn_jobwages' value='<?php echo $minyawn_job->get_job_wages(); ?>' />
		
				
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
                            <?php if (isset($minyawn['user_skills'])) {
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
                                    <input type="checkbox" id="roundedTwo<?php echo $minyawn['user_id'] ?>" value="<?php echo $minyawn['user_id'] ?>"  data-user-id="<?php echo $minyawn['user_id'] ?>" data-job-id="<?php echo $minyawn['user_to_job'] ?>"    name="confirm-miny[]"  id="<?php echo $minyawn['user_login'] ?>" <?php if ($minyawn['user_job_status'] == "hired") { ?> checked disabled class="minyans-select" <?php } ?> >
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
 </form>
<a href="#confirminyawn" role="button" class="btn" data-toggle="modal">confirmhire</a>

<?php if(get_user_role() == "employer" && $minyawn['user_job_status'] != "hired") { ?>
<a href="#fakelink" id="confirm-hire"  class="btn btn-medium btn-block green-btn btn-success" <?php if(count($minyawn_job->minyawns) == 0){?>style="display:none" <?php } ?> >Confirm & Hire</a>
<span class='load_ajax4' style="display:none"></span>
<?php } ?>

