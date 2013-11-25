<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Fundify
 * @since Fundify 1.0
 */

get_header(); ?>

	<div class="title title-two pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php _e( '404!', 'fundify' ); ?></h1>
			<h3><?php _e( 'Oops! That page can&rsquo;t be found.', 'fundify' ); ?></h3>
		</div>
		<!-- / container -->
	</div>
	<div id="content">
		<div class="container">
			<div id="main-content">
				<?php get_template_part( 'no-results', 'index' ); ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>