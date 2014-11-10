<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Adirondack
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" role="complementary" <?php adirondack_widgets_class(); ?>>
	<div class="wrapper">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</div><!-- #secondary -->
