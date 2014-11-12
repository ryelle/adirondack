/**
 * Widget Toggle handler
 */
( function( $ ) {
	var $widgets = $( "#secondary" )
		widgets = {};

	widgets.toggle = function(e) {
			e.preventDefault();

			var $body    = $( 'body' ),
				$page    = $( '#page' ),

				/* Cross browser support for CSS "transition end" event */
				transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

			/* When the toggle link is clicked, animation starts */
			$body.addClass( 'widgets-animating' );

			/***
			 * Determine the direction of the animation and add the correct
			 * translation. We can't do the class switch since the height of
			 * the widget area can be variable.
			 */
			if ( $body.hasClass( 'widgets-visible' ) ) {
				$page.css({
					transform: 'translate3d( 0, 0px, 0)'
				});
				$widgets.css({
					transform: 'translate3d( 0, -' + $widgets.height() + 'px, 0)'
				});
				$( document ).off( 'keyup', widgets.keyToggle );
			} else {
				$page.css({
					transform: 'translate3d( 0, ' + $widgets.height() + 'px, 0)'
				});
				$widgets.css({
					transform: 'translate3d( 0, 0px, 0)'
				});

				// Widgets are visible, move focus to the first focusable element.
				var element = $( document.getElementById( "secondary" ) ).find( 'a,select,input,button,textarea' );
				if ( element.length ) {
					element.first().focus();
				}
				$( document ).on( 'keyup', widgets.keyToggle );
			}


			/***
			 * When the animation (technically a CSS transition)
			 * has finished, remove all animating classes and
			 * either add or remove the "widgets-visible" class
			 * depending whether it was visible or not previously.
			 */
			$widgets.on( transitionEnd, function() {
				$body
					.removeClass( 'widgets-animating up down' )
					.toggleClass( 'widgets-visible' );

				$widgets.off( transitionEnd );
			} );
		};

	widgets.keyToggle = function( event ){
			if ( 27 === event.which ) {
				widgets.toggle( event );
			}
		};

	$widgets.css({
		transform: 'translate3d( 0, -' + $widgets.height() + 'px, 0)'
	});

	$( '.widgets-toggle' ).on( 'touchstart click', widgets.toggle );

} )( jQuery );
