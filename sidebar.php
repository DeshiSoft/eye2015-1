<?php
/**
 * Sidebar template containing the primary and secondary widget areas
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */
?>

<div id="sidebar" class="widget-area" role="complementary">

<?php
	/*
	 * When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

			<div id="search" class="widget-container widget_search well">
				<?php get_search_form(); ?>
			</div>

			<div id="archives" class="widget-container well">
				<h3 class="widget-title"><?php _e( 'Archives', 'eye2015' ); ?></h3>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</div>

			<div id="meta" class="widget-container well">
				<h3 class="widget-title"><?php _e( 'Meta', 'eye2015' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</div>

		<?php endif; // end primary widget area ?>

</div><!-- #sidebar .widget-area -->

<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

		<div id="sidebar-2" class="widget-area" role="complementary">
			<div class="xoxo">
				<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
			</div>
		</div><!-- #sidebar-2 .widget-area -->

<?php endif; ?>
