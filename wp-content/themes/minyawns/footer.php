<a href="#" class="scrollup">Scroll</a>

<script type="text/javascript">
var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>"
<?php if(isset($_REQUEST['action']))
{
	if($_REQUEST['action']=="invalid_login")
	{
	?>
	jQuery(document).ready(function($){
	jQuery("#btn__login").click();
	jQuery("#div_loginmsg").html("<div class='alert alert-error alert-box' style='padding: 10px 45px 10px 5px;font-size:12px'>  <button type='button' class='close' data-dismiss='alert'>&times;</button>You havent registered with your facebook account/email on Minyawns. Please use Registration form to sign up on Minyawns. </div>");
	})
	<?php 
	}
}
		
?>	
</script>
<?php if(is_page('home')){ ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
 jQuery('.carousel').carousel({
	interval: 2000
		})
		
		  $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        }); 
 
        $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });
		  });
</script>
<?php } ?>
<footer>
<span class="footer-top"></span>
<div class="text-center chs-city">Chosse following city :<a href="#"> Seattle</a>&nbsp; &nbsp;<a href="#">  Fresno</a></div>
	<ul class="footer_menu">
		<li><a href="<?php echo site_url(); ?>/about/">About</a></li>
		<li><a href="<?php echo site_url(); ?>/terms-of-service/">Terms</a></li>
		<li><a href="<?php echo site_url(); ?>/privacy/">Privacy</a></li>
		<li><a href="<?php echo site_url(); ?>/helpfaqs/">Help</a></li>
		<li><a href="<?php echo site_url(); ?>/careers/">Careers</a></li>
		<li><a href="<?php echo site_url(); ?>/contact/">Contact</a></li>
	</ul>
	<br>
	<b class="social-icon">
&nbsp;&nbsp;<a href="https://www.facebook.com/minyawn" target="_blank"> <img src="<?php echo get_template_directory_uri(); ?>/images/social-fb.png" alt="" /></a>  &nbsp;<a href="https://twitter.com/Minyawns"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/social-twitter.png" alt="" /> </a>

</b>

	
	<div class="site_link">All rights reserved 2013 @ Minyawns</div>
</footer>

</body>
</html>
