<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Fundify
 * @since Fundify 1.0
 */

global $wp_query;

get_header(); ?>

	<div class="title title-two pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php echo get_search_query(); ?></h1>
			<h3><?php _e( 'Search Results', 'fundify' ); ?></h3>
		</div>
		<!-- / container -->
	</div>
	<div id="content">
		<div class="container">
			<?php if ( $wp_query->query_vars[ 'post_type' ] == 'download' ) : ?>
				<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
						
				<div id="projects" class="none">
					
					<?php if ( have_posts() ) : ?>
						<section>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'campaign' ); ?>
							<?php endwhile; ?>
						</section>

						<?php do_action( 'fundify_loop_after' ); ?>

					<?php else : ?>

						<?php get_template_part( 'no-results', 'index' ); ?>

					<?php endif; ?>
				</div>
			<?php else : ?>
				<div id="main-content">
					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content', get_post_format() ); ?>
						<?php endwhile; ?>

						<?php do_action( 'fundify_loop_after' ); ?>

					<?php else : ?>

						<?php get_template_part( 'no-results', 'index' ); ?>

					<?php endif; ?>
				</div>
				<?php get_sidebar(); ?>
			<?php endif; ?>

		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>