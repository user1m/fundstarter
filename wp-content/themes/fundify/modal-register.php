<?php
/**
 * Register
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

global $edd_options;

$post = get_post( $edd_options[ 'register_page' ] );
?>

<div id="register-modal-wrap" class="modal-register modal">
	<h2 class="modal-title"><?php echo esc_attr( $post->post_title ); ?></h2>

	<?php echo apply_filters( 'the_content', $post->post_content ); ?>
</div>