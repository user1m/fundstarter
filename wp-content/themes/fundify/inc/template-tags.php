<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Fundify
 * @since Fundify 1.0
 */

/** 
 * Get a specific page that has a page template.
 *
 * @since Fundify 1.3
 *
 * @return void
 */
function fundify_page_template_link( $template ) {
	$pages = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-templates/' . $template,
		'fields'     => 'ids'
	) );

	if ( ! get_post( $pages[0] ) )
		return false;

	return esc_url( get_permalink( $pages[0] ) );
}

if ( ! function_exists( 'fundify_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Fundify 1.0
 */
function fundify_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'fundify' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'fundify' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
			<header class="comment-meta">
				<?php echo get_avatar( $comment, 53 ); ?>
				<?php printf( __( '%s', 'fundify' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time><?php comment_date(); ?></time></a>
			</header>
			<!-- .comment-meta -->
			
			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'fundify' ) ); ?>
			</section>
			<!-- .comment-content -->
			
			<!-- .reply --> 
		</article>
	<?php
			break;
	endswitch;
}
endif; // ends check for fundify_comment()