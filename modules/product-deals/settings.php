<?php

namespace Razzi\Addons\Modules\Product_Deals;

use Razzi\Addons\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings {

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'product_deals_section' ), 20, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'product_deals_settings' ), 20, 2 );

		if ( get_option( 'rz_product_deals' ) != 'yes' ) {
			return;
		}

		add_action( 'woocommerce_product_options_pricing', array( $this, 'add_deal_fields' ) );
		add_action( 'save_post', array( $this, 'save_product_data' ) );

		add_action( 'woocommerce_variation_options_pricing', array( $this, 'variation_settings_fields' ), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_settings_fields' ), 10, 2 );
		add_filter( 'woocommerce_available_variation', array( $this, 'load_variation_settings_fields' ) );

		add_action( 'woocommerce_recorded_sales', array( $this, 'update_deal_sales' ) );
		add_action( 'woocommerce_scheduled_sales', array( $this, 'schedule_deals' ) );

	}


	/**
	 * Add the sale quantity field
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_deal_fields() {
		global $thepostid;

		$quantity     = intval( get_post_meta( $thepostid, '_deal_quantity', true ) );
		$sales_counts = get_post_meta( $thepostid, '_deal_sales_counts', true );
		$sales_counts = intval( $sales_counts );
		$min          = $sales_counts > 0 ? $sales_counts + 1 : 0;
		?>

        <p class="form-field _deal_quantity_field">
            <label for="_sale_quantity"><?php esc_html_e( 'Sale quantity', 'razzi' ) ?></label>
			<?php echo wc_help_tip( __( 'Set this quantity will make the product to be a deal. The sale will end when this quantity is sold out.', 'razzi' ) ); ?>
            <input type="number" min="<?php echo $min; ?>" class="short" name="_deal_quantity" id="_deal_quantity"
                   value="<?php echo esc_attr( $quantity ) ?>">
        </p>

        <p class="form-field _deal_sales_counts_field">
            <label for="_sale_quantity"><?php esc_html_e( 'Sold Items', 'razzi' ) ?></label>
			<?php echo wc_help_tip( __( 'Set this sold items should be less than the sale quantity.', 'razzi' ) ); ?>
            <input type="number" class="short" name="_deal_sales_counts"
                   id="_deal_sales_counts" value="<?php echo esc_attr( $sales_counts ) ?>">
        </p>

		<?php
	}

	/**
	 * Save product data
	 *
	 * @param int $post_id
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function save_product_data( $post_id ) {
		if ( 'product' !== get_post_type( $post_id ) ) {
			return;
		}

		if ( isset( $_POST['_deal_quantity'] ) ) {
			$current_sales = get_post_meta( $post_id, '_deal_sales_counts', true );

			// Reset sales counts if set the qty to 0
			if ( $_POST['_deal_quantity'] <= 0 ) {
				update_post_meta( $post_id, '_deal_sales_counts', 0 );
				update_post_meta( $post_id, '_deal_quantity', '' );
			} elseif ( $_POST['_deal_quantity'] < $current_sales ) {
				$this->end_deal( $post_id );
			} elseif ( $_POST['_deal_quantity'] < $_POST['_deal_sales_counts'] ) {
				$this->end_deal( $post_id );
			} else {
				update_post_meta( $post_id, '_deal_quantity', wc_clean( $_POST['_deal_quantity'] ) );
				update_post_meta( $post_id, '_deal_sales_counts', wc_clean( $_POST['_deal_sales_counts'] ) );
			}
		} else {
			// Reset sales counts and qty setting
			update_post_meta( $post_id, '_deal_sales_counts', 0 );
			update_post_meta( $post_id, '_deal_quantity', '' );
		}
	}

	public function variation_settings_fields( $loop, $variation_data, $variation ) {
		woocommerce_wp_text_input(
			array(
				'id'            => "_deal_quantity{$loop}",
				'name'          => "_deal_quantity[{$loop}]",
				'value'         => get_post_meta( $variation->ID, '_deal_quantity', true ),
				'label'         => __( 'Sale quantity', 'razzi' ),
				'desc_tip'      => true,
				'wrapper_class' => 'form-row form-row-first',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'            => "_deal_sales_counts{$loop}",
				'name'          => "_deal_sales_counts[{$loop}]",
				'value'         => get_post_meta( $variation->ID, '_deal_sales_counts', true ),
				'label'         => __( 'Sold Items', 'razzi' ),
				'desc_tip'      => true,
				'wrapper_class' => 'form-row form-row-last',
			)
		);
	}

	public function save_variation_settings_fields( $variation_id, $loop ) {
		$_deal_quantity = $_POST['_deal_quantity'][ $loop ];
		$_deal_sales_counts = $_POST['_deal_sales_counts'][ $loop ];

		if ( isset( $_deal_quantity ) ) {
			// Reset sales counts if set the qty to 0
			if ( $_deal_quantity <= 0 ) {
				update_post_meta( $variation_id, '_deal_sales_counts', 0 );
				update_post_meta( $variation_id, '_deal_quantity', '' );
			} elseif ( $_deal_quantity < $_deal_sales_counts ) {
				$this->end_deal( $variation_id );
			} elseif ( $_deal_quantity < $_deal_sales_counts ) {
				$this->end_deal( $variation_id );
			} else {
				update_post_meta( $variation_id, '_deal_quantity', wc_clean( $_deal_quantity ) );
				update_post_meta( $variation_id, '_deal_sales_counts', wc_clean( $_deal_sales_counts ) );
			}
		} else {
			// Reset sales counts and qty setting
			update_post_meta( $variation_id, '_deal_sales_counts', 0 );
			update_post_meta( $variation_id, '_deal_quantity', '' );
		}
	}

	public function load_variation_settings_fields( $variation ) {
		$variation['_deal_quantity'] = get_post_meta( $variation[ 'variation_id' ], '_deal_quantity', true );
		$variation['_deal_sales_counts'] = get_post_meta( $variation[ 'variation_id' ], '_deal_sales_counts', true );

		$_variation = wc_get_product( $variation[ 'variation_id' ] );
		$expire_date = ! empty( $_variation->get_date_on_sale_to() ) ? $_variation->get_date_on_sale_to()->getOffsetTimestamp() : '';
		$expire_date = apply_filters( 'razzi_product_deals_expire_timestamp', $expire_date, $_variation );

		if ( ! empty( $expire_date ) ) {
			$now = strtotime( current_time( 'Y-m-d H:i:s' ) );
			$expire = $expire_date - $now;

			if ( $expire > 0 ) {
				$variation['expire'] = $expire;
			}
		}

		return $variation;
	}

	/**
	 * Update deal sales count
	 *
	 * @param int $order_id
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function update_deal_sales( $order_id ) {
		$order_post = get_post( $order_id );

		// Only apply for the main order
		if ( $order_post->post_parent != 0 ) {
			return;
		}

		$order = wc_get_order( $order_id );

		if ( sizeof( $order->get_items() ) > 0 ) {
			foreach ( $order->get_items() as $item ) {
				if ( $product_id = $item->get_product_id() ) {
					if ( ! Helper::is_product_deal ( $product_id ) ) {
						continue;
					}

					if( $item->get_variation_id() > 0 ) {
						$product_id = $item->get_variation_id();
					}

					add_post_meta( $product_id, '_deal_sales_counts', 0, true );

					$current_sales = get_post_meta( $product_id, '_deal_sales_counts', true );
					$deal_quantity = get_post_meta( $product_id, '_deal_quantity', true );
					$new_sales     = $current_sales + absint( $item['qty'] );

					// Reset deal sales and remove sale price when reach to limit sale quantity
					if ( $new_sales >= $deal_quantity ) {
						$this->end_deal( $product_id );
					} else {
						update_post_meta( $product_id, '_deal_sales_counts', $new_sales );
					}
				}

			}
		}
	}

	/**
	 * Remove deal data when sale is scheduled end
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function schedule_deals() {
		$data_store  = \WC_Data_Store::load( 'product' );
		$product_ids = $data_store->get_ending_sales();

		if ( $product_ids ) {
			foreach ( $product_ids as $product_id ) {
				if ( $product = wc_get_product( $product_id ) ) {
					update_post_meta( $product_id, '_deal_sales_counts', 0 );
					update_post_meta( $product_id, '_deal_quantity', '' );
				}
			}
		}
	}

	/**
	 * Remove deal data of a product.
	 * Remove sale price
	 * Remove sale schedule dates
	 * Remove sale quantity
	 * Reset sales counts
	 *
	 * @param int $post_id
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function end_deal( $post_id ) {
		update_post_meta( $post_id, '_deal_sales_counts', 0 );
		update_post_meta( $post_id, '_deal_quantity', '' );

		// Remove sale price
		$product       = wc_get_product( $post_id );
		$regular_price = $product->get_regular_price();
		$product->set_price( $regular_price );
		$product->set_sale_price( '' );
		$product->set_date_on_sale_to( '' );
		$product->set_date_on_sale_from( '' );
		$product->save();

		delete_transient( 'wc_products_onsale' );
	}

	public function product_deals_section( $sections ) {
		$sections['rz_product_deals'] = esc_html__( 'Product Deals', 'razzi' );

		return $sections;
	}

	/**
	 * Adds settings to product display settings
	 *
	 * @param array $settings
	 * @param string $section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function product_deals_settings( $settings, $section ) {
		if ( 'rz_product_deals' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'rz_product_deals_options',
				'title' => esc_html__( 'Product Deals', 'razzi' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'rz_product_deals',
				'title'   => esc_html__( 'Product Deals', 'razzi' ),
				'desc'    => esc_html__( 'Enable Product Deals', 'razzi' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'rz_product_deals_expire_text',
				'title'   => esc_html__( 'Expire Text', 'razzi' ),
				'type'    => 'textarea',
				'default' => __( 'Hurry up!<br> Sales ends soon!', 'razzi' ),
			);

			$settings[] = array(
				'id'      => 'rz_product_deals_sold_items_text',
				'title'   => esc_html__( 'Sold Items Text', 'razzi' ),
				'type'    => 'text',
				'default' => esc_html__( 'Sold Items', 'razzi' ),
			);

			$settings[] = array(
				'id'      => 'rz_product_deals_sold_text',
				'title'   => esc_html__( 'Sold Text', 'razzi' ),
				'type'    => 'text',
				'default' => esc_html__( 'Sold', 'razzi' ),
			);

			$settings[] = array(
				'id'   => 'rz_product_deals_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}