<?php
/**
 * Template for displaying attachments
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */

get_header(); ?>

<div class="container">
	<div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">

			<?php
			/*
			 * Run the loop to output the attachment.
			 * If you want to overload this in a child theme then include a file
			 * called loop-attachment.php and that will be used instead.
			 */
			get_template_part( 'loop', 'attachment' );
			?>

        </div><!-- .col -->
    </div><!-- .row  -->
</div><!-- .container -->

<?php get_footer(); ?>

