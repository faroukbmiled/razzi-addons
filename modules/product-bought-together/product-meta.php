<?php

namespace Razzi\Addons\Modules\Product_Bought_Together;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Product_Meta  {

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

	const POST_TYPE     = 'razzi_product_tab';
	const TAXONOMY_TYPE   = 'razzi_product_tab_type';

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'product_data_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_data_panel' ) );

		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
	}

	/**
	 * Add new product data tab for size guide
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function product_data_tab( $tabs ) {
		$tabs['razzi_product_bought_together'] = array(
			'label'    => esc_html__( 'Frequently Bought Together', 'razzi' ),
			'target'   => 'razzi-product-bought-together',
			'priority' => 62,
			'class'  => array( 'hide_if_grouped', 'hide_if_external', 'hide_if_bundle' ),
		);

		return $tabs;
	}

	/**
	 * Outputs the size guide panel
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_data_panel() {
		global $post;
		$post_id = $post->ID;
		?>
		<div id="razzi-product-bought-together" class="panel wc-metaboxes-wrapper woocommerce_options_panel">
			<p class="form-field">
				<label for="related_products"><?php esc_html_e( 'Products', 'razzi' ); ?></label>
				<select class="wc-product-search" multiple="multiple" style="width: 50%;" id="related_products" name="razzi_bought_together_product_ids[]" data-sortable="true" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'razzi' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post_id ); ?>">
					<?php
					$product_ids = maybe_unserialize( get_post_meta( $post_id, 'razzi_bought_together_product_ids', true ) );

					if ( $product_ids && is_array( $product_ids ) ) {
						foreach ( $product_ids as $product_id ) {
							$product = wc_get_product( $product_id );
							if ( is_object( $product ) ) {
								echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
							}
						}
					}
					?>
				</select> <?php echo wc_help_tip( __( 'This lets you choose which products are part of frequently bought together products.', 'razzi' ) ); // WPCS: XSS ok. ?>
			</p>
			<p class="form-field">
				<label for="product_bought_together_discount_all"><?php esc_html_e( 'Discount', 'razzi' ); ?></label>
				<input id="product_bought_together_discount_all" type="number" name="razzi_pbt_discount_all" value="<?php echo get_post_meta( $post_id, 'razzi_pbt_discount_all', true ); ?>">
				<span class="description">%</span>
			</p>
			<p class="form-field">
				<?php
					$razzi_pbt_checked_all = get_post_meta( $post_id, 'razzi_pbt_checked_all', true );
					$checked = empty( $razzi_pbt_checked_all ) || $razzi_pbt_checked_all !== 'no' ? 'yes' : 'no';
				?>
				<label for="product_bought_together_checked_all"><?php esc_html_e( 'Disable Checked All', 'razzi' ); ?></label>
				<input type="checkbox" class="checkbox" name="razzi_pbt_checked_all" id="product_bought_together_checked_all" value="1" <?php echo checked( $checked, 'yes', false ); ?>>
			</p>
			<p class="form-field">
				<label for="product_bought_together_quantity_discount_all"><?php esc_html_e( 'Number of items to get discount', 'razzi' ); ?></label>
				<input id="product_bought_together_quantity_discount_all" type="number" name="razzi_pbt_quantity_discount_all" min="2" value="<?php echo get_post_meta( $post_id, 'razzi_pbt_quantity_discount_all', true ); ?>">
			</p>
		</div>
		<?php
	}


	/**
	 * Save meta box content.
     *
	 * @since 1.0.0
	 *
	 * @param int $post_id
	 * @param object $post
     *
	 * @return void
	 */
	public function save_post( $post_id, $post ) {
		//If not the flex post.
		if ( 'product' != $post->post_type ) {
			return;
		}

		// Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
		}

		// Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
		}

		if ( isset( $_POST['razzi_bought_together_product_ids'] ) ) {
			$woo_data = $_POST['razzi_bought_together_product_ids'];
			update_post_meta( $post_id, 'razzi_bought_together_product_ids', $woo_data );
		} else {
			update_post_meta( $post_id, 'razzi_bought_together_product_ids', 0 );
		}

		if ( isset( $_POST['razzi_pbt_discount_all'] ) ) {
			$woo_data = intval( $_POST['razzi_pbt_discount_all'] );
			update_post_meta( $post_id, 'razzi_pbt_discount_all', $woo_data );
		} else {
			update_post_meta( $post_id, 'razzi_pbt_discount_all', 0 );
		}

		if ( array_key_exists( 'razzi_pbt_checked_all', $_POST ) ) {
			update_post_meta( $post_id, 'razzi_pbt_checked_all', 'yes' );
		} else {
			update_post_meta( $post_id, 'razzi_pbt_checked_all', 'no' );
		}

		if ( isset( $_POST['razzi_pbt_quantity_discount_all'] ) && intval( $_POST['razzi_pbt_quantity_discount_all'] ) !== 0 && intval( $_POST['razzi_pbt_quantity_discount_all'] ) !== 1 ) {
			$woo_data = intval( $_POST['razzi_pbt_quantity_discount_all'] );
			update_post_meta( $post_id, 'razzi_pbt_quantity_discount_all', $woo_data );
		} else {
			update_post_meta( $post_id, 'razzi_pbt_quantity_discount_all', 2 );
		}
	}

}