/**
 * Fix issue in Jetpack 3.4 where infinite scroll class might not be applied.
 *
 * See: https://github.com/Automattic/jetpack/issues/1817, slated fix in 3.5
 */

( function() {
	if ( 'object' != typeof infiniteScroll )
		return;

	if ( infiniteScroll.settings.type == 'click' ) {
		// Click can't be disabled, so we should always have the class.
		document.body.className += ' infinite-scroll';
	}

} )();
