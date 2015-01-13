<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Adirondack
 */

if ( ! function_exists( 'adirondack_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function adirondack_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'adirondack' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'adirondack' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'adirondack' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'adirondack_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function adirondack_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'adirondack' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'adirondack' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'adirondack' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'adirondack_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time
 */
function adirondack_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$label = '';

	switch ( get_post_status() ){
		case 'future':
			$label = __( 'Scheduled', 'adirondack' );
			break;

		case 'pending':
			$label = __( 'Pending Review', 'adirondack' );
			break;

		case 'private':
			$label = __( 'Privately published', 'adirondack' );
			break;

		case 'draft':
		case 'auto-draft':
			printf( '<h4 class="meta-title">%s</h4>', __( 'Draft', 'adirondack' ) );
			return;

		case 'inherit':
		case 'publish':
		default:
			$label = __( 'Published', 'adirondack' );
			break;
	}

	echo '<div class="meta-item">';
	printf( '<h4 class="meta-title">%s</h4>', $label );

	echo '<span class="posted-on">' . $time_string . '</span>';
	echo '</div>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="updated" datetime="%1$s">%2$s</time>';
		$time_string = sprintf( $time_string,
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<div class="meta-item">';
		printf( '<h4 class="meta-title">%s</h4>', __( 'Updated', 'adirondack' ) );

		echo '<span class="posted-on">' . $time_string . '</span>';
		echo '</div>';
	}

	echo '<div class="meta-item author">';
	printf( '<h4 class="meta-title">%s</h4>', _x( 'Author', 'Label for author name on post', 'adirondack' ) );

	printf( '<span class="author vcard"><a class="url fn n" href="%s">%s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
	echo '</div>';
}
endif;

/**
 * Output the class attribute, to be used on the widget container.
 *
 * @return void
 */
function adirondack_widgets_class( $extra_classes = '' ){
	$classes = array( 'widget-area', $extra_classes );

	$widgets = wp_get_sidebars_widgets();
	$widget_count = isset( $widgets['sidebar-1'] )? count( $widgets['sidebar-1'] ): 0;
	$classes[] = 'count-' . $widget_count;

	$classes = apply_filters( 'adirondack_widgets_class', $classes );

	printf( 'class="%s"', esc_attr( implode( ' ', $classes ) ) );
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function adirondack_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'adirondack_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'adirondack_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so adirondack_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so adirondack_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in adirondack_categorized_blog.
 */
function adirondack_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'adirondack_categories' );
}
add_action( 'edit_category', 'adirondack_category_transient_flusher' );
add_action( 'save_post',     'adirondack_category_transient_flusher' );
