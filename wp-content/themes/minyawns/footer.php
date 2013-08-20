
<footer>
	<hr style="border-top: 1px solid #C7C3C3;">
	<ul class="footer_menu">
		<li><a href="#">About</a></li>
		<li><a href="#">Careers</a></li>
		<li><a href="#">Blog</a></li>
		<li><a href="#">Tech City</a></li>
		<li><a href="#">Directory</a></li>
	</ul>
	<div class="social-icon">
		<a href="#"><img
			src="<?php echo get_template_directory_uri() ?>/images/twiiter.png" />
		</a>&nbsp;&nbsp;<a href="#"><img
			src="<?php echo get_template_directory_uri() ?>/images/facebook.png" />
		</a>
	</div>
	<div class="site_link">All rights reserved 2013 @ Minyawn</div>
</footer>

</div>


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
    $(window).load(function () {
        $(".demo").customScrollbar();
    });
</script>
</body>
</html>
