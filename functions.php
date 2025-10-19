<?php
/**
 * Rising Bamboo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Rising_Bamboo
 */

use RisingBambooTheme\App\PluginRegister;
use RisingBambooCore\Core\Autoloader;
use RisingBambooTheme\App\App;
use RisingBambooTheme\App\ThemeSetup;

define('RBB_THEME_PATH', trailingslashit(get_template_directory()));
define('RBB_THEME_INC_PATH', trailingslashit(RBB_THEME_PATH . 'inc'));
define('RBB_THEME_DIST_PATH', trailingslashit(RBB_THEME_PATH . 'dist'));
define('RBB_THEME_CONFIG_PATH', trailingslashit(RBB_THEME_INC_PATH . 'config'));

define('RBB_THEME_URL', get_template_directory_uri());
define('RBB_THEME_DIST_URI', trailingslashit(RBB_THEME_URL . '/dist/'));

/**
 * TGM Plugin Activation
 */
// phpcs:disable
require_once RBB_THEME_INC_PATH . 'tgm/class-tgm-plugin-activation.php';
require_once RBB_THEME_INC_PATH . 'app/class-plugin-register.php';
// phpcs:enable
new PluginRegister();


/**
 * Theme setup.
 */
// phpcs:disable
require_once RBB_THEME_INC_PATH . 'merlin/class-merlin.php';
require_once RBB_THEME_INC_PATH . 'app/class-setup.php';
// phpcs:enable
new ThemeSetup();

if ( class_exists(\RisingBambooCore\App\App::class) ) {
	/**
	 * Load Autoloader;
	 */
    // phpcs:ignore
	require_once RBB_CORE_INC_DIR . 'core/class-autoloader.php';
	Autoloader::run(RBB_THEME_INC_PATH, 'RisingBambooTheme', 'class-');


	/**
	 *  Theme Initial.
	 */
	App::instance();
} elseif ( ! is_admin() && ! is_login() ) {
	if ( current_user_can('install_themes') ) {
		$setup_url = admin_url() . 'themes.php?page=rbb-wizard';
	} else {
		$setup_url = '#';
	}
	if ( class_exists(TGM_Plugin_Activation::class) && current_user_can('install_plugins') ) {
		$tmg_url = TGM_Plugin_Activation::get_instance()->get_tgmpa_url();
	} else {
		$tmg_url = '#';
	}
	/* translators: 1: TGMA url, 2: Theme setup url */
	echo sprintf(__('Please install <a href="%1$s"> Rising Bamboo Core and the required plugins </a> first! <br/><br/> Alternatively, you can run <a href="%2$s">Theme Setup</a> to easily install all the plugins and data necessary for the theme.', 'botanica'), esc_attr($tmg_url), esc_attr($setup_url));
}
