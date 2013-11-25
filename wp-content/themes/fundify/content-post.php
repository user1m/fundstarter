<?php
/**
 * @package Fundify
 * @since Fundify 1.0.1
 */

global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'item' ); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fundify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
		<?php the_post_thumbnail( 'campaign' ); ?>
	</a>
	
	<h3 class="entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fundify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>

	<?php the_excerpt(); ?>
</article>