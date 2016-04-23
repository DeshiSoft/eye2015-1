<?php
/**
 * Template for displaying Category Archive pages
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */

get_header(); ?>

<div class="container">
	<div class="row">
    	<div class="col-md-9 col-sm-8 col-xs-12">

				<h1 class="page-title"><?php
					printf( __( 'Category Archives: %s', 'eye2015' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				/*
				 * Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>

        </div><!-- .col -->
     	<div class="col-md-3 col-sm-4 col-xs-12">
			<?php get_sidebar(); ?>
		</div><!-- .col -->
    </div><!-- .row  -->
</div><!-- .container -->

<?php get_footer(); ?>
