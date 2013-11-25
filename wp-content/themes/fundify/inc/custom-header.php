<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Fundify
 * @since Fundify 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses fundify_header_style()
 * @uses fundify_admin_header_style()
 * @uses fundify_admin_header_image()
 *
 * @package Fundify
 */
function fundify_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '565656',
		'width'                  => 230,
		'height'                 => 20,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'fundify_header_style',
		'admin-head-callback'    => 'fundify_admin_header_style',
		'admin-preview-callback' => 'fundify_admin_header_image',
	);

	$args = apply_filters( 'fundify_custom_header_args', $args );

	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'fundify_custom_header_setup' );

if ( ! function_exists( 'fundify_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see fundify_custom_header_setup().
 *
 * @since Fundify 1.0
 */
function fundify_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title span,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // fundify_header_style

if ( ! function_exists( 'fundify_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see fundify_custom_header_setup().
 *
 * @since Fundify 1.0
 */
function fundify_admin_header_style() {
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Oswald' );
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	
	#headimg a {
		text-align: center;
		display: block;
	}

	#headimg .site-title {
		font-family: 'Oswald';
		font-size: 30px;
		letter-spacing: 2px;
		text-transform: uppercase;
		text-align: center;
	}

	#headimg .site-title a {
		color: #<?php echo get_header_textcolor(); ?>;
		text-decoration: none;
	}

	#headimg .site-title a:hover {
		text-decoration: none;
	}
	</style>
<?php
}
endif; // fundify_admin_header_style

if ( ! function_exists( 'fundify_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see fundify_custom_header_setup().
 *
 * @since Fundify 1.0
 */
function fundify_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( ! display_header_text() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>

		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>

		<h1 class="site-title"><a <?php echo $style; ?> id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php }
endif; // fundify_admin_header_image