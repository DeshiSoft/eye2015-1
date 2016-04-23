<?php
/**
 * Template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
	 * Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>

			<h1 class="page-title">
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: <span>%s</span>', 'eye2015' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'eye2015' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'eye2015' ) ) ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'eye2015' ), get_the_date( _x( 'Y', 'yearly archives date format', 'eye2015' ) ) ); ?>
<?php else : ?>
				<?php _e( 'Blog Archives', 'eye2015' ); ?>
<?php endif; ?>
			</h1>

<?php
	/*
	 * Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/*
	 * Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archive.php and that will be used instead.
	 */
	get_template_part( 'loop', 'archive' );
?>

        </div>
     	<div class="col-md-3 col-sm-4 col-xs-12">
			<?php get_sidebar(); ?>
		</div><!-- .col -->
    </div><!-- .row  -->
</div><!-- .container -->

<?php get_footer(); ?>