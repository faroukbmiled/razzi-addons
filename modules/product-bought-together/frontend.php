<?php

namespace Razzi\Addons\Modules\Product_Bought_Together;

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
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'product_bought_together' ), 5 );

		add_action( 'wp_loaded', array( $this, 'add_to_cart_action' ), 20 );

		add_action( 'woocommerce_add_to_cart', [ $this, 'add_to_cart' ], 10, 6 );
		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_cart_item_data' ], 10, 2 );
		add_action( 'woocommerce_cart_item_removed', [ $this, 'cart_item_removed' ], 10, 2 );

		// Cart contents
		add_action( 'woocommerce_before_mini_cart_contents', [ $this, 'before_mini_cart_contents' ], 10 );
		add_action( 'woocommerce_before_calculate_totals', [ $this, 'before_calculate_totals' ], 9999 );
	}

		/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'razzi-product-bought-together', RAZZI_ADDONS_URL . 'modules/product-bought-together/assets/product-bought-together.css', array(), '1.0.0' );
		wp_enqueue_script('razzi-product-bought-together', RAZZI_ADDONS_URL . 'modules/product-bought-together/assets/product-bought-together.js',  array('jquery'), '1.0.0' );

		if ( is_singular( 'product' ) ) {
			$razzi_data = array(
				'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
				'currency_symbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
				'thousand_sep'    => function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : '',
				'decimal_sep'     => function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '',
				'price_decimals'  => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : '',
				'alert' 		  => esc_html__( 'Please select a purchasable variation for [name] before adding this product to the cart.', 'razzi' ),
			);

			wp_localize_script(
				'razzi-product-bought-together', 'razziFbt', $razzi_data
			);
		}
	}

	/**
	 * Get product bought together
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_bought_together() {
		global $product;
		$product_ids = maybe_unserialize( get_post_meta( $product->get_id(), 'razzi_bought_together_product_ids', true ) );
		$product_ids = apply_filters( 'razzi_pbt_product_ids', $product_ids, $product );
		if ( empty( $product_ids ) || ! is_array( $product_ids ) ) {
			return;
		}

		if ( $product->is_type( 'grouped' ) || $product->is_type( 'external' ) || $product->get_stock_status() == 'outofstock' ) {
			return;
		}

		$current_product = array( $product->get_id() );
		$product_ids     = array_merge( $current_product, $product_ids );

		 wc_get_template(
			'single-product/product-bought-together.php',
			array(
				'product_ids'      => $product_ids,
			),
			'',
			RAZZI_ADDONS_DIR . 'modules/product-bought-together/templates/'
		);
	}

	/**
	 * Add to cart product bought together
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function add_to_cart_action() {
		if ( empty( $_REQUEST['razzi_pbt_add_to_cart'] ) ) {
			return;
		}

		wc_nocache_headers();

		$product_id = $_REQUEST['razzi_product_id'];

		if ( $product_id == 0 ) {
			$product_ids = explode( ',', $_REQUEST['razzi_pbt_add_to_cart'] );
			$product_id  = $product_ids[0];
		}

		$adding_to_cart    = wc_get_product( $product_id );

		if ( ! $adding_to_cart ) {
			return;
		}

		$was_added_to_cart = false;
		$quantity          = 1;
		$variation_id      = 0;
		$variations        = array();

		if ( $adding_to_cart->is_type( 'variation' ) ) {
			$variation_id = $product_id;
			$product_id   = $adding_to_cart->get_parent_id();
			$variations   = json_decode( stripslashes( $_REQUEST['razzi_variation_attrs'] ) );
			$variations   = (array) json_decode( rawurldecode( $variations->$variation_id ) );
		}

		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );
			$was_added_to_cart = true;
		}

		// If we added the product to the cart we can now optionally do a redirect.
		if ( $was_added_to_cart && 0 === wc_notice_count( 'error' ) ) {
			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				wp_safe_redirect( wc_get_cart_url() );
				exit;
			}
		}
	}

	function add_to_cart( $cart_item_key, $product_id, $variations ) {
		if ( isset( $_REQUEST['razzi_pbt_add_to_cart'] ) || isset( $_REQUEST['data']['razzi_pbt_add_to_cart'] ) ) {
			$ids = '';

			if ( isset( $_REQUEST['razzi_pbt_add_to_cart'] ) ) {
				$ids = $_REQUEST['razzi_pbt_add_to_cart'];
				unset( $_REQUEST['razzi_pbt_add_to_cart'] );
			} elseif ( $_REQUEST['data']['razzi_pbt_add_to_cart'] ) {
				$ids = $_REQUEST['data']['razzi_pbt_add_to_cart'];
				unset( $_REQUEST['data']['razzi_pbt_add_to_cart'] );
			}

			if( ! empty( $_REQUEST['razzi_variation_attrs'] ) ) {
				$variations = json_decode( stripslashes( $_REQUEST['razzi_variation_attrs'] ) );
			}

			if ( $items = self::get_items( $ids, $product_id ) ) {
				// add child products
				self::add_to_cart_items( $items, $cart_item_key, $product_id, $variations );
			}
		}
	}

	function add_to_cart_items( $items, $cart_item_key, $product_id, $variations ) {
		// add child products
		foreach ( $items as $item ) {
			$item_id           = $item['id'];
			$item_qty          = 1;
			$item_product      = wc_get_product( $item_id );
			$item_variation    = [];
			$item_variation_id = 0;

			if( $item_id == 0 ) {
				continue;
			}

			if ( $item_product instanceof \WC_Product_Variation ) {
				$item_variation_id = $item_id;
				$item_id           = $item_product->get_parent_id();
				$item_variation    = ! empty($variations->$item_variation_id) ? (array) json_decode( rawurldecode( $variations->$item_variation_id ) ) : array();
			}

			if ( $item_product && $item_product->is_in_stock() && $item_product->is_purchasable() && ( 'trash' !== $item_product->get_status() ) ) {

				if( $item_id == $product_id ) {
					continue;
				}

				// add to cart
				$item_key = WC()->cart->add_to_cart( $item_id, $item_qty, $item_variation_id, $item_variation );

				if ( $item_key ) {
					WC()->cart->cart_contents[ $item_key ]['razzi_pbt_key']         = $item_key;
					WC()->cart->cart_contents[ $item_key ]['razzi_pbt_parent_key']  = $cart_item_key;
					WC()->cart->cart_contents[ $cart_item_key ]['razzi_pbt_keys'][] = $item_key;
				}
			}
		}
	}

	function add_cart_item_data( $cart_item_data ) {
		if ( isset( $_REQUEST['razzi_pbt_add_to_cart'] ) || isset( $_REQUEST['data']['razzi_pbt_add_to_cart'] ) ) {
			// make sure that is bought together product
			if ( isset( $_REQUEST['razzi_pbt_add_to_cart'] ) ) {
				$ids = $_REQUEST['razzi_pbt_add_to_cart'];
			} elseif ( isset( $_REQUEST['data']['razzi_pbt_add_to_cart'] ) ) {
				$ids = $_REQUEST['data']['razzi_pbt_add_to_cart'];
			}

			if ( ! empty( $ids ) ) {
				$cart_item_data['razzi_pbt_ids'] = $ids;
			}
		}

		return $cart_item_data;
	}

	function get_items( $ids, $product_id = 0, $context = 'view' ) {
		$items = array();

		if ( ! empty( $ids ) ) {
			$_items = explode( ',', $ids );

			if ( is_array( $_items ) && count( $_items ) > 0 ) {
				foreach ( $_items as $_item ) {
					$_item_product = wc_get_product( $_item );

					if ( ! $_item_product || ( $_item_product->get_status() === 'trash' ) ) {
						continue;
					}

					if ( ( $context === 'view' ) && ( ! $_item_product->is_purchasable() || ! $_item_product->is_in_stock() ) ) {
						continue;
					}

					$items[] = array(
						'id'    => $_item,
					);
				}
			}
		}

		$items = apply_filters( 'razzi_pbt_get_items', $items, $ids, $product_id, $context );

		if ( $items && is_array( $items ) && count( $items ) > 0 ) {
			return $items;
		}

		return false;
	}

	function cart_item_removed( $cart_item_key, $cart ) {
		if ( isset( $cart->removed_cart_contents[ $cart_item_key ]['razzi_pbt_keys'] ) ) {
			$keys = $cart->removed_cart_contents[ $cart_item_key ]['razzi_pbt_keys'];

			foreach ( $keys as $key ) {
				unset( $cart->cart_contents[ $key ]['razzi_pbt_key'] );
				unset( $cart->cart_contents[ $key ]['razzi_pbt_parent_key'] );
			}
		}

		if ( isset( $cart->removed_cart_contents[ $cart_item_key ]['razzi_pbt_key'] ) ) {
			$key = $cart->removed_cart_contents[ $cart_item_key ]['razzi_pbt_key'];
			unset( $cart->cart_contents[ $key ] );

			if( ! empty( $cart->removed_cart_contents[ $cart_item_key ]['razzi_pbt_parent_key'] ) ) {
				$_pkey = $cart->removed_cart_contents[ $cart_item_key ]['razzi_pbt_parent_key'];
				$_skey = array_search( $key, $cart->cart_contents[ $_pkey ]['razzi_pbt_keys'] );
				unset( $cart->cart_contents[ $_pkey ]['razzi_pbt_keys'][ $_skey ] );
			}
		}
	}

	function before_mini_cart_contents() {
		WC()->cart->calculate_totals();
	}

	function before_calculate_totals( $cart_object ) {
		if ( ! defined( 'DOING_AJAX' ) && is_admin() ) {
			// This is necessary for WC 3.0+
			return;
		}

		$cart_contents = $cart_object->cart_contents;

		foreach ( $cart_contents as $cart_item_key => $cart_item ) {
			if( ! empty( $cart_item['razzi_pbt_ids'] ) ) {
				if ( $cart_item['variation_id'] > 0 ) {
					$item_product = wc_get_product( $cart_item['variation_id'] );
				} else {
					$item_product = wc_get_product( $cart_item['product_id'] );
				}

				$ori_price = $item_product->get_price();

				// has associated products
				$has_associated = false;

				if ( isset( $cart_item['razzi_pbt_keys'] ) ) {
					foreach ( $cart_item['razzi_pbt_keys'] as $key ) {
						if ( isset( $cart_contents[ $key ] ) ) {
							$has_associated = true;
							break;
						}
					}
				}

				// main product
				$discount = get_post_meta( $cart_item['product_id'], 'razzi_pbt_discount_all', true );
				$quantity_discount_all = intval( get_post_meta( $cart_item['product_id'], 'razzi_pbt_quantity_discount_all', true ) );

				if ( $has_associated && $discount && $discount !== 0 && $quantity_discount_all <= count( explode( ',', $cart_item['razzi_pbt_ids'] ) ) ) {
					$discount_price = $ori_price * ( 100 - (float) $discount ) / 100;
					$cart_item['data']->set_price( $discount_price );

					// associated products
					if( ! empty( $cart_item['razzi_pbt_keys'] ) ) {
						foreach ( $cart_item['razzi_pbt_keys'] as $key => $razzi_pbt_keys ) {
							if( ! isset( $cart_contents[ $razzi_pbt_keys ] ) ) {
								continue;
							}
							if ( $cart_contents[$razzi_pbt_keys]['variation_id'] > 0 ) {
								$_item_product = wc_get_product( $cart_contents[$razzi_pbt_keys]['variation_id'] );
							} else {
								$_item_product = wc_get_product( $cart_contents[$razzi_pbt_keys]['product_id'] );
							}

							$ori_price_child = $_item_product->get_price();
							$discount_price_child = $ori_price_child * ( 100 - (float) $discount ) / 100;

							$cart_contents[$razzi_pbt_keys]['data']->set_price( $discount_price_child );
						}
					}
				}
			}
		}
	}

	public static function format_price( $price ) {
		// format price to percent or number
		$price = preg_replace( '/[^.%0-9]/', '', $price );

		return apply_filters( 'razzi_pbt_format_price', $price );
	}
}