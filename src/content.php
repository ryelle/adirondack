<?php
/**
 * @package Adirondack
 */
?>

<?php if ( has_post_thumbnail() ) :
	$image_id = get_post_thumbnail_id();
	$url = wp_get_attachment_image_src( $image_id, 'post-thumbnail' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'has-image post-grid' ); ?> style="background: url(<?php echo esc_attr( $url[0] ); ?>) no-repeat center; background-size: cover;">
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="entry-link">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="link-button"><span>View more</span></div>
	</a>
</article><!-- #post-<?php the_ID(); ?> -->

<?php else: ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'no-image post-grid' ); ?>>
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="entry-link">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<span>View more</span>
	</a>
</article><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>
