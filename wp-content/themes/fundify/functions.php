<?php
/**
 * Fundify functions and definitions
 *
 * @package Fundify
 * @since Fundify 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Fundify 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 745; /* pixels */

if ( ! function_exists( 'fundify_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Fundify 1.0
 */
function fundify_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Fundify, use a find and replace
	 * to change 'fundify' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fundify', get_template_directory() . '/languages' );

	/**
	 * This theme supports AppThemer Crowdfunding Plugin
	 */
	add_theme_support( 'appthemer-crowdfunding', array(
		'campaign-edit'           => true,
		'campaign-featured-image' => true,
		'campaign-video'          => true,
		'campaign-widget'         => true,
		'campaign-categories'     => true
	) );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Custom Background
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => get_template_directory_uri() . '/images/bg_body.jpg'
	) );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 186, 186, true );
	add_image_size( 'blog', 745, 396, true );
	add_image_size( 'campaign', 253, 99999 );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary-left' => __( 'Primary Left Menu', 'fundify' ),
		'primary-right' => __( 'Primary Right Menu', 'fundify' )
	) );
}
endif; // fundify_setup
add_action( 'after_setup_theme', 'fundify_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Fundify 1.0
 */
function fundify_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'fundify' ),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	for ( $i = 2; $i <= 4; $i++ ) {
		register_sidebar( array(
			'name' => sprintf( __( 'Footer Column %d', 'fundify' ), $i - 1 ),
			'id' => 'sidebar-' . $i,
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'fundify_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function fundify_scripts() {
	global $edd_options;

	wp_enqueue_style( 'fundify-fonts', 'http://fonts.googleapis.com/css?family=Oswald|Lato:400,700' );
	wp_enqueue_style( 'fundify-entypo', get_template_directory_uri() . '/css/entypo.css' );
	wp_enqueue_style( 'fundify-style', get_stylesheet_uri() );
	
	if ( fundify_theme_mod( 'responsive' ) ) 
		wp_enqueue_style( 'fundify-responsive', get_template_directory_uri() . '/css/responsive.css' );

	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'formatCurrency', get_template_directory_uri() . '/js/jquery.formatCurrency-1.4.0.pack.js', array( 'jquery' ), '1.4.1', true );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '2.1.4', true );
	wp_enqueue_script( 'crowdfunding-scripts', get_template_directory_uri() . '/js/fundify.js', array( 'fancybox', 'formatCurrency', 'jquery-masonry' ), 20130522, true );

	$fundify_settings= array(
		'is_front_page' => is_front_page(),
		'currency'      => array(
			'thousands' => $edd_options[ 'thousands_separator' ],
			'decimal'   => $edd_options[ 'decimal_separator' ],
			'symbol'    => fundify_is_crowdfunding() ? edd_currency_filter( '' ) : null
		)
	);

	wp_localize_script( 'crowdfunding-scripts', 'fundifySettings', $fundify_settings );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fundify_scripts' );

/**
 * Append modal boxes to the bottom of the the page that
 * will pop up when certain links are clicked.
 *
 * Login/Register pages must be set in EDD settings for this to work.
 *
 * @since Fundify 1.3
 *
 * @return void
 */
function fundify_inline_modals() {
	global $edd_options;

	if ( isset ( $edd_options[ 'login_page' ] ) && isset ( $edd_options[ 'register_page' ] ) ) {
		get_template_part( 'modal', 'login' );
		get_template_part( 'modal', 'register' );
	}

	if ( is_singular( 'download' ) && fundify_is_crowdfunding() )
		get_template_part( 'modal', 'contribute' );
}
add_action( 'wp_footer', 'fundify_inline_modals' );

/**
 * Body Class
 *
 * @since Fundify 1.3
 *
 * @return void
 */
function fundify_body_class( $classes ) {
	$header_size  = fundify_theme_mod( 'header_size' );
	$header_fixed = fundify_theme_mod( 'header_fixed' );

	if ( 'mini' == $header_size ) {
		$classes[] = 'mini-header';
	}

	if ( $header_fixed ) {
		$classes[] = 'fixed-header';
	}

	return $classes;
}
add_filter( 'body_class', 'fundify_body_class' );

/**
 * If the menu item has a custom class, that means it is probably
 * going to be triggering a modal. The ID will be used to determine
 * the inline content to be displayed, so we need it to provide context.
 * This uses the specificed class name instead of `menu-item-x`
 *
 * @since Fundify 1.3
 *
 * @param string $id The ID of the current menu item
 * @param object $item The current menu item
 * @param array $args Arguments
 * @return string $id The modified menu item ID
 */
function fundify_nav_menu_item_id( $id, $item, $args ) {
	if ( ! empty( $item->classes[0] ) ) {
		return current($item->classes) . '-modal';
	}

	return $id;
}
add_filter( 'nav_menu_item_id', 'fundify_nav_menu_item_id', 10, 3 );

/** 
 * Pagination
 *
 * After the loop, attach pagination to the current query.
 *
 * @since Fundify 1.3
 *
 * @return void
 */
function fundify_pagination() {
	global $wp_query;

	$big = 999999999; // need an unlikely integer

	$links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_text' => '<i class="icon-left-open-big"></i>',
		'next_text' => '<i class="icon-right-open-big"></i>'
	) );
?>
	<div class="paginate-links container">
		<?php echo $links; ?>
	</div>
<?php
}
add_action( 'fundify_loop_after', 'fundify_pagination' );

/**
 * Crowdfunding
 */
require( get_template_directory() . '/inc/crowdfunding.php' );

/**
 * Custom template tags for this theme.
 */
require( get_template_directory() . '/inc/template-tags.php' );

/**
 * Custom functions that act independently of the theme templates
 */
require( get_template_directory() . '/inc/extras.php' );

/**
 * Customizer additions
 */
require( get_template_directory() . '/inc/customizer.php' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );