<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Adirondack
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments-bg"></div>
<div id="comments-container">
	<div class="toggle-comments comments-icon">
		<svg class="comment"><use xlink:href="#icon-comment" /></svg>
	</div>
	<a href="#" class="toggle-comments icon">
		<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="42.5" height="11" viewBox="0 0 42.5 11" xml:space="preserve"><path d="M 7.5,0 0,5.5 7.5,11 z" /><path d="M 17.5,5.5 25,11 25,0 z" /><path d="M 42.5,0 35,5.5 42.5,11 z" /></svg>
	</a>

	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>
			<h3 class="comments-title">
				<?php
					printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'adirondack' ),
						number_format_i18n( get_comments_number() ) );
				?>
			</h3>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'      => 'ol',
						'short_ping' => true,
						'avatar_size' => 50,
						'callback'   => 'adirondack_handle_comment',
						'max_depth' => 1,
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'adirondack' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'adirondack' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'adirondack' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'adirondack' ); ?></p>
		<?php endif; ?>

		<?php comment_form( array(
			'comment_notes_after' => '',
			'comment_notes_before' => '',
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'adirondack' ) . '</label><div class="comment-wrap"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></p>',
		) ); ?>

	</div><!-- #comments -->

</div><!-- #comments-container -->
