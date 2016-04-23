<?php
/**
 * EYE2015 functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, eye2015_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see https://codex.wordpress.org/Theme_Development and
 * https://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'eye2015_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see https://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 
/*-------------------------------------------------------------------------------
 		Register CSS Styles 
---------------------------------------------------------------------------------*/
function register_css_styles() {
	if (!is_admin()) {
		wp_register_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
		wp_register_style('theme-style', get_stylesheet_uri(), array(), '1.0.0', 'screen, print');
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('theme-style');
		
		// Only use for IE8 (if needed in future)
		// wp_register_style('ie-css',  get_template_directory_uri() . '/css/ie-css.min.css' );
		// wp_enqueue_style('ie-css');
		// wp_style_add_data('ie-css', 'conditional', 'if lt IE 9' );
		
	}
}
add_action('wp_enqueue_scripts', 'register_css_styles');

/*-------------------------------------------------------------------------------
 		Register JS Scripts
---------------------------------------------------------------------------------*/
function register_js_scripts() {
	if (!is_admin()) {
		wp_register_script('jquery.min', get_template_directory_uri() . '/bootstrap/js/jquery.min.js', array(), '1.10.2', true);
		wp_register_script('bootstrap.min', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(), '3.3.4', true);
		wp_register_script('script', get_template_directory_uri() . '/bootstrap/js/custom.js', array('jquery'), '1.0.0', true);
		
		wp_localize_script('script', 'eye_script', array( 
			'theme_url' => 							get_template_directory_uri(), 
			'site_url' => 							get_site_url() . '/'
		));

		wp_enqueue_script('jquery.min');
		wp_enqueue_script('bootstrap.min');
		wp_enqueue_script('script');
		
		// Only use for IE8
		wp_register_script('excanvas',  get_template_directory_uri() . '/bootstrap/js/ie8/excanvas.min.js' );
		wp_register_script('html5shiv',  get_template_directory_uri() . '/bootstrap/js/ie8/html5shiv.min.js' );
		wp_register_script('respond',  get_template_directory_uri() . '/bootstrap/js/ie8/respond.min.js' );
		wp_enqueue_script('excanvas');
		wp_enqueue_script('html5shiv');
		wp_enqueue_script('respond');
		wp_script_add_data('excanvas', 'conditional', 'if lt IE 9' );
		wp_script_add_data('html5shiv', 'conditional', 'if lt IE 9' );
		wp_script_add_data('respond', 'conditional', 'if lt IE 9' );
	
	}
}
add_action('wp_enqueue_scripts', 'register_js_scripts');

/*-------------------------------------------------------------------------------
 		Add Feature Link 
---------------------------------------------------------------------------------*/
include_once('inc/widgets/register-widgets.php');
// Register Custom Navigation Walker
require_once('inc/wp_bootstrap_navwalker.php');
require_once('inc/pagination.php');
require_once('inc/breadcrumbs.php');
require_once('inc/likes-posttype.php');
require_once('inc/likes.php');

/*
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/* Tell WordPress to run eye2015_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'eye2015_setup' );

if ( ! function_exists( 'eye2015_setup' ) ):
/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override eye2015_setup() in a child theme, add your own eye2015_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support()        To add support for post thumbnails, custom headers and backgrounds, and automatic feed links.
 * @uses register_nav_menus()       To add support for navigation menus.
 * @uses add_editor_style()         To style the visual editor.
 * @uses load_theme_textdomain()    For translation/localization support.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size()  To set a custom post thumbnail size.
 *
 * @since EYE 2015 1.0
 */
function eye2015_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );


	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'eye2015', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'eye2015' ),
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		'default-color' => 'f1f1f1',
	) );

	// The custom header business starts here.

	$custom_header_support = array(
		/*
		 * The default image to use.
		 * The %s is a placeholder for the theme template directory URI.
		 */
		'default-image' => '%s/images/headers/path.jpg',
		// The height and width of our custom header.
		/**
		 * Filter the EYE 2015 default header image width.
		 *
		 * @since EYE 2015 1.0
		 *
		 * @param int The default header image width in pixels. Default 940.
		 */
		'width' => apply_filters( 'eye2015_header_image_width', 940 ),
		/**
		 * Filter the EYE 2015 defaul header image height.
		 *
		 * @since EYE 2015 1.0
		 *
		 * @param int The default header image height in pixels. Default 198.
		 */
		'height' => apply_filters( 'eye2015_header_image_height', 198 ),
		// Support flexible heights.
		'flex-height' => true,
		// Don't support text inside the header image.
		'header-text' => false,
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'eye2015_admin_header_style',
	);

	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', '' );
		define( 'NO_HEADER_TEXT', true );
		define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
		add_custom_background();
	}

	/*
	 * We'll be using post thumbnails for custom header images on posts and pages.
	 * We want them to be 940 pixels wide by 198 pixels tall.
	 * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	 */
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// ... and thus ends the custom header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'eye2015' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'eye2015' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'eye2015' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'eye2015' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'eye2015' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'eye2015' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'eye2015' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'eye2015' )
		)
	) );
}
endif;

if ( ! function_exists( 'eye2015_admin_header_style' ) ) :
/**
 * Style the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in eye2015_setup().
 *
 * @since EYE 2015 1.0
 */
function eye2015_admin_header_style() {
?>
<style type="text/css" id="eye2015-admin-header-css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If header-text was supported, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Show a home link for our wp_nav_menu() fallback, wp_page_menu().
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since EYE 2015 1.0
 *
 * @param array $args An optional array of arguments. @see wp_page_menu()
 */
function eye2015_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'eye2015_page_menu_args' );

/**
 * Set the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since EYE 2015 1.0
 *
 * @param int $length The number of excerpt characters.
 * @return int The filtered number of excerpt characters.
 */
function eye2015_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'eye2015_excerpt_length' );

if ( ! function_exists( 'eye2015_continue_reading_link' ) ) :
/**
 * Return a "Continue Reading" link for excerpts.
 *
 * @since EYE 2015 1.0
 *
 * @return string "Continue Reading" link.
 */
function eye2015_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'eye2015' ) . '</a>';
}
endif;

/**
 * Replace "[...]" with an ellipsis and eye2015_continue_reading_link().
 *
 * "[...]" is appended to automatically generated excerpts.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since EYE 2015 1.0
 *
 * @param string $more The Read More text.
 * @return string An ellipsis.
 */
function eye2015_auto_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		return ' &hellip;' . eye2015_continue_reading_link();
	}
	return $more;
}
add_filter( 'excerpt_more', 'eye2015_auto_excerpt_more' );

/**
 * Add a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since EYE 2015 1.0
 *
 * @param string $output The "Coninue Reading" link.
 * @return string Excerpt with a pretty "Continue Reading" link.
 */
function eye2015_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() && ! is_admin() ) {
		$output .= eye2015_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'eye2015_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in EYE 2015's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since EYE 2015 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since EYE 2015 1.0
 * @deprecated Deprecated in EYE 2015 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function eye2015_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'eye2015_remove_gallery_css' );

if ( ! function_exists( 'eye2015_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own eye2015_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since EYE 2015 1.0
 *
 * @param object $comment The comment object.
 * @param array  $args    An array of arguments. @see get_comment_reply_link()
 * @param int    $depth   The depth of the comment.
 */
function eye2015_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'eye2015' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'eye2015' ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'eye2015' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'eye2015' ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<span class="glyphicon glyphicon-comment"></span> 
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'eye2015' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'eye2015' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override eye2015_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since EYE 2015 1.0
 *
 * @uses register_sidebar()
 */
function eye2015_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'eye2015' ),
		'id' => 'primary-widget-area',
		//'class'         => 'list-group',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'eye2015' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s well">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'eye2015' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'An optional secondary widget area, displays below the primary widget area in your sidebar.', 'eye2015' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s well">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'eye2015' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'eye2015' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s well">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'eye2015' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'eye2015' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s well">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'eye2015' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'eye2015' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s well">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'eye2015' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'eye2015' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s well">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running eye2015_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'eye2015_widgets_init' );

/**
 * Remove the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using EYE 2015 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default EYE 2015 styling.
 *
 * @since EYE 2015 1.0
 */
function eye2015_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'eye2015_remove_recent_comments_style' );

if ( ! function_exists( 'eye2015_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since EYE 2015 1.0
 */
function eye2015_posted_on() {
	printf( __( '<span class="glyphicon glyphicon-time %1$s"></span> %2$s <span class="glyphicon glyphicon-user"></span> %3$s', 'eye2015' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'eye2015' ), get_the_author() ) ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'eye2015_posted_in' ) ) :
/**
 * Print HTML with meta information for the current post (category, tags and permalink).
 *
 * @since EYE 2015 1.0
 */
function eye2015_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( '<span class="glyphicon glyphicon-list-alt"></span> %1$s  <span class="glyphicon glyphicon-tag"></span> %2$s. <span class="glyphicon glyphicon-bookmark"></span> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'eye2015' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<span class="glyphicon glyphicon-list-alt"></span> %1$s. <span class="glyphicon glyphicon-bookmark"></span> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'eye2015' );
	} else {
		$posted_in = __( '<span class="glyphicon glyphicon-bookmark"></span> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'eye2015' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/**
 * Retrieve the IDs for images in a gallery.
 *
 * @uses get_post_galleries() First, if available. Falls back to shortcode parsing,
 *                            then as last option uses a get_posts() call.
 *
 * @since EYE 2015 1.6.
 *
 * @return array List of image IDs from the post gallery.
 */
function eye2015_get_gallery_images() {
	$images = array();

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) )
			$images = explode( ',', $galleries[0]['ids'] );
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );
		if ( isset( $atts['ids'] ) )
			$images = explode( ',', $atts['ids'] );
	}

	if ( ! $images ) {
		$images = get_posts( array(
			'fields'         => 'ids',
			'numberposts'    => 999,
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_mime_type' => 'image',
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
		) );
	}

	return $images;
}

/* Register wp_title() Home Function */
function eye2015_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'eye2015_wp_title', 10, 2 );

/**
* Default Menu Fallback
  http://codex.wordpress.org/Function_Reference/wp_nav_menu
function default_menu()
{ 
	$defaults = array(
		'items_wrap'      => '<ul id="%1$s" class="nav navbar-nav">%3$s</ul>'
	);
	wp_nav_menu( $defaults );
}
*/

if(!function_exists('default_menu')){ 
    function default_menu($args){
        $current = "";
		if (is_front_page()){$current = "class='current-menu-item'";} 
		echo "<ul class='nav navbar-nav'>";
		echo "<li $current><a href='".home_url()."'>Home</a></li>";
		wp_list_pages('title_li=&sort_column=menu_order&number=4&depth=0');
		echo "</ul>";
    }
}

function eye2015_scripts() {
	/*
	 * We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
}
add_action( 'wp_enqueue_scripts', 'eye2015_scripts' );

// Customize the search form
function style_search_form($form) {
    $form = '
    	<form method="get" id="searchform" action="' . get_option('home') . '/" >
            <label for="s">' . __('') . '</label>
            <div class="input-group input-group-sm">';
    if (is_search()) {
        $form .='<input type="text" class="form-control" value="' . attribute_escape(apply_filters('the_search_query', get_search_query())) . '" name="s" id="s" />';
    } else {
        $form .='<input type="text" class="form-control" value="Search this site" name="s" id="s"  onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
    }
    $form .= '		<div class="input-group-btn">
    					<input type="submit" class="btn btn-default" id="searchsubmit" value="'.attribute_escape(__('Go')).'" />
    				</div>
            	</div>
            </form>';
    return $form;
}
add_filter('get_search_form', 'style_search_form');

/* Get Title Function */
function eye_title($eye_id, $show = true) { 
	$eye_heading = get_post_meta($eye_id, 'eye_heading', true);	
	$eye_heading_title = get_post_meta($eye_id, 'eye_heading_title', true);
	$out = '';
	if ($eye_heading == 'custom' && $eye_heading_title != '') {
		$out .= $eye_heading_title;
	} else {
		$out .= esc_attr(strip_tags(get_the_title($eye_id) ? get_the_title($eye_id) : $eye_id));
	} 
    if ($show) {
        echo $out;
    } else {
        return $out;
    }
}

/*define('EYE_SHORTNAME', 'eye2015');
 Get Posts Like Function 
function eye_post_like($template_type = 'page', $show = true) {
	if ($template_type == 'page') {
		$out = eyeLike(false);
	} elseif ($template_type == 'post') {
		$eye_option = eye_get_global_options();
		$out = '';
		
		if ($eye_option[EYE_SHORTNAME . '_blog_post_like']) {
			$out = eyeLike(false);
		}
	}
	
	
	if ($show) {
		echo $out;
	} else {
		return $out;
	}
}*/
