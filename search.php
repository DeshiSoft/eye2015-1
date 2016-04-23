<?php
/**
 * Template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */

get_header(); ?>

<div class="container">
	<div class="row">
    	<div class="col-md-9 col-sm-8 col-xs-12">

<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'eye2015' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php
				/*
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'eye2015' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'eye2015' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
        
        </div><!-- .col -->
     	<div class="col-md-3 col-sm-4 col-xs-12">
			<?php get_sidebar(); ?>
		</div><!-- .col -->
    </div><!-- .row  -->
</div><!-- .container -->

<?php get_footer(); ?>

