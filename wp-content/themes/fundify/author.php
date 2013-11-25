<?php
/**
 * Campaigns
 *
 * @package Fundify
 * @since Fundify 1.1
 */

global $wp_query;
$author = $wp_query->get_queried_object();

get_header(); ?>

	<div class="title title-two pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php echo $author->display_name; ?></h1>
			<h3><?php 
				$count = fundify_count_user_campaigns( $author->ID );
				printf( _nx( 'Created %1$d Campaign', 'Created %1$d Campaigns', $count, '1: Number of Campaigns 2: EDD Object', 'fundify' ), $count ); 
			?></h3>
		</div>
		<!-- / container -->
	</div>
	<div id="content">
		<div class="container">
			<?php if ( '' != $author->user_description ) : ?>
			<div class="single-author-bio">
				<?php echo get_avatar( $author->user_email, 80 ); ?>

				<div class="author-bio big">
					<?php echo wpautop( $author->user_description ); ?>
				</div>

				<ul class="author-bio-links">
					<?php if ( '' != $author->user_url ) : ?>
					<li class="contact-link"><i class="icon-link"></i> <?php echo make_clickable( $author->user_url ); ?></li>
					<?php endif; ?>

					<?php
						$methods = _wp_get_user_contactmethods();

						foreach ( $methods as $key => $method ) :
							if ( '' == $author->$key )
								continue;
					?>
						<li class="contact-<?php echo $key; ?>"><i class="icon-<?php echo $key; ?>"></i> <?php echo make_clickable( $author->$key ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

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