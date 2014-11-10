<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Adirondack
 */
?>

<?php if ( has_post_thumbnail() ) :
	$image_id = get_post_thumbnail_id();
	$url = wp_get_attachment_image_src( $image_id, 'header-image' );

	if ( $url[1] < 800 ) { // Width
		printf( '<div class="entry-image">%s</div>', get_the_post_thumbnail( get_the_ID(), 'header-image' ) );
	} elseif ( $url[2] < 800 ) { // Height
		printf( '<div class="entry-image panorama">%s</div>', get_the_post_thumbnail( get_the_ID(), 'header-image' ) );
	} else {
		printf( '<div class="entry-image full-width" style="background-image:url(\'%s\');"></div>', esc_attr( $url[0] ) );
	}

else: ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	<?php endif; ?>

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
		<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
			<div class="meta-item comments">
				<h4 class="meta-title"><?php _e( 'Comments', 'adirondack' ); ?></h4>
				<a href="#comments" class="toggle-comments text" data-show="<?php esc_attr_e( 'View comments', 'adirondack' ); ?>" data-hide="<?php esc_attr_e( 'Hide comments', 'adirondack' ); ?>"></a>
			</div>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit this page', 'adirondack' ), '<div class="meta-item edit"><h4 class="meta-title">' . __( 'For the author', 'adirondack' ) . '</h4><span class="edit-link">', '</span></div>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
