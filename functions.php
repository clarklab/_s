<?php
/**
 * _s functions and definitions
 *
 * @package _s
 * @since _s 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since _s 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( '_s_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since _s 1.0
 */
function _s_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom post types for use in this theme
	 */
	
	require( get_template_directory() . '/inc/post-types.php');

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', '_s' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
* Add support for uploading PSDs (or anything added in this array)
*/

function addUploadMimes($mimes) {
    $mimes = array_merge($mimes, array(
        'psd' => 'application/photoshop'
    ));

    return $mimes;
}
add_filter('upload_mimes', 'addUploadMimes');

/**
* Function for listing attachments of a post
*/

function get_attachments() {
	global $post;
	$files = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

	$results = array();

	if ($files) {
		foreach ($files as $file) {
			$path = wp_get_attachment_url($file->ID);
			$path_parts = pathinfo($path);
			$results[].= '<li><a class="'.$path_parts[extension].'" href="'.$path.'">'.$path_parts[basename].'</a></li>';
		}
	}
	return $results;
}

/**
* Shortcode for creating inline screenshot previews of a given URL
*/

add_shortcode('site', 'site_shortcode');  
  
function site_shortcode($atts){  

extract( shortcode_atts( array(
		'width' => '300',
		'height' => '300',
		'align' => 'none',
		'title' => 'The Internet',
		'url' => 'http://google.com'
	), $atts ) ); 
  
  if ($url != ''){  
  
    $query_url =  'http://s.wordpress.com/mshots/v1/' . urlencode($url) . '?w=' . $width;  
  
    $image_tag = '<img class="ss_screenshot_img" alt="' . $url . '" width="' . $width . '" src="' . $query_url . '" />';  
	$widthedge = ($width-8);
	$heightedge = ($height-10);
	echo '<div class="site align'.$align.'" style="width:'.$widthedge.'px; height:'.$heightedge.'px;"><a href="'.$url.'"><span class="title">'.$title.'</span>' . $image_tag . '</a></div>'; 
  
  }else{  
  
    echo 'Bad screenshot url!';  
  
  }  
}

/**
* Shortcode for inserting code (from our CPT) into a post
*/

function include_code($atts) {
  
  $thepostid = intval($atts[id]);
  $output = '';

  query_posts('p='.$thepostid.'&post_type=code');
  if (have_posts()) : while (have_posts()) : the_post();
  $code_language = get_post_meta($post->ID, "clark_code_language", true);
    $output .= get_the_content($post->ID);
  endwhile; else:
    return "fail!";
  endif;
  wp_reset_query();
if ($code_language = "php"){
  return '<pre name="code" class="php">&lt;?php '.$output.' ?&gt;</pre>';
}

}

add_shortcode("code", "include_code");

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since _s 1.0
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', '_s' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _s_scripts() {
	global $post;
	
	wp_enqueue_style( 'font-prata', 'http://fonts.googleapis.com/css?family=Prata' );
	
	wp_enqueue_style( 'font-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'sidebar-content', get_template_directory_uri() . '/layouts/sidebar-content.css' );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );
