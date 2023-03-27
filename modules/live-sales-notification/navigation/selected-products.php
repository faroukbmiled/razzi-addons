<?php

namespace Razzi\Addons\Modules\Live_Sales_Notification\Navigation;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Razzi\Addons\Modules\Live_Sales_Notification\Helper,
	Razzi\Addons\Modules\Live_Sales_Notification\Navigation;

/**
 * Main class of plugin for admin
 */
class Selected_Products {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;
	private static $products = array();


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
	 * Get order
	 */
	public static function get_orders() {
		$selected_products = get_option( 'razzi_live_sales_notification_product' , false );

		if( is_array($selected_products) ) {
			shuffle($selected_products);
			$selected_products = array_map( 'wc_get_product', $selected_products );

			if( is_array( $selected_products ) && count( $selected_products ) > 0 ) {
				foreach($selected_products as $product) {
					if( ! is_object($product) ) {
						continue;
					}

					if( count( self::$products ) >= get_option( 'razzi_live_sales_notification_number', 10 ) ) {
						break;
					}

					$order = new Navigation\Orders_Fake();

					self::$products[] = Helper::format_product_obj( $product, $order );
				}

				if( count( self::$products ) < get_option( 'razzi_live_sales_notification_number', 10 ) && count(self::$products) > 0 ) {
					self::get_orders();
				}
			}
		}

		return self::$products;
	}

	public static function get_popups() {
		$popup = array();
		$products = self::get_orders();

		if( ! $products ) {
			return;
		}

		foreach( $products as $product ) {

			if( empty($product) || ! is_array($product) ) {
				continue;
			}

			$popup[] = Helper::get_popup_html( $product );
		}

		return $popup;
	}
}