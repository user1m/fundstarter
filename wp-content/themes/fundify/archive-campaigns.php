<?php
/**
 * Campaigns
 *
 * @package Fundify
 * @since Fundify 1.0
 */

get_header(); ?>

	<div class="title pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<?php if ( is_post_type_archive( 'download' ) ) : ?>
				<h1><?php printf( __( 'Discover %s', 'fundify' ), edd_get_label_plural() ); ?></h1>
			<?php elseif ( is_tax( 'download_category' ) ) : ?>
				<?php
					global $wp_query;
					$term = $wp_query->get_queried_object();
					$title = $term->name;
				?>
				<h1><?php echo $title; ?></h1>
			<?php endif; ?>
		</div>
		<!-- / container -->
	</div>
	<div id="content">
		<div class="container">
			
			<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
			<?php locate_template( array( 'content-campaign-sort.php' ), true ); ?>

			<div id="projects">
				<section>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'campaign' ); ?>
					<?php endwhile; ?>
				</section>

				<?php do_action( 'fundify_loop_after' ); ?>
			</div>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>