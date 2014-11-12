( function( $ ) {
	if ( location.hash.length && ( ( location.hash.indexOf('comment') != -1 ) || ( location.hash.indexOf('respond') != -1 ) ) ) {
		$( document.body ).addClass('comments-visible');

		if ( $( '#content' ).height() < $( '#comments-container' ).height() ) {
			$( '#comments-bg' ).css({ backgroundColor: 'transparent' });
			$( '#comments-container' ).css({ backgroundColor: 'rgba(44, 54, 66, 0.9)' });
		}
	}

	/***
	 * Run this code when the #toggle-menu link has been tapped
	 * or clicked
	 */
	$( '.toggle-comments' ).on( 'touchstart click', function(e) {
		e.preventDefault();

		var $body     = $( 'body' ),
			$comments = $( '#comments-container' ),

			/* Cross browser support for CSS "transition end" event */
			transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

		/* When the toggle menu link is clicked, animation starts */
		$body.addClass( 'animating' );

		// console.log( $( '#content' ).height(), $comments.height() );
		if ( $( '#content' ).height() < $comments.height() ) {
			$( '#comments-bg' ).css({ backgroundColor: 'transparent' });
			$comments.css({ backgroundColor: 'rgba(44, 54, 66, 0.9)' });
		}

		/***
		 * Determine the direction of the animation and
		 * add the correct direction class depending
		 * on whether the menu was already visible.
		 */
		if ( $body.hasClass( 'comments-visible' ) ) {
			$body.addClass( 'right' );
		} else {
			$body.addClass( 'left' );
			// Comments are visible, move focus to the first focusable element.
			var element = $( document.getElementById( "comments" ) ).find( 'a,select,input,button,textarea' );
			if ( element.length ) {
				element.first().focus();
			}
		}

		/***
		 * When the animation (technically a CSS transition)
		 * has finished, remove all animating classes and
		 * either add or remove the "menu-visible" class
		 * depending whether it was visible or not previously.
		 */
		if ( Modernizr.csstransitions ) {
			$comments.on( transitionEnd, function() {
				$body
					.removeClass( 'animating left right' )
					.toggleClass( 'comments-visible' );

				if ( ! $body.hasClass('comments-visible' ) ) {
					$comments.css({ backgroundColor: 'transparent' });
					$( '#comments-bg' ).css({ backgroundColor: 'rgba(44, 54, 66, 0.9)' });
				}

				$comments.off( transitionEnd );
			} );
		} else {
			// We don't have transitions, so there is no animation.
			$body
				.removeClass( 'animating left right' )
				.toggleClass( 'comments-visible' );

			if ( ! $body.hasClass('comments-visible' ) ) {
				$comments.css({ backgroundColor: 'transparent' });
				$( '#comments-bg' ).css({ backgroundColor: 'rgba(44, 54, 66, 0.9)' });
			}
		}

		// If we've clicked the text link, we should change the URL and jump to the top of the comments
		if ( e.target.className.length && e.target.className.indexOf('text') !== -1 ) {
			if ( ! $body.hasClass( 'comments-visible' ) ){
				location.hash = '#comments';
				$( window ).scrollTop( $comments.offset().top );
			}
		}

	} );
} )( jQuery );