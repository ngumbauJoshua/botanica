<?php
/**
 * RisingBambooTheme Component.
 *
 * @package RisingBambooTheme.
 * @version 1.0.0
 * @since 1.0.0
 */

namespace RisingBambooTheme\App\Components;

use RisingBambooCore\Core\Singleton;
use RisingBambooCore\Core\View;
use RisingBambooTheme\Helper\Setting;

/**
 * Promotion Popup Class.
 */
class MobileNavigation extends Singleton {

	/**
	 * Construction.
	 */
	public function __construct() {
		if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MOBILE_NAVIGATION_STATUS) ) {
			add_action('wp_footer', [ $this, 'html_output' ]);
		}
	}

	/**
	 * Render HTML.
	 *
	 * @return void
	 */
	public function html_output(): void {
		View::instance()->load(
			'components/mobile-navigation'
		);
	}
}
