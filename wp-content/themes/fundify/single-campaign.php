<?php
/**
 * The Template for displaying all single campaigns.
 *
 * @package Fundify
 * @since Fundify 1.0
 */

global $wp_embed;

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); $campaign = new ATCF_Campaign( $post->ID ); ?>
	<div class="title <?php echo '' == $campaign->author() ? '' : 'title-two'; ?> pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php the_title() ;?></h1>
			
			<?php if ( '' != $campaign->author() ) : ?>
			<h3><?php printf( __( 'By %s', 'fundify' ), esc_attr( $campaign->author() ) ); ?></h3>
			<?php endif; ?>
		</div>
		<!-- / container -->
	</div>
	<div id="content" class="post-details">
		<div class="container">
			<?php do_action( 'atcf_campaign_before', $campaign ); ?>
			
			<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
			<div class="sort-tabs campaign">
				<ul>
					<li><a href="#description" class="campaign-view-descrption tabber"><?php _e( 'Overview', 'fundify' ); ?></a></li>
					
					<?php if ( '' != $campaign->updates() ) : ?>
					<li><a href="#updates" class="tabber"><?php _e( 'Updates', 'fundify' ); ?></a></li>
					<?php endif; ?>
					
					<li><a href="#comments" class="tabber"><?php _e( 'Comments', 'fundify' ); ?></a></li>
					<li><a href="#backers" class="tabber"><?php _e( 'Backers', 'fundify' ); ?></a></li>
					
					<?php if ( get_current_user_id() == $post->post_author || current_user_can( 'manage_options' ) ) : ?>
					<li><a href="<?php echo atcf_create_permalink( 'edit', get_permalink() ); ?>"><?php _e( 'Edit Campaign', 'fundify' ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
			<article class="project-details">
				<div class="image">
					<?php if ( $campaign->video() ) : ?>
						<div class="video-container">
							<?php echo $wp_embed->run_shortcode( '[embed]' . $campaign->video() . '[/embed]' ); ?>
						</div>
					<?php else : ?>
						<?php the_post_thumbnail( 'blog' ); ?>
					<?php endif; ?>
				</div>
				<div class="right-side">
					<ul class="campaign-stats">
						<li class="progress">
							<h3><?php echo $campaign->current_amount(); ?></h3>
							<p><?php printf( __( 'Pledged of %s Goal', 'fundify' ), $campaign->goal() ); ?></p>

							<div class="bar"><span style="width: <?php echo $campaign->percent_completed(); ?>"></span></div>
						</li>

						<li class="backer-count">
							<h3><?php echo $campaign->backers_count(); ?></h3>
							<p><?php echo _nx( 'Backer', 'Backers', $campaign->backers_count(), 'number of backers for campaign', 'fundify' ); ?></p>
						</li>
						<?php if ( ! $campaign->is_endless() ) : ?>
						<li class="days-remaining">
							<?php if ( $campaign->days_remaining() > 0 ) : ?>
								<h3><?php echo $campaign->days_remaining(); ?></h3>
								<p><?php echo _n( 'Day to Go', 'Days to Go', $campaign->days_remaining(), 'fundify' ); ?></p>
							<?php else : ?>
								<h3><?php echo $campaign->hours_remaining(); ?></h3>
								<p><?php echo _n( 'Hour to Go', 'Hours to Go', $campaign->hours_remaining(), 'fundify' ); ?></p>
							<?php endif; ?>
						</li>
						<?php endif; ?>
					</ul>

					<div class="contribute-now">
						<?php if ( $campaign->is_active() ) : ?>
							<a href="#contribute-now" class="btn-green contribute"><?php _e( 'Contribute Now', 'fundify' ); ?></a>
						<?php else : ?>
							<a class="btn-green expired"><?php printf( __( '%s Expired', 'fundify' ), edd_get_label_singular() ); ?></a>
						<?php endif; ?>
					</div>

					<?php
						if ( ! $campaign->is_endless() ) :
							$end_date = date_i18n( get_option( 'date_format' ), strtotime( $campaign->end_date() ) )
					?>
					
					<p class="fund">
						<?php if ( 'fixed' == $campaign->type() ) : ?>
						<?php printf( __( 'This %3$s will only be funded if at least %1$s is pledged by %2$s.', 'fundify' ), $campaign->goal(), $end_date, strtolower( edd_get_label_singular() ) ); ?>
						<?php elseif ( 'flexible' == $campaign->type() ) : ?>
						<?php printf( __( 'All funds will be collected on %1$s.', 'fundify' ), $end_date ); ?>
						<?php else : ?>
						<?php printf( __( 'All pledges will be collected automatically until %1$s.', 'fundify' ), $end_date ); ?>
						<?php endif; ?>
					</p>
					<?php endif; ?>
				</div>
			</article>

			<aside id="sidebar">
				<?php get_template_part( 'content', 'campaign-author' ); ?>

				<div id="contribute-now" class="single-reward-levels">
					<?php 
						if ( $campaign->is_active() ) :
							echo edd_get_purchase_link( array( 
								'download_id' => $post->ID,
								'class'       => '',
								'price'       => false,
								'text'        => __( 'Contribute Now', 'fundify' )
							) ); 
						else : // Inactive, just show options with no button
							fundify_campaign_contribute_options( edd_get_variable_prices( $post->ID ), 'checkbox', $post->ID );
						endif;
					?>					
				</div>
			</aside>

			<div id="main-content">
				<div class="post-meta campaign-meta">
					<div class="date">
						<i class="icon-calendar"></i>
						<?php printf( __( 'Launched: %s', 'fundify' ), get_the_date() ); ?>
					</div>

					<?php if ( ! $campaign->is_endless() ) : ?>
					<div class="funding-ends">
						<i class="icon-clock"></i>
						<?php printf( __( 'Funding Ends: %s', 'fundify' ), $end_date ); ?>
					</div>
					<?php endif; ?>

					<?php if ( $campaign->location() ) : ?>
					<div class="location">
						<i class="icon-compass"></i>
						<?php echo $campaign->location(); ?>
					</div>
					<?php endif; ?>
				</div>

				<div class="entry-share">
					<?php _e( 'Share this campaign', 'fundify' ); ?>

					<?php $message = apply_filters( 'fundify_share_message', sprintf( __( 'Check out %s on %s! %s', 'fundify' ), $post->post_title, get_bloginfo( 'name' ), get_permalink() ) ); ?>

					<a href="<?php echo esc_url( sprintf( 'http://twitter.com/home?status=%s', urlencode( $message ) ) ); ?>" target="_blank" class="share-twitter"><i class="icon-twitter"></i></a>
					
					<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" class="share-google"><i class="icon-gplus"></i></a>

					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog' ); ?>
					<a href="http://www.facebook.com/sharer.php?s=100
						&p[url]=<?php echo urlencode( get_permalink() ); ?>
						&p[images][0]=<?php echo urlencode( $image[0]); ?>
						&p[title]=<?php echo urlencode( $post->post_title ); ?>
						&p[summary]=<?php echo urlencode( $message ); ?>" class="share-facebook"><i class="icon-facebook"></i></a>
					
					<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" target="_blank" class="share-pinterest"><i class="icon-pinterest"></i></a>
					
					<a href="<?php the_permalink(); ?>" target="_blank" class="share-link"><i class="icon-link"></i></a>
					
					<a href="share-widget" class="share-widget fancybox"><i class="icon-code"></i></a>

					<div id="share-widget" class="modal">
						<?php get_template_part( 'modal', 'campaign-widget' ); ?>
					</div>
				</div>

				<div class="entry-content inner campaign-tabs">
					<div id="description">
						<?php the_content(); ?>
					</div>

					<?php if ( '' != $campaign->updates() ) : ?>
						<div id="updates">
							<h3 class="campaign-updates-title sans"><?php _e( 'Updates', 'fundify' ); ?></h3>

							<?php echo $campaign->updates(); ?>
						</div>
					<?php endif; ?>

					<?php comments_template(); ?>

					<div id="backers">
						<?php $backers = $campaign->backers(); ?>

						<?php if ( empty( $backers ) ) : ?>
						<p><?php _e( 'No backers yet. Be the first!', 'fundify' ); ?></p>
						<?php else : ?>

							<ol class="backer-list">
							<?php foreach ( $backers as $backer ) : ?>
								<?php
									$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );

									if ( ! get_post( $payment_id ) )
										continue;

									$user_info  = edd_get_payment_meta_user_info( $payment_id );
								?>

								<li class="backer">
									<?php echo get_avatar( $user_info[ 'email' ], 40 ); ?>

									<div class="backer-info">
										<strong><?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?></strong><br />
										<?php echo edd_payment_amount( $payment_id ); ?>
									</div>
								</li>
							<?php endforeach; ?>
							</ol>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->
	<?php endwhile; ?>

<?php get_footer(); ?>