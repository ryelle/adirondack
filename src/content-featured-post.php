<?php
/**
 * @package Adirondack
 */
?>

<?php if ( has_post_thumbnail() ) :
	$image_id = get_post_thumbnail_id();
	$url = wp_get_attachment_image_src( $image_id, 'header-image' );
	$url = apply_filters( 'jetpack_photon_url', $url[0], array( 'width' => 1400, 'zoom' => 2 ), null );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: url(<?php echo esc_attr( $url ); ?>) no-repeat center; background-size: cover;">
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="entry-link">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</a>
</article><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>
