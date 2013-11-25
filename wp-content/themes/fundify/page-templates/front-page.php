<?php
/**
 * Template Name: Front Page
 *
 * This should be used in conjunction with the Fundify plugin.
 *
 * @package Fundify
 * @since Fundify 1.0
 */

global $wp_query;

get_header(); 
?>

	<div id="home-page-featured">
		<?php
			if ( fundify_is_crowdfunding()  ) :
				$featured = new ATCF_Campaign_Query( array( 
					'posts_per_page' => 'grid' == fundify_theme_mod( 'hero_style' ) ? apply_filters( 'fundify_hero_campaign_grid', 24 ) : 1,
					'meta_query'     => array(
						array(
							'key'     => '_campaign_featured',
							'value'   => 1,
							'compare' => '=',
							'type'    => 'numeric'
						)
					)
				) ); 
			else :
				$featured = new WP_Query( array( 
					'posts_per_page' => 'grid' == fundify_theme_mod( 'hero_style' ) ? apply_filters( 'fundify_hero_campaign_grid', 24 ) : 1
				) ); 
			endif; 
		?>
		<?php if ( 'grid' == fundify_theme_mod( 'hero_style' ) ) : ?>
			<?php for ( $i = 0; $i < 3; $i++ ) : shuffle( $featured->posts ); ?>
			<ul>
				<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></li>
				<?php endwhile; ?>
			</ul>
			<?php endfor; ?>
		<?php else : ?>
			<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
				<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fullsize' ); ?>
				<a href="<?php the_permalink(); ?>" class="home-page-featured-single"><img src="<?php echo $thumbnail[0]; ?>" /></a>
			<?php endwhile; ?>
		<?php endif; ?>

		<h1>
			<?php 
				$string = fundify_theme_mod( 'hero_text' ); 
				$lines = explode( "\n", $string );
			?>
			<span><?php echo implode( '</span><br /><span>', $lines ); ?></span>
		</h1>
		<!-- / container -->
	</div>
<!-- / Claudius -->
<div style="text-align:center; width:560; height:100; margin:10px auto;">
<?php echo do_shortcode('[fve]http://youtu.be/BrMm6IEd6K8[/fve]'); ?>
</div>
<!-- / Claudius -->
	<div id="content">
		<div class="container">
			
			<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
			<?php locate_template( array( 'content-campaign-sort.php' ), true ); ?>

			<div id="projects">
				<section>
					<?php 
						if ( fundify_is_crowdfunding()  ) :
							$wp_query = new ATCF_Campaign_Query( array(
								'paged' => ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 )
							) );
						else :
							$wp_query = new WP_Query( array(
								'posts_per_page' => get_option( 'posts_per_page' ),
								'paged'          => ( get_query_var('page') ? get_query_var('page') : 1 )
							) );
						endif;

						if ( $wp_query->have_posts() ) :
					?>

						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
							<?php get_template_part( 'content', fundify_is_crowdfunding() ? 'campaign' : 'post' ); ?>
						<?php endwhile; ?>

					<?php else : ?>

						<?php get_template_part( 'no-results', 'index' ); ?>

					<?php endif; ?>
				</section>

				<?php do_action( 'fundify_loop_after' ); ?>
<!-- / Claudius -->
<div align="right">
<?php echo do_shortcode( '[ois skin="Email Listing"]' ); ?>
</div>
<!-- / Claudius -->
			</div>

		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>