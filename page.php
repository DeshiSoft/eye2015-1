<?php
/**
 * Template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */

get_header(); ?>

<div class="container">
	<div class="row">
    	<div class="col-md-9 col-sm-8 col-xs-12">
			<?php
            /*
             * Run the loop to output the page.
             * If you want to overload this in a child theme then include a file
             * called loop-page.php and that will be used instead.
             */
            get_template_part( 'loop', 'page' );
            ?>
        </div><!-- .col -->
     	<div class="col-md-3 col-sm-4 col-xs-12">
			<?php get_sidebar(); ?>
		</div><!-- .col -->
    </div><!-- .row  -->
</div><!-- .container -->

<?php get_footer(); ?>
