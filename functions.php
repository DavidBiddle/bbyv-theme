<?php
/**
 * Bristol Big Youth Vote functions and definitions
 *
 * @package Bristol Big Youth Vote
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'bristolbigyouthvote_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bristolbigyouthvote_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Bristol Big Youth Vote, use a find and replace
	 * to change 'bristolbigyouthvote' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bristolbigyouthvote', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bristolbigyouthvote' ),
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
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bristolbigyouthvote_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // bristolbigyouthvote_setup
add_action( 'after_setup_theme', 'bristolbigyouthvote_setup' );


// customize embed settings
function custom_youtube_settings($code){
	if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false){
		$return = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0&autohide=1&frameborder=0", $code);
		return $return;
	}
	return $code;
}

add_filter('embed_handler_html', 'custom_youtube_settings');
add_filter('embed_oembed_html', 'custom_youtube_settings');

add_filter( 'embed_oembed_html', 'tdd_oembed_filter', 10, 4 );

function tdd_oembed_filter($html, $url, $attr, $post_ID) {
$return = '<figure class="video-container">'.$html.'</figure>';
return $return;
}

/**
 * Allow SVG uploads.
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


//form and map shortcode
function map_shortcode( $atts ){
	$url = site_url();
	return '<form action="" method="post" name="postcodeSearchForm" class="postcode-form"><input name="userpostcode" type="text" /><input type="submit" value="Find my area" /></form>
<p style="text-align: center;" class="constituency"></p>
<object class="homepage-map" data="'.$url.'/wp-content/uploads/2014/12/constituency-map.svg" type="image/svg+xml" width="100%">Map unavailable, please choose a constituency:
<ul>
	<li><a title="Candidates – North" href="'.$url.'/candidates-north/">North (Avonmouth &amp; Kingsweston; Henbury &amp; Southmead; Henleaze, Stoke Bishop &amp; Westbury-On-Trym; Horfield &amp; Lockleaze; Bishopston, Cotham &amp; Redland; Cabot, Clifton &amp; Clifton East)</a></li>
	<li><a title="Candidates – South" href="'.$url.'/candidates-south/">South (Greater Bedminster; Filwood, Knowle &amp; Windmill Hill; Brislington; Hengrove &amp; Stockwood; Dundry View)</a></li>
	<li><a title="Candidates – East Central" href="'.$url.'/candidates-east-central/">East Central (Greater Fishponds; Ashley, Easton &amp; Lawrence Hill; St George)</a></li>
</ul></object>';
}
add_shortcode('formandmap','map_shortcode');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function bristolbigyouthvote_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'bristolbigyouthvote' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'bristolbigyouthvote_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bristolbigyouthvote_scripts() {
	wp_enqueue_style( 'bristolbigyouthvote-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bristolbigyouthvote-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'bristolbigyouthvote-main', get_template_directory_uri() . '/js/main.js', array(), '20141216', true );

	wp_enqueue_script( 'bristolbigyouthvote-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_localize_script('bristolbigyouthvote-main', 'wpBaseURL', array( 'siteurl' => get_option('siteurl') ));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bristolbigyouthvote_scripts' );


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
