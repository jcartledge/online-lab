<?php
/**
 * Lab functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lab
 */

require_once 'vendor/autoload.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lab_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on lab, use a find and replace
	 * to change 'lab' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'lab', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'lab' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'lab_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}

add_action( 'after_setup_theme', 'lab_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lab_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lab_content_width', 640 );
}
add_action( 'after_setup_theme', 'lab_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lab_widgets_init() {
	register_sidebar( array(
		'name'					=> esc_html__( 'Sidebar', 'lab' ),
		'id'						=> 'sidebar-1',
		'description'	 => esc_html__( 'Add widgets here.', 'lab' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	 => '</h2>',
	) );
}
add_action( 'widgets_init', 'lab_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lab_scripts() {
	wp_enqueue_style( 'lab-style', get_stylesheet_uri() );

	wp_enqueue_script( 'lab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'lab-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lab_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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

/**
 * Join an array of strings with correct English separators.
 *
 * @param Array	 $arr Strings to join.
 * @param String $join Text to join with, for all but last pair.
 * @param String $last_join Text to join last pair with.
 */
function join_strings( $arr, $join = ', ', $last_join = ' and ' ) {
	$last = array_pop( $arr );
	if ( count( $arr ) === 0 ) {
		return $last;
	}
	$first = implode( $join, $arr );
	return implode( $last_join, [ $first, $last ] );
}

/**
 * Return the correct singular or plural string.
 *
 * @param int    $count The number of items.
 * @param string $singular String to return for one item.
 * @param string $plural String to return for zero or more than one items.
 * @return string
 */
function inflect( $count, $singular, $plural ) {
	static $formatter;
	if ( empty( $formatter ) ) {
		$formatter = new NumberFormatter( 'en', NumberFormatter::SPELLOUT );
	}
	$count_english = $formatter->format( $count );
	return sprintf( '%s %s', $count_english, 1 === $count ? $singular : $plural );
}

/**
 * End with 403 error.
 *
 * @param String $message Text to output before going away.
 */
function deny( $message = 'Nope.' ) {
	wp_die( $message, 403 ); // WPCS: XSS OK.
}

/**
 * End with 403 if not logged in user.
 *
 * @param String $message Text to output before going away.
 */
function require_logged_in_user( $message = 'Nope.' ) {
	if ( ! is_user_logged_in() ) {
		deny( $message );
	}
}

add_filter( 'nav_menu_css_class', function ( $classes, $item ) {
	$type = get_post_type();
	if ( in_array( $type, [ 'project', 'session' ], true ) ) {
		$menu_link = "/${type}s" ;
		if ( substr( $item->url, -strlen( $menu_link ) ) === $menu_link ) {
			$classes[] = 'current-menu-item';
		}
	}
	return $classes;
} , 10, 2 );

add_filter( 'wp_insert_post_data', function ( $data, $postarr ) {
	if ( 'session' === $data['post_type'] ) {
		$data['post_name'] = wp_unique_post_slug(
			$postarr['ID'],
			$postarr['ID'],
			'publish',
			$data['post_type'],
			0
		);
		if ( ! empty( $postarr['pods_meta_session_start_time'] ) ) {
			$data['post_title'] = $postarr['pods_meta_session_start_time'];
		}
	}
	return $data;
}, 10, 2 );

