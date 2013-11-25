<?php
/**
 * @package Fundify
 * @since Fundify 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_page() ) : ?>
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="image">
			<?php the_post_thumbnail( 'blog' ); ?>
		</div>
		<?php endif; ?>

		<div class="post-meta">
			<div class="date"><i class="icon-calendar"></i> <?php printf( __( 'Date Posted: %s', 'fundify' ), get_the_date() ); ?></div>
			<div class="comments"><span class="comments-link"><i class="icon-comment"></i><?php comments_popup_link( __( ' 0 Comments', 'fundify' ), __( '1 Comment', 'fundify' ), __( '% Comments', 'fundify' ) ); ?></span></div>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php if ( ! is_singular() ) : ?>
		<h3 class="sans"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fundify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
		<?php endif; ?>
		
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fundify' ) ); ?>

		<?php if ( is_singular() ) : ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'fundify' ), 'after' => '</div>' ) ); ?>
			<?php the_tags( '<p class="entry-tags">' . __( 'Tags:', 'fundify' ) . ' ', ', ', '</p>' ); ?>
			<?php edit_post_link( __( 'Edit', 'fundify' ), '<p>', '</p>' ); ?>
		<?php endif; ?>
	</div><!-- .entry-content -->
</article>