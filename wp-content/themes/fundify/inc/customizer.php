<?php
/**
 * Fundify Theme Customizer
 *
 * @package Fundify
 * @since Fundify 1.0
 */

/**
 * Expose a "Customize" link in the main admin menu.
 *
 * By default, the only way to access a theme customizer is via
 * the themes.php page, which is totally lame.
 *
 * @since Fundify 1.0
 *
 * @return void
 */
function fundify_customize_menu() {
    add_theme_page( __( 'Customize', 'fundify' ), __( 'Customize', 'fundify' ), 'edit_theme_options', 'customize.php' );
}
add_action ( 'admin_menu', 'fundify_customize_menu' );

/**
 * Get Theme Mod
 *
 * Instead of options, customizations are stored/accessed via Theme Mods
 * (which are still technically settings). This wrapper provides a way to
 * check for an existing mod, or load a default in its place.
 *
 * @since Fundify 1.0
 *
 * @param string $key The key of the theme mod to check. Prefixed with 'fundify_'
 * @return mixed The theme modification setting
 */
function fundify_theme_mod( $key ) {
	$defaults = fundify_get_theme_mods();
	$key      = 'fundify_' . $key;
	$mod      = get_theme_mod( $key, $defaults[ $key ] );

	return apply_filters( 'fundify_theme_mod_' . $key, $mod );
}

/**
 * Default theme customizations.
 *
 * @since Fundify 1.0
 *
 * @return $options an array of default theme options
 */
function fundify_get_theme_mods() {
	$defaults = array(
		'fundify_responsive'                 => true,
		'fundify_header_fixed'               => true,
		'fundify_header_size'                => 'normal',
		'fundify_hero_style'                 => 'grid',
		'fundify_hero_text'                  => "The first Fundify WordPress theme\nWe help you fund your campaigns using WordPress\nStart funding your campaign today",
		'fundify_accent_color'               => '#04937f',
		'fundify_footer_text_color'          => '#005a4d',
		'fundify_footer_logo_image'          => get_template_directory_uri() . '/images/logo_f.png',
		'fundify_footer_background_color'    => '#04937f',
		'fundify_footer_background_image'    => get_template_directory_uri() . '/images/bg_footer.jpg',
		'fundify_footer_background_repeat'   => 'repeat',
		'fundify_footer_background_position' => 'top',
		'fundify_contact_text'               => sprintf( "Got questions regarding %s?\nFill out the below form and we'll get in touch\nWere here to help you.", get_bloginfo( 'name' ) ),
		'fundify_contact_subtitle'           => 'Where our offices are located, and how to get in touch.',
		'fundify_contact_address'            => "43 Brewer Street\nLondon, W1F 9UD",
		'fundify_contact_image'              => ''
	);

	return $defaults;
}

/**
 * General Customization
 *
 * @since Fundify 1.3
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fundify_customize_register_general( $wp_customize ) {
	$wp_customize->add_section( 'fundify_general', array(
		'title'      => __( 'General', 'fundify' ),
		'priority'   => 85,
	) );

	/** Responsive */
	$wp_customize->add_setting( 'fundify_responsive', array(
		'default'    => fundify_theme_mod( 'responsive' )
	) );

	$wp_customize->add_control( 'fundify_responsive', array(
		'label'      => __( 'Enable Responsive Design', 'fundify' ),
		'section'    => 'fundify_general',
		'settings'   => 'fundify_responsive',
		'type'       => 'checkbox',
		'priority'   => 10
	) );

	/** Fixed Header */
	$wp_customize->add_setting( 'fundify_header_fixed', array(
		'default'    => fundify_theme_mod( 'header_fixed' )
	) );

	$wp_customize->add_control( 'fundify_header_fixed', array(
		'label'      => __( 'Enable Fixed Header', 'fundify' ),
		'section'    => 'fundify_general',
		'settings'   => 'fundify_header_fixed',
		'type'       => 'checkbox',
		'priority'   => 20
	) );

	/** Header Size */
	$wp_customize->add_setting( 'fundify_header_size', array(
		'default'    => fundify_theme_mod( 'header_size' )
	) );

	$wp_customize->add_control( 'fundify_header_size', array(
		'label'      => __( 'Header Size', 'fundify' ),
		'section'    => 'fundify_general',
		'settings'   => 'fundify_header_size',
		'type'       => 'radio',
		'choices'    => array(
			'mini'   => _x( 'Mini', 'header size', 'fundify' ),
			'normal' => _x( 'Normal', 'header size', 'fundify' )
		),
		'priority'   => 30
	) );

	do_action( 'fundify_customize_general', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'fundify_customize_register_general' );

/**
 * Hero Customization
 *
 * Register settings and controls for customizing the "Hero" section
 * of the theme. This includes title, description, images, colors, etc.
 *
 * @since Fundify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fundify_customize_register_hero( $wp_customize ) {
	if ( ! ( get_option( 'page_on_front' ) && 'page-templates/front-page.php' == get_page_template_slug( get_option( 'page_on_front' ) ) ) )
		return false;

	$wp_customize->add_section( 'fundify_hero', array(
		'title'      => __( 'Hero Unit', 'fundify' ),
		'priority'   => 95,
	) );

	$wp_customize->add_setting( 'fundify_hero_style', array(
		'default'    => fundify_theme_mod( 'hero_style' )
	) );

	$wp_customize->add_control( 'fundify_hero_style', array(
		'label'      => __( 'Style', 'fundify' ),
		'section'    => 'fundify_hero',
		'settings'   => 'fundify_hero_style',
		'type'       => 'radio',
		'choices'    => array(
			'grid'   => __( 'Grid', 'fundify' ),
			'single' => __( 'Single', 'fundify' )
		),
		'priority'   => 10
	) );

	/** Description */
	$wp_customize->add_setting( 'fundify_hero_text', array(
		'default'    => fundify_theme_mod( 'hero_text' )
	) );

	$wp_customize->add_control( new fundify_Customize_Textarea_Control( $wp_customize, 'fundify_hero_text', array(
		'label'      => __( 'Hero Text', 'fundify' ),
		'section'    => 'fundify_hero',
		'settings'   => 'fundify_hero_text',
		'type'       => 'textarea',
		'priority'   => 20
	) ) );

	do_action( 'fundify_customize_hero', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'fundify_customize_register_hero' );

function fundify_customize_register_colors( $wp_customize ) {
	/** Link Color */
	$wp_customize->add_setting( 'fundify_accent_color', array(
		'default'    => fundify_theme_mod( 'accent_color' ),
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fundify_accent_color', array(
		'label'      => __( 'Accent Color', 'fundify' ),
		'section'    => 'colors',
		'settings'   => 'fundify_accent_color',
		'priority'   => 30
	) ) );
}
add_action( 'customize_register', 'fundify_customize_register_colors' );

function fundify_customize_register_footer( $wp_customize ) {
	$wp_customize->add_section( 'fundify_footer', array(
		'title'      => __( 'Footer', 'fundify' ),
		'priority'   => 105,
	) );

	/** Description */
	$wp_customize->add_setting( 'fundify_footer_text_color', array(
		'default'    => fundify_theme_mod( 'footer_text_color' )
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fundify_footer_text_color', array(
		'label'      => __( 'Text Color', 'fundify' ),
		'section'    => 'fundify_footer',
		'settings'   => 'fundify_footer_text_color',
		'priority'   => 20
	) ) );

	/** Footer Logo */
	$wp_customize->add_setting( 'fundify_footer_logo_image', array(
		'default'        => fundify_theme_mod( 'footer_logo_image' )
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fundify_footer_logo_image', array(
		'label'          => __( 'Logo Image', 'fundify' ),
		'section'        => 'fundify_footer',
		'settings'       => 'fundify_footer_logo_image',
		'priority'       => 30
	) ) );

	/** Background Color */
	$wp_customize->add_setting( 'fundify_footer_background_color', array(
		'default'    => fundify_theme_mod( 'footer_background_color' ),
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fundify_footer_background_color', array(
		'label'      => __( 'Background Color', 'fundify' ),
		'section'    => 'fundify_footer',
		'settings'   => 'fundify_footer_background_color',
		'priority'   => 40
	) ) );

	/** Background Image */
	$wp_customize->add_setting( 'fundify_footer_background_image', array(
		'default'        => fundify_theme_mod( 'footer_background_image' )
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fundify_footer_background_image', array(
		'label'          => __( 'Background Image', 'fundify' ),
		'section'        => 'fundify_footer',
		'settings'       => 'fundify_footer_background_image',
		'priority'       => 50
	) ) );

	$wp_customize->add_setting( 'fundify_footer_background_repeat', array(
		'default'        => fundify_theme_mod( 'footer_background_repeat' )
	) );

	$wp_customize->add_control( 'fundify_footer_background_repeat', array(
		'label'      => __( 'Background Repeat', 'fundify' ),
		'section'    => 'fundify_footer',
		'type'       => 'radio',
		'choices'    => array(
			'no-repeat'  => __( 'No Repeat', 'fundify' ),
			'repeat'     => __( 'Tile', 'fundify' ),
			'repeat-x'   => __( 'Tile Horizontally', 'fundify' ),
			'repeat-y'   => __( 'Tile Vertically', 'fundify' ),
		),
		'priority'       => 60
	) );

	$wp_customize->add_setting( 'fundify_footer_background_position', array(
		'default'        => fundify_theme_mod( 'footer_background_position' )
	) );

	$wp_customize->add_control( 'fundify_footer_background_position', array(
		'label'      => __( 'Background Position', 'fundify'  ),
		'section'    => 'fundify_footer',
		'type'       => 'radio',
		'choices'    => array(
			'left'       => __( 'Left', 'fundify' ),
			'center'     => __( 'Center', 'fundify' ),
			'right'      => __( 'Right', 'fundify' ),
		),
		'priority'       => 70
	) );
}
add_action( 'customize_register', 'fundify_customize_register_footer' );

/**
 * Contact Page Cusomziation
 *
 * @since Fundify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fundify_customize_register_contact( $wp_customize ) {
	$wp_customize->add_section( 'fundify_contact', array(
		'title'      => __( 'Contact Page', 'fundify' ),
		'priority'   => 95,
	) );

	/** Description */
	$wp_customize->add_setting( 'fundify_contact_text', array(
		'default'    => fundify_theme_mod( 'contact_text' )
	) );

	$wp_customize->add_control( new fundify_Customize_Textarea_Control( $wp_customize, 'fundify_contact_text', array(
		'label'      => __( 'Hero Text', 'fundify' ),
		'section'    => 'fundify_contact',
		'settings'   => 'fundify_contact_text',
		'type'       => 'textarea',
		'priority'   => 20
	) ) );

	/** Subtitle */
	$wp_customize->add_setting( 'fundify_contact_subtitle', array(
		'default'    => fundify_theme_mod( 'contact_subtitle' )
	) );

	$wp_customize->add_control( new fundify_Customize_Textarea_Control( $wp_customize, 'fundify_contact_subtitle', array(
		'label'      => __( 'Page Subtitle', 'fundify' ),
		'section'    => 'fundify_contact',
		'settings'   => 'fundify_contact_subtitle',
		'type'       => 'textarea',
		'priority'   => 25
	) ) );

	/** Address */
	$wp_customize->add_setting( 'fundify_contact_address', array(
		'default'    => fundify_theme_mod( 'contact_address' )
	) );

	$wp_customize->add_control( new fundify_Customize_Textarea_Control( $wp_customize, 'fundify_contact_address', array(
		'label'      => __( 'Contact Address', 'fundify' ),
		'section'    => 'fundify_contact',
		'settings'   => 'fundify_contact_address',
		'type'       => 'textarea',
		'priority'   => 30
	) ) );

	/** Map Image */
	$wp_customize->add_setting( 'fundify_contact_image', array(
		'default'        => fundify_theme_mod( 'contact_image' )
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fundify_contact_image', array(
		'label'          => __( 'Map Image', 'fundify' ),
		'section'        => 'fundify_contact',
		'settings'       => 'fundify_contact_image',
		'priority'       => 40
	) ) );

	do_action( 'fundify_customize_contact', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'fundify_customize_register_contact' );

/**
 * Textarea Control
 *
 * Attach the custom textarea control to the `customize_register` action
 * so the WP_Customize_Control class is initiated.
 *
 * @since Fundify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fundify_customize_textarea_control( $wp_customize ) {
	/**
	 * Textarea Control
	 *
	 * @since CLoudify 1.0
	 */
	class fundify_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	<?php
		}
	} 
}
add_action( 'customize_register', 'fundify_customize_textarea_control', 1, 1 );

/**
 * Add postMessage support for all default fields, as well
 * as the site title and desceription for the Theme Customizer.
 *
 * @since Fundify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fundify_customize_register_transport( $wp_customize ) {
	$transport = array_merge( array( 'blogname' => '', 'blogdescription' => '' ), fundify_get_theme_mods() );

	if ( isset ( $transport[ 'fundify_hero_style' ] ) )
		unset( $transport[ 'fundify_hero_style' ] );

	foreach ( $transport as $key => $default ) {
		$setting = $wp_customize->get_setting( $key );

		if ( ! isset( $setting ) )
			continue;

		$wp_customize->get_setting( $key )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'fundify_customize_register_transport' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Fundify 1.0
 */
function fundify_customize_preview_js() {
	wp_enqueue_script( 'fundify-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20120305.2', true );
}
add_action( 'customize_preview_init', 'fundify_customize_preview_js' );

/**
 * Any CSS customizations we make need to be outputted in the document <head>
 *
 * @since Fundify 1.0
 *
 * @return void
 */
function fundify_header_css() {
?>
	<style>
		.sort-tabs .dropdown .current, 
		.sort-tabs li a:hover, 
		.sort-tabs li a.selected,
		.entry-content a,
		.edd_price_options .backer-count,
		#sidebar .widget-bio .author-bio-links li a,
		.share-link:hover:before,
		a.page-numbers:hover,
		#sidebar .widget ul li a {
			color: <?php echo fundify_theme_mod( 'accent_color' ); ?>;
		}

		#home-page-featured h1 span,
		#title-image h1 span,
		.bar span,
		input[type=submit]:not(#searchsubmit),
		.btn-green,
		.entry-content .button:not(.add_media),
		.edd-add-to-cart {
			background: <?php echo fundify_theme_mod( 'accent_color' ); ?>;
		}

		#home-page-featured h1 span,
		#title-image h1 span {
			box-shadow: 20px 0 0 <?php echo fundify_theme_mod( 'accent_color' ); ?>, -20px 0 0 <?php echo fundify_theme_mod( 'accent_color' ); ?>;
		}

		.sort-tabs li a:hover, 
		.sort-tabs li a.selected {
			border-color: <?php echo fundify_theme_mod( 'accent_color' ); ?>;
		}

		#footer,
		#footer a,
		#footer h3 {
			color: <?php echo fundify_theme_mod( 'footer_text_color' ); ?>;
		}

		#footer input[type=text],
		#footer input[type=email] {
			background-color: <?php echo fundify_theme_mod( 'footer_text_color' ); ?>;
		}

		#footer input[type="submit"] {
			background-color: <?php echo fundify_theme_mod( 'footer_text_color' ); ?>;
		}
	</style>

	<style id="fundify-footer-custom-background-css">
		#footer {
			background-color: <?php echo fundify_theme_mod( 'footer_background_color' ); ?>;
			<?php if ( fundify_theme_mod( 'footer_background_image' ) ) : ?>
			background-image: url(<?php echo esc_url( fundify_theme_mod( 'footer_background_image' ) ); ?>);
			background-repeat: <?php echo fundify_theme_mod( 'footer_background_repeat' ); ?>;
			background-position-x: <?php echo fundify_theme_mod( 'footer_background_position' ); ?>;
			<?php endif; ?>
		}
	</style>
<?php
}
add_action( 'wp_head', 'fundify_header_css' );