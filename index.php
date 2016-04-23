<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
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
			 * Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			//get_template_part( 'loop', 'index' );
				if (have_posts()) :
					while (have_posts()) : the_post();
						if (get_post_format() != '') {
							get_template_part('inc/blog/page/default/' . get_post_format());
						} else {
							get_template_part('inc/blog/page/default/standard');
						}
					endwhile;
					echo pagination();
				endif;
            ?>
			<?php /* Display navigation to next/previous pages when applicable */ ?>
            <?php /*if (  $wp_query->max_num_pages > 1 ) : ?>
                <nav>
                    <ul class="pager">
                        <li class="previous">
						<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'eye2015' ) ); ?></li>
                        <li class="next">
						<?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'eye2015' ) ); ?></li>
                    </ul><!-- .pager -->
                </nav>
            <?php endif;*/ ?>
        </div><!-- .col -->
     	<div class="col-md-3 col-sm-4 col-xs-12">
			<?php get_sidebar(); ?>
		</div><!-- .col -->
    </div><!-- .row  -->
</div><!-- .container -->

<?php get_footer(); ?>
