( function( $ ) {
	/***
	 * Run this code when the #toggle-menu link has been tapped
	 * or clicked
	 */
	$( '#toggle-comments' ).on( 'touchstart click', function(e) {
		e.preventDefault();

		var $body     = $( 'body' ),
			$comments = $( '#comments-container' ),

			/* Cross browser support for CSS "transition end" event */
			transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

		/* When the toggle menu link is clicked, animation starts */
		$body.addClass( 'animating' );

		/***
		 * Determine the direction of the animation and
		 * add the correct direction class depending
		 * on whether the menu was already visible.
		 */
		if ( $body.hasClass( 'comments-visible' ) ) {
			$body.addClass( 'right' );
		} else {
			$body.addClass( 'left' );
		}

		/***
		 * When the animation (technically a CSS transition)
		 * has finished, remove all animating classes and
		 * either add or remove the "menu-visible" class
		 * depending whether it was visible or not previously.
		 */
		$comments.on( transitionEnd, function() {
			$body
				.removeClass( 'animating left right' )
				.toggleClass( 'comments-visible' );

			$comments.off( transitionEnd );
		} );
	} );
} )( jQuery );