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
 * Addons Navigation
 */
class Navigation {

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
			'Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Orders_Fake'       => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/navigation/orders-fake.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Orders'    	       => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/navigation/orders.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Product_Type' 	   => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/navigation/product-type.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Selected_Products' => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/navigation/selected-products.php',
			'Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Categories'		   => RAZZI_ADDONS_DIR . 'modules/live-sales-notification/navigation/categories.php',
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
		\Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Orders_Fake::instance();
		\Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Orders::instance();
		\Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Product_Type::instance();
		\Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Selected_Products::instance();
		\Razzi\Addons\Modules\Live_Sales_Notification\Navigation\Categories::instance();
	}

}
