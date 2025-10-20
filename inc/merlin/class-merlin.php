<?php
/**
 * RisingBamboo Merlin WP
 * Has extends from Merlin WP.
 *
 * The following code is a derivative work from the
 *
 * @package   Rising Bamboo Merlin WP
 * @version   @@pkg.version
 * @link      https://risingbamboo.com
 * @license   Licensed GPLv3 for Open Source Use
 */

// Exit if accessed directly.
use Monolog\Logger;
use RisingBamboo\WPContentImporter\Importer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once RBB_THEME_INC_PATH . 'merlin/vendor/autoload.php';

/**
 * Merlin.
 */
class Merlin {
	/**
	 * Current theme.
	 *
	 * @var object WP_Theme
	 */
	protected $theme;

	/**
	 * Current step.
	 *
	 * @var string
	 */
	protected string $step = '';

	/**
	 * Steps.
	 *
	 * @var    array
	 */
	protected array $steps = array();

	/**
	 * TGMPA instance.
	 *
	 * @var    object
	 */
	protected $tgmpa;

	/**
	 * Importer.
	 * @var Importer
	 */
	protected Importer $importer;

	/**
	 * WP Hook class.
	 *
	 * @var Merlin_Hooks
	 */
	protected Merlin_Hooks $hooks;

	/**
	 * Holds the verified import files.
	 *
	 * @var array
	 */
	public array $import_files;

	/**
	 * The base import file name.
	 *
	 * @var string
	 */
	public string $import_file_base_name;

	/**
	 * Helper.
	 *
	 * @var    array
	 */
	protected array $helper;

	/**
	 * Updater.
	 *
	 * @var mixed
	 */
	protected $updater;

	/**
	 * The text string array.
	 *
	 * @var array|null $strings
	 */
	protected ?array $strings = null;

	/**
	 * The base path where Merlin is located.
	 *
	 * @var array $strings
	 */
	protected $base_path;

	/**
	 * The base url where Merlin is located.
	 *
	 * @var array $base_url
	 */
	protected $base_url;

	/**
	 * The location where Merlin is located within the theme or plugin.
	 *
	 * @var string $directory
	 */
	protected $directory;

	/**
	 * Top level admin page.
	 *
	 * @var string $merlin_url
	 */
	protected $merlin_url;

	/**
	 * The wp-admin parent page slug for the admin menu item.
	 *
	 * @var string $parent_slug
	 */
	protected $parent_slug;

	/**
	 * The capability required for this menu to be displayed to the user.
	 *
	 * @var string $capability
	 */
	protected $capability;

	/**
	 * The URL for the "Learn more about child themes" link.
	 *
	 * @var string $child_action_btn_url
	 */
	protected $child_action_btn_url;

	/**
	 * The flag, to mark, if the theme license step should be enabled.
	 *
	 * @var boolean $license_step_enabled
	 */
	protected $license_step_enabled = false;

	/**
	 * The URL for the "Where can I find the license key?" link.
	 *
	 * @var string $theme_license_help_url
	 */
	protected $theme_license_help_url;

	/**
	 * Remove the "Skip" button, if required.
	 *
	 * @var string $license_required
	 */
	protected $license_required;

	/**
	 * The item name of the EDD product (this theme).
	 *
	 * @var string $edd_item_name
	 */
	protected $edd_item_name;

	/**
	 * The theme slug of the EDD product (this theme).
	 *
	 * @var string $edd_theme_slug
	 */
	protected $edd_theme_slug;

	/**
	 * The remote_api_url of the EDD shop.
	 *
	 * @var string $edd_remote_api_url
	 */
	protected $edd_remote_api_url;

	/**
	 * Turn on dev mode if you're developing.
	 *
	 * @var string $dev_mode
	 */
	protected $dev_mode = false;

	/**
	 * Ignore.
	 *
	 * @var string|null $ignore
	 */
	public ?string $ignore = null;

	/**
	 * The object with logging functionality.
	 *
	 * @var Logger $logger
	 */
	public $logger;
	
	/**
	 * Big button URL
	 *
	 * @var mixed
	 */
	public $ready_big_button_url;
	
	/**
	 * Slug.
	 *
	 * @var string
	 */
	public string $slug;
	/**
	 * @var false|string
	 */
	public $hook_suffix;
	
	/**
	 * Setup plugin version.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function version(): void {

		if ( ! defined( 'MERLIN_VERSION' ) ) {
			define( 'MERLIN_VERSION', '@@pkg.version' );
		}
	}

	/**
	 * Class Constructor.
	 *
	 * @param array $config Package-specific configuration args.
	 * @param array $strings Text for the different elements.
	 */
	public function __construct(array $config = array(), array $strings = array() ) {

		$this->version();

		$config = wp_parse_args(
			$config, array(
				'base_path'            => get_parent_theme_file_path(),
				'base_url'             => get_parent_theme_file_uri(),
				'directory'            => 'merlin',
				'merlin_url'           => 'merlin',
				'parent_slug'          => 'themes.php',
				'capability'           => 'manage_options',
				'child_action_btn_url' => '',
				'dev_mode'             => '',
				'ready_big_button_url' => home_url( '/' ),
			)
		);

		// Set config arguments.
		$this->base_path              = $config['base_path'];
		$this->base_url               = $config['base_url'];
		$this->directory              = $config['directory'];
		$this->merlin_url             = $config['merlin_url'];
		$this->parent_slug            = $config['parent_slug'];
		$this->capability             = $config['capability'];
		$this->child_action_btn_url   = $config['child_action_btn_url'];
		$this->license_step_enabled   = $config['license_step'];
		$this->theme_license_help_url = $config['license_help_url'];
		$this->license_required       = $config['license_required'];
		$this->edd_item_name          = $config['edd_item_name'];
		$this->edd_theme_slug         = $config['edd_theme_slug'];
		$this->edd_remote_api_url     = $config['edd_remote_api_url'];
		$this->dev_mode               = $config['dev_mode'];
		$this->ready_big_button_url   = $config['ready_big_button_url'];

		// Strings passed in from the config file.
		$this->strings = $strings;

		// Retrieve a WP_Theme object.
		$this->theme = wp_get_theme();
		$this->slug  = strtolower( preg_replace( '#[^a-zA-Z]#', '', $this->theme->template ) );

		// Set the ignore option.
		$this->ignore = $this->slug . '_ignore';

		// Is Dev Mode turned on?
		if ( true !== $this->dev_mode ) {

			// Has this theme been set up yet?
			$already_setup = get_option( 'merlin_' . $this->slug . '_completed' );

			// Return if Merlin has already completed its setup.
			if ( $already_setup ) {
				return;
			}
		}

		// Get the logger object, so it can be used in the whole class.
		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-logger.php';
		$this->logger = Merlin_Logger::get_instance();

		// Get TGMPA.
		if ( class_exists( 'TGM_Plugin_Activation' ) ) {
			$this->tgmpa = $GLOBALS['tgmpa'] ?? TGM_Plugin_Activation::get_instance();
		}

		add_action( 'admin_init', array( $this, 'required_classes' ) );
		add_action( 'admin_init', array( $this, 'redirect' ), 30 );
		add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );
		add_action( 'admin_init', array( $this, 'steps' ), 30, 0 );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_page' ), 30, 0 );
		add_action( 'admin_init', array( $this, 'ignore' ), 5 );
		add_action( 'admin_footer', array( $this, 'svg_sprite' ) );
		add_filter( 'tgmpa_load', array( $this, 'load_tgmpa' ), 10, 1 );
		add_action( 'wp_ajax_merlin_content', array( $this, '_ajax_content' ), 10, 0 ); // nonce - ok.
		add_action( 'wp_ajax_merlin_get_total_content_import_items', array( $this, '_ajax_get_total_content_import_items' ), 10, 0 ); // nonce - ok.
		add_action( 'wp_ajax_merlin_plugins', array( $this, '_ajax_plugins' ), 10, 0 ); // nonce - ok.
		add_action( 'wp_ajax_merlin_child_theme', array( $this, 'generate_child' ), 10, 0 ); // nonce - ok.
		add_action( 'wp_ajax_merlin_activate_license', array( $this, '_ajax_activate_license' ), 10, 0 ); // nonce - ok.
		add_action( 'wp_ajax_merlin_update_selected_import_data_info', array( $this, 'update_selected_import_data_info' ), 10, 0 ); // nonce - ok.
		add_action( 'wp_ajax_merlin_import_finished', array( $this, 'import_finished' ), 10, 0 ); // nonce - ok.
		add_filter( 'pt-importer/new_ajax_request_response_data', array( $this, 'pt_importer_new_ajax_request_response_data' ) );
		add_action( 'import_start', array( $this, 'before_content_import_setup' ) );
		add_action( 'admin_init', array( $this, 'register_import_files' ) );
	}

	/**
	 * Require necessary classes.
	 */
	public function required_classes(): void {
		if ( ! class_exists(WP_Importer::class) ) {
			require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
		}

		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-downloader.php';

		$this->importer = new Importer( ['fetch_attachments' => true ], $this->logger );

		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-widget-importer.php';

		if ( ! class_exists( 'WP_Customize_Setting' ) ) {
			require_once ABSPATH . 'wp-includes/class-wp-customize-setting.php';
		}

		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-customizer-option.php';
		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-customizer-importer.php';
		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-redux-importer.php';
		require_once trailingslashit( $this->base_path ) . $this->directory . '/includes/class-merlin-hooks.php';

		$this->hooks = new Merlin_Hooks();

		if ( class_exists( 'EDD_Theme_Updater_Admin' ) ) {
			$this->updater = new EDD_Theme_Updater_Admin();
		}
	}

	/**
	 * Set redirection transient on theme switch.
	 */
	public function switch_theme(): void {
		if ( ! is_child_theme() ) {
			set_transient( $this->theme->template . '_merlin_redirect', 1 );
		}
	}

	/**
	 * Redirection transient.
	 */
	public function redirect(): void {

		if ( ! get_transient( $this->theme->template . '_merlin_redirect' ) ) {
			return;
		}

		delete_transient( $this->theme->template . '_merlin_redirect' );

		wp_safe_redirect( menu_page_url( $this->merlin_url ) );

		exit;
	}

	/**
	 * Give the user the ability to ignore Merlin WP.
	 */
	public function ignore(): void {
		// Bail out if not on correct page.
		if (!isset($_GET['_wpnonce'], $_GET[$this->ignore]) || !wp_verify_nonce($_GET['_wpnonce'], 'merlinwp-ignore-nounce') || !is_admin() || !current_user_can('manage_options')) {
			return;
		}

		update_option( 'merlin_' . $this->slug . '_completed', 'ignored' );
	}

	/**
	 * Conditionally load TGMPA
	 *
	 * @param string $status User's manage capabilities.
	 */
	public function load_tgmpa( $status ): bool {
		return is_admin() || current_user_can( 'install_themes' );
	}

	/**
	 * Determine if the user already has theme content installed.
	 * This can happen if swapping from a previous theme or updated the current theme.
	 * We change the UI a bit when updating / swapping to a new theme.
	 *
	 * @access public
	 */
	protected function is_possible_upgrade(): bool {
		return false;
	}

	/**
	 * Add the admin menu item, under Appearance.
	 */
	public function add_admin_menu(): void {

		// Strings passed in from the config file.
		$strings = $this->strings;

		$this->hook_suffix = add_submenu_page(
			esc_html( $this->parent_slug ), esc_html( $strings['admin-menu'] ), esc_html( $strings['admin-menu'] ), sanitize_key( $this->capability ), sanitize_key( $this->merlin_url ), array( $this, 'adm[...]