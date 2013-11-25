<?php
/**
 * @package Fundify
 * @since Fundify 1.0
 */

global $post;

$campaign = atcf_get_campaign( $post );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'item' ); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fundify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
		<?php the_post_thumbnail( 'campaign' ); ?>
	</a>
	
	<h3 class="entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fundify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>

	<?php the_excerpt(); ?>

	<div class="digits">
		<div class="bar"><span style="width: <?php echo $campaign->percent_completed(); ?>"></span></div>
		<ul>
			<li><?php printf( __( '<strong>%s</strong> Funded', 'fundify' ), $campaign->percent_completed() ); ?></li>
			<li><?php printf( __( '<strong>%s</strong> Pledged', 'fundify' ), $campaign->current_amount() ); ?></li>
			<li>
				<?php if ( $campaign->days_remaining() > 0 ) : ?>
					<?php printf( __( '<strong>%s</strong> Days to Go', 'fundify' ), $campaign->days_remaining() ); ?>
				<?php else : ?>
					<?php printf( __( '<strong>%s</strong> Hours to Go', 'fundify' ), $campaign->hours_remaining() ); ?>
				<?php endif; ?>
			</li>
		</ul>
	</div>
</article>