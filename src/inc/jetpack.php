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

	add_theme_support( 'featured-content', array(
		'filter'     => 'adirondack_get_featured_content',
		'max_posts'  => 1,
		'post_types' => array( 'post' ),
	) );
}
add_action( 'after_setup_theme', 'adirondack_jetpack_setup' );

/**
 * Pull featured content from Jetpack
 */
function adirondack_get_featured_posts(){
	return apply_filters( 'adirondack_get_featured_content', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function adirondack_has_featured_posts() {
	return ! is_paged() && (bool) adirondack_get_featured_posts();
}

