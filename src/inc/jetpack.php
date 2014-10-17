<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Adirondack
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function adirondack_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'click',
		'container'      => 'main',
		'footer'         => 'page',
		'posts_per_page' => 12,
	) );
}
add_action( 'after_setup_theme', 'adirondack_jetpack_setup' );
