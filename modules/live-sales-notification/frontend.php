<?php

namespace Razzi\Addons\Modules\Live_Sales_Notification;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Razzi\Addons\Modules\Live_Sales_Notification\Navigation;

/**
 * Main class of plugin for admin
 */
class Frontend {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_live_sales_notification', array( $this, 'get_orders' ) );
		add_action( 'wp_ajax_nopriv_live_sales_notification', array( $this, 'get_orders' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'razzi-live-sales-notification', RAZZI_ADDONS_URL . 'modules/live-sales-notification/assets/live-sales-notification.css', array(), '1.0.0' );
		wp_enqueue_script('razzi-live-sales-notification', RAZZI_ADDONS_URL . 'modules/live-sales-notification/assets/live-sales-notification.js',  array('jquery'), '1.0.0' );

		$datas = array(
			'numberShow'   => get_option( 'razzi_live_sales_notification_number', 10 ),
			'time_start'   => get_option( 'razzi_live_sales_notification_time_start', 6000 ),
			'time_keep'    => get_option( 'razzi_live_sales_notification_time_keep_opened', 6000 ),
			'time_between' => get_option( 'razzi_live_sales_notification_time_between', 6000 ),
			'ajax_url'	   => admin_url( 'admin-ajax.php' )
		);

		wp_localize_script(
			'razzi-live-sales-notification', 'razziSBP', $datas
		);
	}

	public function get_orders() {
		wp_send_json_success( self::popups_content() );

		die;
	}

	public function popups_content() {
		$products = array();

		$navigation = get_option( 'razzi_live_sales_notification_navigation' );

		switch( $navigation ) {
			case 'orders':
				$products = Navigation\Orders::get_popups();
				break;

			case 'product-type':
				$products = Navigation\Product_Type::get_popups();
				break;

			case 'selected-products':
				$products = Navigation\Selected_Products::get_popups();
				break;

			case 'selected-categories':
				$products = Navigation\Categories::get_popups();
				break;
		}

		if( empty( $products ) ) {
			return;
		}

		shuffle($products);

		return $products;
	}

}