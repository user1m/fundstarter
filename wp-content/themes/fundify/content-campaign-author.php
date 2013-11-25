<?php
/**
 *
 */

global $post, $campaign;

$author = get_user_by( 'id', $post->post_author );
?>

<div class="widget widget-bio">
	<h3><?php _e( 'About the Author', 'fundify' ); ?></h3>

	<?php echo get_avatar( $author->user_email, 40 ); ?>

	<div class="author-bio">
		<strong><?php 
			if ( $campaign->author() ) :
				echo esc_attr( $campaign->author() );
			else :
				echo esc_attr( $author->display_name );
			endif; 
		?></strong><br />
		<small>
			<?php 
				$count = fundify_count_user_campaigns( $author->ID );
				printf( _nx( 'Created %1$d Campaign', 'Created %1$d Campaigns', $count, '1: Number of Campaigns 2: EDD Object', 'fundify' ), $count ); 
			?> 
			&bull; 
			<a href="<?php echo get_author_posts_url( $author->ID ); ?>"><?php _e( 'View Profile', 'fundify' ); ?></a></small>
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
			<li class="contact-<?php echo $key; ?>"><i class="icon-<?php echo $key; ?>"></i><?php echo make_clickable( $author->$key ); ?></li>
		<?php endforeach; ?>
	</ul>

	<div class="author-bio-desc">
		<?php echo wpautop( $author->user_description ); ?>
	</div>

	<?php if ( '' != $campaign->contact_email() ) : ?>
		<div class="author-contact">
			<p><a href="mailto:<?php echo $campaign->contact_email(); ?>" class="button btn-green"><?php _e( 'Ask Question', 'fundify' ); ?></a></p>
		</div>
	<?php endif; ?>
</div>