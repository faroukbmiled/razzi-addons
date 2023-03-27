<?php
/**
 * Razzi Addons Modules functions and definitions.
 *
 * @package Razzi
 */

namespace Razzi\Addons\Modules\Live_Sales_Notification;

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
			'Razzi\Addons\Modules\Live_Sales_Notification\Settings'   => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/settings.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Frontend'   => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/frontend.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Helper'     => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/helper.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Navigation' => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/navigation/navigation.php',
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
			\Razzi\Addons\Modules\Live_Sales_Notification\Settings::instance();
		}

		if ( get_option( 'razzi_live_sales_notification' ) == 'yes' ) {
			\Razzi\Addons\Modules\Live_Sales_Notification\Helper::instance();
			\Razzi\Addons\Modules\Live_Sales_Notification\Frontend::instance();
			\Razzi\Addons\Modules\Live_Sales_Notification\Navigation::instance();
		}
	}

}
