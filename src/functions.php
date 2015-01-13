<?php
/**
 * Adirondack functions and definitions
 *
 * @package Adirondack
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 850; /* pixels */
}

if ( ! function_exists( 'adirondack_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function adirondack_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Adirondack, use a find and replace
	 * to change 'adirondack' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'adirondack', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add custom TinyMCE CSS
	add_editor_style( array( 'editor-style.css', adirondack_fonts_url() ) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 670, 500, true );
	add_image_size( 'header-image', 2000, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'adirondack' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'status', 'image', 'gallery', 'video', 'audio', 'quote', 'link', 'chat'
	) );
}
endif; // adirondack_setup
add_action( 'after_setup_theme', 'adirondack_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function adirondack_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'adirondack' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'adirondack_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function adirondack_scripts() {
	wp_enqueue_style( 'adirondack-style', get_stylesheet_uri() );

	wp_enqueue_script( 'adirondack-scripts', get_template_directory_uri() . '/js/adirondack.js', array( 'jquery' ), '20120206', true );

	wp_enqueue_script( 'adirondack-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'adirondack_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Maven Pro and PT Serif by default is localized.
 * For languages that use characters not supported by either
 * font, the font can be disabled.
 *
 * @since Adirondack 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function adirondack_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Maven Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$mavenpro = _x( 'on', 'Maven Pro font: on or off', 'adirondack' );

	/* Translators: If there are characters in your language that are not
	 * supported by PT Serif, translate this to 'off'. Do not translate into
	 * your own language.
	 */
	$ptserif = _x( 'on', 'PT Serif font: on or off', 'adirondack' );

	if ( 'off' !== $mavenpro || 'off' !== $ptserif ) {
		$font_families = array();

		if ( 'off' !== $mavenpro )
			$font_families[] = urlencode( 'Maven Pro:400,500,700,900' );

		if ( 'off' !== $ptserif )
			$font_families[] = urlencode( 'PT Serif:400,700,400italic' );

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'adirondack-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @since Adirondack 1.0
 *
 * @return void
 */
function adirondack_fonts() {
	$fonts_url = adirondack_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'adirondack-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'adirondack_fonts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function adirondack_admin_fonts( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'appearance_page_custom-header', 'post-new.php', 'post.php' ) ) ) {
		return;
	}

	adirondack_fonts();

}
add_action( 'admin_enqueue_scripts', 'adirondack_admin_fonts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
