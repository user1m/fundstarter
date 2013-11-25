<?php
/**
 * Sign In
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

global $edd_options;

$post = get_post( $edd_options[ 'login_page' ] );
?>

<div id="login-modal-wrap" class="modal-login modal">
	<h2 class="modal-title"><?php echo esc_attr( $post->post_title ); ?></h2>

	<?php echo apply_filters( 'the_content', $post->post_content ); ?>
</div>