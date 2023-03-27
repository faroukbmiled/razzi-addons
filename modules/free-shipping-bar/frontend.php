<?php

namespace Razzi\Addons\Modules\Free_Shipping_Bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
	 * Has variation images
	 *
	 * @var $has_variation_images
	 */
	protected static $has_variation_images = null;


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
		if ( get_option( 'rz_free_shipping_bar_cart_page' ) == 'yes' ) {
			add_action('woocommerce_before_cart_table', array( $this, 'free_shipping_bar' ));
		}
		if ( get_option( 'rz_free_shipping_bar_checkout_page' ) == 'yes' ) {
			add_action('woocommerce_checkout_before_order_review', array( $this, 'free_shipping_bar' ));
		}
		if ( get_option( 'rz_free_shipping_bar_product_page' ) == 'yes' ) {
			add_action('woocommerce_before_add_to_cart_button', array( $this, 'free_shipping_bar' ), 9);
		}
		add_action('woocommerce_widget_shopping_cart_before_buttons', array( $this, 'free_shipping_bar' ), 100);
	}

		/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'razzi-free-shipping-bar', RAZZI_ADDONS_URL . 'modules/free-shipping-bar/assets/free-shipping-bar.css', array(), '1.0.0' );
	}

	/**
	 * Get shipping amount
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function free_shipping_bar() {
		$min_amount      = $this->get_min_amount();
		if( $min_amount <=0 ) {
			return;
		}

		$current_total      = WC()->cart->subtotal;
		$amount_more = $min_amount - $current_total;
		$message = '';
		$percent = '100%';
		if( $amount_more > 0 ) {
			$message = sprintf(__('You are missing %s to get <strong>free shipping!</strong>', 'razzi'), '<strong>' . wc_price($amount_more) .'</strong>' );
			$percent = number_format($current_total/$min_amount*100, 2, '.', '') . '%';
		} else {
			$message = sprintf(__('Congratulations! You have got <strong>free shipping</strong>', 'razzi'));
		}
		 wc_get_template(
			'cart/free-shipping-bar.php',
			array(
				'message'      => $message,
				'percent'      => $percent
			),
			'',
			RAZZI_ADDONS_DIR . 'modules/free-shipping-bar/templates/'
		);
	}

	/**
	 * Get shipping amount
	 *
	 * @since 1.0.0
	 *
	 * @return float
	 */
	public function get_min_amount() {

		$packages =  ! empty( WC()->cart ) ? WC()->cart->get_shipping_packages() : '';
		$min_amount = 0;
		if( ! $packages ) {
			return $min_amount;
		}
		$shipping_methods = WC()->shipping() ? WC()->shipping()->load_shipping_methods($packages[0]) : array();
		if( ! $shipping_methods ) {
			return $min_amount;
		}

		foreach ( $shipping_methods as $id => $shipping_method ) {

			if ( ! isset( $shipping_method->enabled ) || 'yes' !== $shipping_method->enabled ) {
				continue;
			}

			if ( ! $shipping_method instanceof \WC_Shipping_Free_Shipping ) {
				continue;
			}

			if ( ! in_array( $shipping_method->requires, array( 'min_amount', 'either', 'both' ) ) ) {
				continue;
			}

			$min_amount = $shipping_method->min_amount;
		}
		return $min_amount;
	}

}