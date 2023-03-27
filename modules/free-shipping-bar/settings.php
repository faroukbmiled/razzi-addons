<?php

namespace Razzi\Addons\Modules\Free_Shipping_Bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings  {

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'free_shipping_bar_section' ), 30, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'free_shipping_bar_settings' ), 30, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function free_shipping_bar_section( $sections ) {
		$sections['rz_free_shipping_bar'] = esc_html__( 'Free Shipping Bar', 'razzi' );

		return $sections;
	}

	/**
	 * Adds settings to product display settings
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 * @param string $section
	 *
	 * @return array
	 */
	public function free_shipping_bar_settings( $settings, $section ) {
		if ( 'rz_free_shipping_bar' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'rz_free_shipping_bar_options',
				'title' => esc_html__( 'Free Shipping Bar', 'razzi' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'rz_free_shipping_bar',
				'title'   => esc_html__( 'Free Shipping Bar', 'razzi' ),
				'desc'    => esc_html__( 'Enable Free Shipping Bar', 'razzi' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'desc'    => esc_html__( 'Checkout page', 'razzi' ),
				'id'      => 'rz_free_shipping_bar_checkout_page',
				'default' => 'yes',
				'type'    => 'checkbox',
				'checkboxgroup' => '',
				'checkboxgroup' => 'start',
			);

			$settings[] = array(
				'desc'    => esc_html__( 'Product page', 'razzi' ),
				'id'      => 'rz_free_shipping_bar_product_page',
				'default' => 'no',
				'type'    => 'checkbox',
				'checkboxgroup' => '',
			);

			$settings[] = array(
				'desc'    => esc_html__( 'Cart page', 'razzi' ),
				'id'      => 'rz_free_shipping_bar_cart_page',
				'default' => 'yes',
				'type'    => 'checkbox',
				'checkboxgroup' => 'end',
			);

			$settings[] = array(
				'id'   => 'rz_free_shipping_bar_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

}