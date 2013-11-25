<?php
/**
 * Template Name: Contact
 *
 * @package Fundify
 * @since Fundify 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	<div id="title-image">
		<div class="image">
			<?php
				if ( '' == fundify_theme_mod( 'contact_image' ) )
					$src = sprintf( 'http://maps.googleapis.com/maps/api/staticmap?center=%s&zoom=13&size=900x300&maptype=roadmap&sensor=false&scale=4', fundify_theme_mod( 'contact_address' ) );
				else
					$src = fundify_theme_mod( 'contact_image' );
			?>
			<img src="<?php echo esc_url( $src ); ?>" alt="">
		</div>
		
		<h1><?php 
			$string = fundify_theme_mod( 'contact_text' ); 
			$lines = explode( "\n", $string );
		?>
		<span><?php echo implode( '</span><br /><span>', $lines ); ?></span></h1>
	</div>
	<div id="content">
		<div class="container">
			<div class="contacts">
				<div class="address">
					<div class="left contact-address"><?php echo wpautop( fundify_theme_mod( 'contact_address' ) ); ?></div>
					<div class="left"><a href="mailto:<?php echo get_option( 'admin_email' ); ?>"><?php echo get_option( 'admin_email' ); ?></a></div>
				</div>
				<h2 class="contact-subtitle"><?php echo fundify_theme_mod( 'contact_subtitle' ); ?></h2>
				<div class="div-c"></div>
				<div id="respond">
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
				<!-- #respond --> 
			</div>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->
	<?php endwhile; ?>

<?php get_footer(); ?>