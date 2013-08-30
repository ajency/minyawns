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
	/*$returnUrl = $url . "/adaptive_paypal/samples/ExecutePayment.php";
	$cancelUrl =  $url . "/";
	*/
	
	$returnUrl = get_permalink( $post->ID ) ;
	$cancelUrl =  get_permalink( $post->ID );
	
	//$Path=site_$_SERVER['REQUEST_URI'];
	 
	
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
         <a href="<?php echo site_url() ?>/profile/<?php echo $minyawn['user_id'] ?>" target="_blank">
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
	  if(is_job_owner(get_user_id(),$minyawn['user_to_job']) ==  1){
                                 ?>

                            <div class="dwn-btn">
                                <div class="roundedTwo">
                                    <input type="checkbox" id="roundedTwo<?php echo $minyawn['user_id'] ?>" value="<?php echo $minyawn['user_id'] ?>"  data-user-id="<?php echo $minyawn['user_id'] ?>" data-job-id="<?php echo $minyawn['user_to_job'] ?>"    name="confirm-miny[]"  id="<?php echo $minyawn['user_login'] ?>" <?php if ($minyawn['user_job_status'] == "hired") { ?> checked disabled class="minyans-select" <?php } ?> >
                                    <label for="roundedTwo<?php echo $minyawn['user_id'] ?>"> </label>Select This Minyawn
                                </div>
                            </div>
                      <?php }?>


                        </div>
                            
                    </div>
                   
                </li>
                 </a>
    <?php endforeach;
    ?>


    </ul>
</div>
 </form>


<?php if(is_job_owner(get_user_id(),$minyawn['user_to_job']) ==  1 && $minyawn['user_job_status'] != "hired") { ?>
<span class='load_ajaxconfirm' style="display:none"></span>
<a href="#confirminyawn" id="confirm-hire" data-toggle="modal" class="btn btn-medium btn-block green-btn btn-success" <?php if(count($minyawn_job->minyawns) == 0){?>style="display:none" <?php } ?> >Confirm & Hire</a>

<?php } ?>

