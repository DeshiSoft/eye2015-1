<?php
/**
 * Template for displaying the footer
 *
 * Contains the closing of the id=main div and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.0
 */
?>

	<div class="footer">
    	<div class="container">
        	<?php
				/*
				 * A sidebar in the footer? Yep. You can can customize
				 * your footer with four columns of widgets.
				 */
				get_sidebar( 'footer' );
			?>
        	<p class="text-muted text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> |
                <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'eye2015' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'eye2015' ); ?>"><?php printf( __( 'Powered by %s.', 'eye2015' ), 'TemplateEYE' ); ?></a></p>
		</div>
    </div><!-- .footer -->
	<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
</div><!-- #wrapper -->

<style>.back-to-top { cursor: pointer;position: fixed; bottom: 7px; right: 20px;display:none;}</style>
<?php
	/*
	 * Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
</body>
</html>
