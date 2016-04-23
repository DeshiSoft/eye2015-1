<?php
/**
 * Header template for our theme
 *
 * Displays all of the <head> section.
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri();?>/bootstrap/img/favicon.ico">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrapper" class="hfeed">
    
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            <span>
                <small><em><?php //bloginfo( 'description' ); ?></em></small>
            <span>
        </div><!--/.navbar-header -->

        <div class="navbar-collapse collapse">	
            <ul class="nav navbar-nav">
                <!-- menu li -->
               <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary', 
                        //'depth'             => 3,
                        'container'         => '',
                        'container_class'   => '',
                        'menu_class'        => '',
                        'items_wrap'		=> '%3$s',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'walker'            => new wp_bootstrap_navwalker())
                    );
                ?>
                <!-- End menu li -->
            </ul>
            
            <form class="navbar-form navbar-right" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            	<div class="input-group">
                  <input type="text" class="form-control" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" id="s">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                  </span>
                </div><!-- /input-group -->
            </form>
            
        </div><!-- /.nav-collapse -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->

<div class="container" style="display:none;">
<?php
	// Compatibility with versions of WordPress prior to 3.4.
	if ( function_exists( 'get_custom_header' ) ) {
		/*
		 * We need to figure out what the minimum width should be for our featured image.
		 * This result would be the suggested width if the theme were to implement flexible widths.
		 */
		$header_image_width = get_theme_support( 'custom-header', 'width' );
	} else {
		$header_image_width = HEADER_IMAGE_WIDTH;
	}

	// Check if this is a post or page, if it has a thumbnail, and if it's a big one
	if ( is_singular() && current_theme_supports( 'post-thumbnails' ) &&
			has_post_thumbnail( $post->ID ) &&
			( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) &&
			$image[1] >= $header_image_width ) :
		// Houston, we have a new header image!
		echo get_the_post_thumbnail( $post->ID );
	elseif ( get_header_image() ) :
		// Compatibility with versions of WordPress prior to 3.4.
		if ( function_exists( 'get_custom_header' ) ) {
			$header_image_width  = get_custom_header()->width;
			$header_image_height = get_custom_header()->height;
		} else {
			$header_image_width  = HEADER_IMAGE_WIDTH;
			$header_image_height = HEADER_IMAGE_HEIGHT;
		}
	?>
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( $header_image_width ); ?>" height="<?php echo esc_attr( $header_image_height ); ?>" alt="" />
	<?php endif; ?>
</div>