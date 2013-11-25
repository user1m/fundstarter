<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Fundify
 * @since Fundify 1.0
 */
?>

<aside id="sidebar" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>

	<div class="sidebar-widgets">
		<?php dynamic_sidebar(1); ?>
	</div>

	<?php do_action( 'after_sidebar' ); ?>
</aside>