<?php
/**
 * The loop that displays a single post
 *
 * The loop displays the posts and the post content. See
 * https://codex.wordpress.org/The_Loop to understand it and
 * https://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage EYE_2015
 * @since EYE 2015 1.2
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<nav>
                	<ul class="pager">
					<li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'eye2015' ) . '</span> %title' ); ?></li>
					<li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'eye2015' ) . '</span>' ); ?></li>
                    </ul>
				</nav><!-- nav -->

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                	<div class="page-header">
						<h1><?php the_title(); ?></h1>
                        <small><?php eye2015_posted_on(); ?></small>
                    </div>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'eye2015' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<div id="entry-author-info">
						<div id="author-avatar">
							<?php
							/** This filter is documented in author.php */
							echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'eye2015_author_bio_avatar_size', 60 ) );
							?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php printf( __( 'About %s', 'eye2015' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
							<div id="author-link">
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
									<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'eye2015' ), get_the_author() ); ?>
								</a>
							</div><!-- #author-link	-->
						</div><!-- #author-description -->
					</div><!-- #entry-author-info -->
<?php endif; ?>

					<div class="entry-utility">
						<?php eye2015_posted_in(); ?>
						<?php edit_post_link( __( '<span class="glyphicon glyphicon-erase"></span> Edit', 'eye2015' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->
				</div><!-- #post-## -->

				<nav>
                	<ul class="pager">
						<li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'eye2015' ) . '</span> %title' ); ?></li>
						<li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'eye2015' ) . '</span>' ); ?></li>
					</ul><!-- .pager -->
                </nav>

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
