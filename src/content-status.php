<?php
/**
 * @package Adirondack
 */
?>

<?php if ( has_post_thumbnail() ) :
	$image_id = get_post_thumbnail_id();
	$url = wp_get_attachment_image_src( $image_id, 'post-thumbnail' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: url(<?php echo esc_attr( $url[0] ); ?>) no-repeat center; background-size: cover;">
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="entry-link">
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<div class="link-button"><span>View more</span></div>
	</a>
</article><!-- #post-<?php the_ID(); ?> -->

<?php else: ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="entry-link">
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<div class="link-button"><span>View more</span></div>
	</a>
</article><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>
