<?php
/**
 * Template Name: Full Width
 *
 * The template for displaying a full width page.
 *
 * When this template is used, the sidebar will drop to the bottom of the page.
 *
 * @package Adirondack
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	?>

<?php get_footer(); ?>
