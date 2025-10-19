/**
 * Slick Slider.
 *
 * @version 1.0.0
 * @since 1.0.0
 */

'use strict';
class RbbThemeSlickJs {
	constructor( $element, $config = {} ) {
		const $default = { rtl: window.rbb_vars.rtl === 'true' };
		const $slickConfig = {
			...$default,
			...$config,
		};
		jQuery( $element ).slick( $slickConfig );
	}
}

export default RbbThemeSlickJs;
