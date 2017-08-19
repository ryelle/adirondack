<?php
/**
 * Gutenberg Compatibility File
 *
 * @package Adirondack
 */

function adirondack_add_gutenberg_support() {
	add_theme_support( 'gutenberg', array(
		'wide-images' => true,
		'colors' => array(
			'#1C2026',
			'#2A3644',
			'#5d6876',
			'#A5BCD4',
			'#D7E5F3',
		),
	) );
}
add_action( 'after_setup_theme', 'adirondack_add_gutenberg_support' );
