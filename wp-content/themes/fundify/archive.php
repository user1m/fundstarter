<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fundify
 * @since Fundify 1.0
 */

get_header(); ?>

	<div class="title title-two pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php
				if ( is_category() ) {
					single_cat_title( '' );
				} elseif ( is_tag() ) {
					single_tag_title( '' );
				} elseif ( is_author() ) {
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					*/
					the_post();
					echo '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>';
					rewind_posts();

				} elseif ( is_day() ) {
					echo get_the_date();
				} elseif ( is_month() ) {
					echo get_the_date( 'F Y' );

				} elseif ( is_year() ) {
					echo get_the_date( 'Y' );

				} else {
					_e( 'Archives', 'fundify' );

				}
			?></h1>
			<h3><?php
				if ( is_category() ) {
					_e( 'Category Archives', 'fundify' );
				} elseif ( is_tag() ) {
					_e( 'Tag Archives', 'fundify' );
				} elseif ( is_author() ) {
					_e( 'Author Archives', 'fundify' );
				} elseif ( is_day() ) {
					_e( 'Daily Archives', 'fundify' );
				} elseif ( is_month() ) {
					_e( 'Monthly Archives', 'fundify' );
				} elseif ( is_year() ) {
					_e( 'Yearly Archives', 'fundify' );
				}
			?></h3>
		</div>
		<!-- / container -->
	</div>
	<div id="content">
		<div class="container">
			<div id="main-content">
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php do_action( 'fundify_loop_after' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'index' ); ?>

				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>