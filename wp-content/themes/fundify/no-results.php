<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fundify
 * @since Fundify 1.0
 */
?>

<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h3 class="entry-title"><?php _e( 'Nothing Found', 'fundify' ); ?></h3>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fundify' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fundify' ); ?></p>
		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 .post .no-results .not-found -->
