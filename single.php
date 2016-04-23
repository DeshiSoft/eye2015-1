<?php
/**
 * Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */

get_header(); ?>

<div class="container">
	<div class="row">
    	<div class="col-md-9">
			<?php
			/*
			 * Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			//get_template_part( 'loop', 'single' );
				if (have_posts()) :
					while (have_posts()) : the_post();
						if (get_post_format() != '') {
							get_template_part('inc/blog/post/default/' . get_post_format());
						} else {
							get_template_part('inc/blog/post/default/standard');
						}
					endwhile;
				endif;
			?>
        </div>
     	<div class="col-md-3">
			<?php get_sidebar(); ?>
		</div>
    </div>
</div>

<?php get_footer(); ?>
