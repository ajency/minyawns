

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
<script type="text/javascript">
//jQuery(document).ready(function($) {
// jQuery('.carousel').carousel({
//	interval: 2000
//		})
//		  });
</script>
<footer>
<span class="footer-top"></span>
	<ul class="footer_menu">
		<li><a href="<?php echo site_url(); ?>/about/">About</a></li>
		<li><a href="<?php echo site_url(); ?>/terms-of-service/">Terms</a></li>
		<li><a href="<?php echo site_url(); ?>/privacy/">Privacy</a></li>
		<li><a href="<?php echo site_url(); ?>/helpfaqs/">Help</a></li>
		<li><a href="<?php echo site_url(); ?>/careers/">Careers</a></li>
		<li><a href="<?php echo site_url(); ?>/contact/">Contact</a></li>
	</ul>
	<?php /* commented  on 4sep2013 
	<div class="social-icon">
		<a href="#"><img
			src="<?php echo get_template_directory_uri() ?>/images/twiiter.png" />
		</a>&nbsp;&nbsp;<a href="#"><img
			src="<?php echo get_template_directory_uri() ?>/images/facebook.png" />
		</a>
	</div>
	*/?>
	<div class="site_link">All rights reserved 2013 @ Minyawns</div>
</footer>

</body>
</html>
