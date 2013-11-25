<?php
/**
 * Template Name: New This Week
 *
 * This should be used in conjunction with the Fundify plugin.
 *
 * @package Fundify
 * @since Fundify 1.3
 */

$thing_args = array(
	'post_type' => array( 'download' )
);

if ( is_page_template( 'page-templates/new-this-week.php' ) ) {
	$thing_args[ 'w' ] = date( 'W' );
} else { 
	$thing_args[ 'meta_key' ]   = '_campaign_featured';
	$thing_args[ 'meta_value' ] = 1;
}

$things = new WP_Query( $thing_args );

get_header(); 
?>

	<div class="title pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php the_title(); ?></h1>
		</div>
		<!-- / container -->
	</div>

	<div id="content">
		<div class="container">
			
			<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
			<?php locate_template( array( 'content-campaign-sort.php' ), true ); ?>

			<div id="projects">
				<section>
					<?php if ( $things->have_posts() ) : ?>

						<?php while ( $things->have_posts() ) : $things->the_post(); ?>
							<?php get_template_part( 'content', 'campaign' ); ?>
						<?php endwhile; ?>

						<?php do_action( 'fundify_loop_after' ); ?>

					<?php else : ?>

						<?php get_template_part( 'no-results', 'index' ); ?>

					<?php endif; ?>
				</section>
			</div>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>