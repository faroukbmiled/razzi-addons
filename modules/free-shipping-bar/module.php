<?php
/**
 * Razzi Addons Modules functions and definitions.
 *
 * @package Razzi
 */

namespace Razzi\Addons\Modules\Free_Shipping_Bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Module {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->includes();
		$this->actions();
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		\Razzi\Addons\Auto_Loader::register( [
			'Razzi\Addons\Modules\Free_Shipping_Bar\Frontend'        => RAZZI_ADDONS_DIR . 'modules/free-shipping-bar/frontend.php',
			'Razzi\Addons\Modules\Free_Shipping_Bar\Settings'    	=> RAZZI_ADDONS_DIR . 'modules/free-shipping-bar/settings.php',
		] );
	}


	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function actions() {
		if ( is_admin() ) {
			\Razzi\Addons\Modules\Free_Shipping_Bar\Settings::instance();
		}

		if ( get_option( 'rz_free_shipping_bar' ) == 'yes' && ! is_admin() ) {
			\Razzi\Addons\Modules\Free_Shipping_Bar\Frontend::instance();
		}

	}

}
