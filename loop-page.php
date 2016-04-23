<?php
/**
 * The loop that displays a page
 *
 * The loop displays the posts and the post content. See
 * https://codex.wordpress.org/The_Loop to understand it and
 * https://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.2
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
                    	<div class="page-header">
  							<h2><?php the_title(); ?></h2>
						</div>
					<?php } else { ?>
                    	<ol class="breadcrumb"><?php echo breadcrumbs(); ?></ol>
                        <div class="page-header">
  							<h1><?php the_title(); ?></h1>
						</div>
					<?php } ?>
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'eye2015' ), 'after' => '</div>' ) ); ?>
					<?php edit_post_link( __( '<span class="glyphicon glyphicon-erase"></span> Edit', 'eye2015' ), '', '' ); ?>

				</div><!-- #post-## -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
