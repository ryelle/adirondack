<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Adirondack
 */
?>

<?php if ( has_post_thumbnail() ) :
	$image_id = get_post_thumbnail_id();
	$url = wp_get_attachment_image_src( $image_id, 'full' ); ?>
	<div class="entry-image" style="background-image:url('<?php echo esc_attr($url[0]); ?>');"></div>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="wrapper">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'adirondack' ),
					'after'  => '</div>',
				) );
			?>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="meta-item bookmark">
			<h4 class="meta-title"><?php _e( 'Bookmark', 'adirondack' ); ?></h4>
			<?php printf( '<a href="%s" rel="bookmark">%s</a>', esc_url( get_permalink() ), __( 'Permalink', 'adirondack' ) ); ?>
		</div>

		<?php edit_post_link( __( 'Edit this page', 'adirondack' ), '<div class="meta-item edit"><h4 class="meta-title">' . __( 'For the author', 'adirondack' ) . '</h4><span class="edit-link">', '</span></div>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
