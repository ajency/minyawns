<?php

/**
 * Function to specify the templates for the various emails that go out.
 * @param string $type
 * @return array
 */
function email_template($emailid, $data, $type) {

    switch ($type) {

        case 'user_incomplete_profile_reminder':
            $template = array(
                'hhtml' => email_template_header(),
                'fhtml' => email_template_footer(),
                'subject' => __("[" . get_bloginfo('name') . "] Gentle Reminder.Please complete your profile"),
                'message' => "Hi " . $data . "",
                
            );
            break;
            
        case 'user_activate_reminder':
            $template = array(
                'hhtml' => email_template_header(),
                'fhtml' => email_template_footer(),
                'subject' => __("[" . get_bloginfo('name') . "] Gentle Reminder.Please activate your account".$data['subject']),
                'message' => "Hi " . $data['message'] . "",
                
            );
            break;    
         case 'user_no_activity_reminder':
            $template = array(
                'hhtml' => email_template_header(),
                'fhtml' => email_template_footer(),
                'subject' => __("[" . get_bloginfo('name') . "] Gentle Reminder.No activity since user registration".$data['subject']),
                'message' => "Hi " . $data['message'] . "",
                
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



?>