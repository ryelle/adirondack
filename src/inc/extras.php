<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Adirondack
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function adirondack_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'adirondack_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function adirondack_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_singular() ) {
		$classes[] = 'singular';

		if ( ! has_post_thumbnail() ) {
			$classes[] = 'no-image';
		}

		if ( comments_open() || '0' != get_comments_number() ) {
			$classes[] = 'has-comments';
		} else {
			$classes[] = 'no-comments';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'adirondack_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post's article element.
 * @return array
 */
function adirondack_post_classes( $classes ) {
	global $in_featured;

	if ( is_home() || is_archive() ) {
		if ( isset( $in_featured ) && $in_featured ) {
			$classes[] = 'featured-post';
		} else {
			$classes[] = 'post-grid';
		}

		if ( ! has_post_thumbnail() ) {
			$classes[] = 'no-image';
		} else {
			// Back-compat for <3.9, when .has-post-thumbnail was introduced.
			$classes[] = 'has-post-thumbnail';
		}
	}

	return $classes;
}
add_filter( 'post_class', 'adirondack_post_classes' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function adirondack_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'adirondack_setup_author' );

/**
 * Get the bare-minimum attributes for our SVG file, so we have some
 * control over our output.
 *
 * @return  array  Array of tags => properties that will be used in wp_kses.
 */
function adirondack_allowed_svg(){
	$allowed_svg = array(
		'svg' => array( 'viewbox' => true ),
		'symbol' => array( 'viewbox' => true, 'id' => true, 'fill' => true ),
		'title' => array(),
		'polygon' => array( 'points' => true ),
		'path' => array( 'd' => true ),
	);
	return apply_filters( 'adirondack_allowed_svg', $allowed_svg );
}

/**
 * Load the SVG file in the header, right after the <body> tag.
 * To load your own icons in a child theme, you can remove this using
 *  `remove_action( 'adirondack_load_svg', 'adirondack_load_svg' );
 * and add your own SVG sprite using the `adirondack_load_svg` hook.
 */
function adirondack_load_svg() {
	ob_start();
	include_once( get_template_directory() . '/images/sprite.svg' );
	$svg = ob_get_clean();

	$svg = wp_kses( $svg, adirondack_allowed_svg() );

	printf( '<div style="display:none">%s</div>', $svg );
}
add_action( 'adirondack_load_svg', 'adirondack_load_svg' );

/**
 * Shrink excerpt length
 * @return int Number of words to display
 */
function adirondack_excerpt_length( $len ) {
	if ( is_search() ) {
		return 48;
	} elseif ( ( 'status' == get_post_format() ) ) {
		return 24;
	}
	return 12;
}
add_filter( 'excerpt_length', 'adirondack_excerpt_length', 999 );

function adirondack_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'adirondack_excerpt_more');

/**
 * Custom display for comments
 */

/**
 * Comment display callback, determine which display function should be used based on comment type.
 * Pingbacks/trackbacks have a short display, while comments get full meta and author gravatar.
 *
 * @param object $comment The comment object.
 * @param array  $args    An array of arguments.
 * @param int    $depth   Depth of comment.
 */
function adirondack_handle_comment( $comment, $args, $depth ){
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
		adirondack_ping( $comment, $args, $depth );
	} else {
		adirondack_comment( $comment, $args, $depth );
	}
}

/**
 * Display a pingback/trackback. Only display the pinging post.
 *
 * @param object $comment The comment object.
 * @param array  $args    An array of arguments.
 * @param int    $depth   Depth of comment.
 */
function adirondack_ping( $comment, $args, $depth ){ ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<article class="comment-body">
		<svg class="avatar"><use xlink:href="#icon-pingback" /></svg>

		<div class="comment-content">
			<?php comment_author_link(); ?>
			<footer class="comment-meta">
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'adirondack' ); ?></p>
				<?php endif; ?>

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
					<?php if ( strtotime( 'last week' ) < get_comment_time( 'U' ) ): // more recent than 1 week ago ?>
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( __( '%1$s ago', 'adirondack' ), human_time_diff( get_comment_time( 'U' ) ) ); ?>
						</time>
					<?php else: ?>
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'adirondack' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					<?php endif; ?>
					</a>
					<?php edit_comment_link( __( 'Edit', 'adirondack' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->
			</footer><!-- .comment-meta -->
		</div><!-- .comment-content -->
	</article><!-- .comment-body -->
<?php
}

/**
 * Display a comment.
 *
 * @param object $comment The comment object.
 * @param array  $args    An array of arguments.
 * @param int    $depth   Depth of comment.
 */
function adirondack_comment( $comment, $args, $depth ){ ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
	<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

	<div class="comment-content">
	<?php
		if ( $comment->comment_parent != '0' ) {
			$comment_author = sprintf( __( 'In reply to %2$s, %1$s <span class="says">said,</span>', 'adirondack' ), get_comment_author_link(), get_comment_author( $comment->comment_parent ) );
		} else {
			$comment_author = sprintf( __( '%1$s <span class="says">said,</span>', 'adirondack' ), get_comment_author_link() );
		}
		echo apply_filters( 'comment_text', '<span class="comment-author vcard">' . $comment_author . '</span> ' . get_comment_text(), $comment, $args );
	?>

		<footer class="comment-meta">
			<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'adirondack' ); ?></p>
			<?php endif; ?>

			<div class="comment-metadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
				<?php if ( strtotime( 'last week' ) < get_comment_time( 'U' ) ): // more recent than 1 week ago ?>
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( __( '%1$s ago', 'adirondack' ), human_time_diff( get_comment_time( 'U' ) ) ); ?>
					</time>
				<?php else: ?>
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'adirondack' ), get_comment_date(), get_comment_time() ); ?>
					</time>
				<?php endif; ?>
				</a>
				<?php edit_comment_link( __( 'Edit', 'adirondack' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .comment-metadata -->
		</footer><!-- .comment-meta -->

	</div><!-- .comment-content -->

	<!-- @todo Reply link -->

</article><!-- .comment-body -->
<?php
}

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function adirondack_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'adirondack' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'adirondack_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function adirondack_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'adirondack_render_title' );
endif;
