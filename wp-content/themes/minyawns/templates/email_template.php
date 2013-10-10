<?php

/**
 * Function to specify the templates for the various emails that go out.
 * @param string $type
 * @return array
 */
function email_template($emailid, $data, $type) {

    switch ($type) {
            
        case 'user_activate_reminder':
            $template = array(
                'hhtml' => email_template_header(),
                'fhtml' => email_template_footer(),
                'subject' => get_email_subject($type,$data),
                'message' =>  get_email_msg($type,$data,$emailid)
                
            );
            break;  
        
            
        case 'user_incomplete_profile_reminder':
            	$template = array(
            	'hhtml' => email_template_header(),
            	'fhtml' => email_template_footer(),
            	'subject' => get_email_subject($type,$data),
            	'message' => get_email_msg($type,$data,$emailid)
            
            	);
            	break;
              
         case 'user_no_activity_reminder':
            $template = array(
                'hhtml' => email_template_header(),
                'fhtml' => email_template_footer(),
                'subject' =>get_email_subject($type,$data),
                'message' => get_email_msg($type,$data,$emailid)
                
            );
            break;    

          case 'employer_jobcompletion_reminder':
            $template = array(
                'hhtml' => email_template_header(),
                'fhtml' => email_template_footer(),
                'subject' => get_email_subject($type,$data),
                'message' => get_email_msg($type,$data,$emailid)
                
            );
            break;   
            
        default:
            $template = array(
                'hhtml' => "",
                'fhtml' => "",
                'subject' => "",
                'message' => "",                
            );
            break;
    }
    return $template;
}
////////////////////////////////////////////////EMAIL TEMPLATE HTML/////////////////////////////////////////////////////

    function email_template_header() {

        return '<div style=" width:600px; margin:auto;background:url(' . site_url() . '/wp-content/themes/minyawns/images/pattern-bg.png);border: 5px solid #CCC;">
			<!-- header --->
			<div style="background-color: rgba(0, 0, 0, 0.39);padding: 6px;">
			<img src="' . site_url() . '/wp-content/themes/minyawns/images/logo.png" />
					</div>
					<!--End of Header -->

					<!--Message -->

					<!--End Of Message -->

					<!--Footer -->
					<div style="margin-top:20px;">
					<div style="width:512px; margin:auto;">
					<div style=" font-size: 12px; line-height: 22px; ">';
    }

    function email_template_footer() {

        return '<br/><br/>Regards,<br/>
			Minyawns Team<br/><br/>
			</div>
				

			</div>
			<div style="clear:both;"></div>

			<div style="background:#f8f8f8;clear:both;margin:5px 5px 5px 5px;height:40px;padding-left: 10px;">
			
							<br>

							<div style="background:url(' . site_url() . '/wp-content/themes/minyawns/images/arro-up.png)repeat-x;clear:both;margin:5px 5px 5px 5px;height:80px;padding-left: 10px;padding: 1px;">

									<h5 style="color:#ffffff;text-align:center;">Replies to this message are not monitored. Our Customer Service team is available to assist you here: </h5>
									<a href="mailto:support@minyawns.com">support@minyawns.com</a>
									</div>
									</div>
									<!--End of footer -->
									</div>';
    }
    
    
    

/**
*
* @param string $type
* @param array $data
* @return string email subject
*/
    
function get_email_subject($type,$data)
{
    
	switch($type)
    {
    
    	case 'user_activate_reminder'			:	if($data['role']=="employer")
    												{
											    		$email_sub = __("[" . get_bloginfo('name') . "] - Reminder to activate your profile");
											    	}
											    	else if($data['role']=="minyawn")
											    	{
											    		$email_sub = __("[" . get_bloginfo('name') . "] - Reminder to activate your profile");
											    	}
    												return $email_sub;
    			
    	case 'user_incomplete_profile_reminder'	:
										    		if($data['role']=="employer")
										    		{
										    			$email_sub = __("[" . get_bloginfo('name') . "] - Attract more applicants with a complete profile");
										    		}
										    		else if($data['role']=="minyawn")
										    		{
										    			$email_sub = __("[" . get_bloginfo('name') . "] - Attract more job offers with a complete profile.");
										    		} 	
    		
    		
    		
    												return $email_sub;
    			
    	case 'user_no_activity_reminder'		:	if($data['role']=="employer")
    												{
    													$email_sub = __("[" . get_bloginfo('name') . "] - Take the next step - Add jobs");
    												}
    												else if($data['role']=="minyawn")
    												{	
    													$email_sub = __("[" . get_bloginfo('name') . "] - Take the plunge - Apply for a job");
    												}
    			
    			
    												return $email_sub;
    
    	case 'employer_jobcompletion_reminder'	:	$email_sub = __("[" . get_bloginfo('name') . "] - Task Completed!");
    												return $email_sub;
    
    
  	}//end switch($type)
}//end function get_email_subject($type,$data)

/**
 * 
 * @param string $type
 * @param array $data
 * @param string $emailid
 * @return string message body
 */
    
  function get_email_msg($type, $data, $emailid)
  {
  	switch($type)
  	{
  		
  		case 'user_activate_reminder'			:	if($data['role']=="employer")
										  			{
										  				$email_msg = "Hi ".$data['display_name'].",<br/><br/>
										
														You have not activated your profile yet. There are many minions waiting to complete your tasks,
										  				so please click 
										  				<a href='".site_url()."/newuser-verification/?action=ver&key=".$data['user_activation_key']."&email=" . $emailid . "'>here</a> to activate your profile.<br/><br/>
																 			
														Let us know if you had any issues activating your account on <a href='mailto:support@minyawns.com'>support@minyawns.com</a><br/><br/>";
										  															
										  													
										  			}
										  			else if($data['role']=="minyawn")
										  			{
										  				$email_msg = "Hi ".$data['display_name'].",<br/><br/>

														You have not activated your profile yet. Many opportunities await, and lost time equals lost opportunities,
										  				so please click <a href='".site_url()."/newuser-verification/?action=ver&key=".$data['user_activation_key']."&email=" . $emailid . "'>here</a>
										  				to activate your profile.<br/><br/>

														Let us know if you had any issues activating your account on <a href='mailto:support@minyawns.com'>support@minyawns.com</a>";	
										  				
										  			}
													return $email_msg;
													
		case 'user_incomplete_profile_reminder' :	
													if($data['role']=="employer")
													{
														$email_msg = "Hi ".$data['display_name'].", <br/><br/>
																
														We noticed that your profile is incomplete. Complete profiles usually get more applicants, 
														giving you the opportunity to choose the most relevant minions for your task.<br/><br/> 
																
														You can edit your profile by visiting <a href='http://www.minyawns.com/profile/'>http://www.minyawns.com/profile/</a><br/>
														(You should be logged in to edit your profile)<br/><br/>

														Let your minions run errands for you while you think of more important things to do.<br/><br/>

														If you have any issues, please feel free to drop us an email on <a href='mailto:support@minyawns.com'>support@minyawns.com</a><br/><br/>																
														";
													}
													else if($data['role']=="minyawn")
													{
														$email_msg = "Hi ".$data['display_name'].", <br/><br/>
														 
														We noticed that your profile is incomplete. Complete profiles usually get more attention from employers, 
														making you a more eligible candidate. Create more opportunities for yourself to earn extra money, 
														and bag amazing ratings and reviews from your employers.<br/><br/>
														
														You can edit your profile by visiting <a href='http://www.minyawns.com/profile/'>http://www.minyawns.com/profile/</a><br/>
														(You should be logged in to edit your profile)<br/><br/>														
														
														If you have any issues, please feel free to drop us an email on <a href='mailtp:support@minyawns.com'>support@minyawns.com</a><br/><br/>";
														
														
													}
													return $email_msg;
													
		case 'user_no_activity_reminder'		:	if($data['role']=="employer")
													{
														$email_msg = "Hi ".$data['display_name'].", <br/><br/> 
														
														We noticed that you haven’t added any jobs since you signed up. Please let us know if you are facing any difficulties,  
														we are happy to be of assistance.<br/><br/>
																
														We believe that whatever job you need to get done is important so delegate now, why procrastinate. 
														Just hire a minion while you relax and let your minions work for you.<br/><br/>
																
														We can help you get your job online now. Just email us on <a href='mailto:support@minyawns.com'>support@minyawns.com</a> and 
														we will get your job posted to the site.<br/><br/>";
														
														
													}
													else if($data['role']=="minyawn")
													{
														$email_msg =  "Hi ".$data['display_name'].", <br/><br/>
														We noticed that you haven’t applied to any jobs since you signed up. Please let us know
														if you are facing any difficulties, we are happy to assist you.<br/><br/>
																
														At Minyawns we understand that your time is precious and you may not want to commit to a full time or a part time job just yet. 
														That is why you can apply to any jobs with time, pay and errands that are suitable for you.<br/><br/> 

														To apply you have to log in to your account, click on “Browse Jobs” and apply to whatever catches your fancy.<br/><br/>

														If you are facing difficulties applying for jobs feel free to email us on <a href='support@minyawns.com'>support@minyawns.com</a>.<br/><br/>";
													}
													
													return $email_msg;
													
		case 'employer_jobcompletion_reminder'	:	$email_msg = "Hi ".$data['display_name'].",<br/><br/>				 

														Congratulations, your task '".$data['job_name']."'  has been completed! It’s time to rate and write a review for 
														the minion who executed your task. To rate your minion simply click on the thumbs up or thumbs down icon on the bottom left corner 
														of your job description.<br/><br/>

														If you have any issues, please feel free to drop us an email on <a href='mailto:support@minyawns.com'>support@minyawns.com</a><br/><br/>
				
		
		";
													return $email_msg;
  	}//end switch($type)
  			
  } //end function get_email_msg($type, $data, $emailid)
  
  
?>