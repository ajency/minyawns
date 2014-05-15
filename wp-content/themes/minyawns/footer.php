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
	<ul class="footer_menu">
		<li><a href="<?php echo site_url(); ?>/about/">About</a></li>
		<li><a href="<?php echo site_url(); ?>/terms-of-service/">Terms</a></li>
		<li><a href="<?php echo site_url(); ?>/privacy/">Privacy</a></li>
		<li><a href="<?php echo site_url(); ?>/helpfaqs/">Help</a></li>
		<li><a href="<?php echo site_url(); ?>/careers/">Careers</a></li>
		<li><a href="<?php echo site_url(); ?>/contact/">Contact</a></li>
	</ul>
	
	<div class="social-icon">
		<a href="https://twitter.com/Minyawns" class="btn btn-info" target="_blank"><i class="icon-twitter" ></i> <span> &nbsp;Follow Us</span></a>
		&nbsp;&nbsp;<a href="https://www.facebook.com/minyawn" class="btn btn-danger"  target="_blank"><i class="icon-facebook" ></i> &nbsp;<span> Follow Us</span></a>

</div>

	
	<div class="site_link">All rights reserved 2013 @ Minyawns</div>
</footer>

</body>
</html>
