<?php
/**
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
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'adirondack' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'adirondack' ) );

			adirondack_posted_on();
		?>

		<?php if ( '' != $tag_list ) : ?>
			<div class="meta-item tags">
				<h4 class="meta-title"><?php _e( 'Tags', 'adirondack' ); ?></h4>
				<?php echo $tag_list; ?>
			</div>
		<?php endif; ?>

		<?php if ( adirondack_categorized_blog() && ( '' != $category_list ) ) : ?>
			<div class="meta-item categories">
				<h4 class="meta-title"><?php _e( 'Categories', 'adirondack' ); ?></h4>
				<?php echo $category_list; ?>
			</div>
		<?php endif; ?>

		<div class="meta-item bookmark">
			<h4 class="meta-title"><?php _e( 'Bookmark', 'adirondack' ); ?></h4>
			<?php printf( '<a href="%s" rel="bookmark">%s</a>', esc_url( get_permalink() ), __( 'Permalink', 'adirondack' ) ); ?>
		</div>

		<?php edit_post_link( __( 'Edit this page', 'adirondack' ), '<div class="meta-item edit"><h4 class="meta-title">' . __( 'For the author', 'adirondack' ) . '</h4><span class="edit-link">', '</span></div>' ); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
