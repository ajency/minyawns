<?php
/**
 * Core component CSS & JS.
 *
 * @package ActivityNotifications
 * @subpackage Core
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load the JS for "Are you sure?" .confirm links.
 */
function ajan_core_confirmation_js() {
	if ( is_multisite() && ! ajan_is_root_blog() ) {
		return false;
	}

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'ajan-confirm', activitynotifications()->plugin_url . "ajan-core/js/confirm{$min}.js", array( 'jquery' ), ajan_get_version() );

	wp_localize_script( 'ajan-confirm', 'AJAN_Confirm', array(
		'are_you_sure' => __( 'Are you sure?', 'ajency-activity-and-notifications' ),
	) );

}
add_action( 'wp_enqueue_scripts',    'ajan_core_confirmation_js' );
add_action( 'admin_enqueue_scripts', 'ajan_core_confirmation_js' );


/**
 * Load JS files.
 */
function ajan_core_enqueue_js() {
  wp_register_script('activity-stream-module', activitynotifications()->plugin_url . "ajan-marionete-activity-stream/dist/aj-activity-stream.js", 
  					array(), ajan_get_version() );
	
wp_localize_script( 'activity-stream-module', 'AJANSITEURL', site_url());
wp_localize_script( 'activity-stream-module', 'NOAVATAR',  activitynotifications()->plugin_url . "ajan-marionete-activity-stream/img/non-avatar.jpg");
		

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'ajan-interface', activitynotifications()->plugin_url . "interface/interface.js", array( 'jquery' ), ajan_get_version() );
	wp_localize_script( 'ajan-interface', 'AJANPLUGINPATH', activitynotifications()->plugin_url. "interface/");
	wp_localize_script( 'ajan-interface', 'BUST', date('dmyhis'));
	wp_localize_script( 'ajan-interface', 'ACTIVITY_NONCE_STRING',  wp_create_nonce("ACTIVITY_NONCE_STRING")); 
 
 	wp_register_style('activity-theme-one-css', activitynotifications()->plugin_url . "ajan-marionete-activity-stream/css/activity-theme-one-css.css", array(), null);
  wp_register_style('activity-theme-two-css', activitynotifications()->plugin_url . "ajan-marionete-activity-stream/css/activity-theme-two-css.css", array(), null);
  
}
add_action( 'wp_enqueue_scripts',    'ajan_core_enqueue_js' );

/**
 * Enqueues jCrop library and hooks BP's custom cropper JS.
 */
function ajan_core_add_jquery_cropper() {
	wp_enqueue_style( 'jcrop' );
	wp_enqueue_script( 'jcrop', array( 'jquery' ) );
	add_action( 'wp_head', 'ajan_core_add_cropper_inline_js' );
	add_action( 'wp_head', 'ajan_core_add_cropper_inline_css' );
}

/**
 * Output the inline JS needed for the cropper to work on a per-page basis.
 */
function ajan_core_add_cropper_inline_js() {

	// Bail if no image was uploaded
	$image = apply_filters( 'ajan_inline_cropper_image', getimagesize( ajan_core_avatar_upload_path() . activitynotifications()->avatar_admin->image->dir ) );
	if ( empty( $image ) )
		return;

	//
	$full_height = ajan_core_avatar_full_height();
	$full_width  = ajan_core_avatar_full_width();

	// Calculate Aspect Ratio
	if ( !empty( $full_height ) && ( $full_width != $full_height ) ) {
		$aspect_ratio = $full_width / $full_height;
	} else {
		$aspect_ratio = 1;
	}

	// Default cropper coordinates
	$crop_left   = round( $image[0] / 4 );
	$crop_top    = round( $image[1] / 4 );
	$crop_right  = $image[0] - $crop_left;
	$crop_bottom = $image[1] - $crop_top; ?>

	<script type="text/javascript">
		jQuery(window).load( function(){
			jQuery('#avatar-to-crop').Jcrop({
				onChange: showPreview,
				onSelect: showPreview,
				onSelect: updateCoords,
				aspectRatio: <?php echo $aspect_ratio; ?>,
				setSelect: [ <?php echo $crop_left; ?>, <?php echo $crop_top; ?>, <?php echo $crop_right; ?>, <?php echo $crop_bottom; ?> ]
			});
			updateCoords({x: <?php echo $crop_left; ?>, y: <?php echo $crop_top; ?>, w: <?php echo $crop_right; ?>, h: <?php echo $crop_bottom; ?>});
		});

		function updateCoords(c) {
			jQuery('#x').val(c.x);
			jQuery('#y').val(c.y);
			jQuery('#w').val(c.w);
			jQuery('#h').val(c.h);
		}

		function showPreview(coords) {
			if ( parseInt(coords.w) > 0 ) {
				var fw = <?php echo $full_width; ?>;
				var fh = <?php echo $full_height; ?>;
				var rx = fw / coords.w;
				var ry = fh / coords.h;

				jQuery( '#avatar-crop-preview' ).css({
					width: Math.round(rx * <?php echo $image[0]; ?>) + 'px',
					height: Math.round(ry * <?php echo $image[1]; ?>) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
			}
		}
	</script>

<?php
}

/**
 * Output the inline CSS for the BP image cropper.
 *
 * @package ActivityNotifications Core
 */
function ajan_core_add_cropper_inline_css() {
?>

	<style type="text/css">
		.jcrop-holder { float: left; margin: 0 20px 20px 0; text-align: left; }
		#avatar-crop-pane { width: <?php echo ajan_core_avatar_full_width() ?>px; height: <?php echo ajan_core_avatar_full_height() ?>px; overflow: hidden; }
		#avatar-crop-submit { margin: 20px 0; }
		.jcrop-holder img,
		#avatar-crop-pane img,
		#avatar-upload-form img,
		#create-group-form img,
		#group-settings-form img { border: none !important; max-width: none !important; }
	</style>

<?php
}

/**
 * Define the 'ajaxurl' JS variable, used by themes as an AJAX endpoint.
 *
 * @since ActivityNotifications (1.1.0)
 */
function ajan_core_add_ajax_url_js() {
?>

	<script type="text/javascript">var ajaxurl = '<?php echo ajan_core_ajax_url(); ?>';</script>

<?php
}
add_action( 'wp_head', 'ajan_core_add_ajax_url_js' );

/**
 * Get the proper value for BP's ajaxurl.
 *
 * Designed to be sensitive to FORCE_SSL_ADMIN and non-standard multisite
 * configurations.
 *
 * @since ActivityNotifications (1.7.0)
 *
 * @return string AJAX endpoint URL.
 */
function ajan_core_ajax_url() {
	return apply_filters( 'ajan_core_ajax_url', admin_url( 'admin-ajax.php', is_ssl() ? 'admin' : 'http' ) );
}
