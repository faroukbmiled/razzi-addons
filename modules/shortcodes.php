<?php

namespace Razzi\Addons\Modules;

/**
 * Class for shortcodes.
 */
class Shortcodes {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
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
		add_shortcode( 'razzi_product_taxonomy_info', array( __CLASS__, 'product_taxonomy_info' ) );
	}

	/**
	 * Product Categories
	 *
	 * @param array $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public static function product_taxonomy_info( $atts ) {
		$atts = shortcode_atts( array(
			'taxonomy'         		=> 'product_cat',
			'taxonomy_id'         	=> '',
			'show_title'         	=> 'yes',
			'show_thumbnail'        => 'yes',
			'show_description'      => 'yes',
			'classes'      			=> '',
		), $atts, 'razzi_' . __FUNCTION__ );

		$css_class = array(
			'razzi-product-taxonomy-infor',
			$atts['classes'],
		);

		if( ! taxonomy_exists( $atts['taxonomy'] ) ) {
			return;
		}

		if( is_singular( 'product' ) && empty( $atts['taxonomy_id'] ) ) {
			$term_ids = wp_get_post_terms( get_the_ID(), $atts['taxonomy'], array( "fields" => "ids" ) );

			if ( $term_ids && is_array( $term_ids ) ) {
				$atts['taxonomy_id'] = $term_ids[0];
			}

		}

		if(  empty($atts['taxonomy_id']) ) {
			return;
		}

		$term = get_term_by( 'term_id', $atts['taxonomy_id'], $atts['taxonomy'] );
		if( is_wp_error( $term ) || empty( $term ) ) {
			return;
		}

		$image = $title = $description = '';

		if ( $atts['show_thumbnail'] != 'no' ) {
			$taxonomy_thumbnail_id = 'thumbnail_id';
			if ( $atts['taxonomy'] == 'product_brand' ) {
				$taxonomy_thumbnail_id = 'brand_thumbnail_id';
			} elseif( $atts['taxonomy'] == 'product_author' ) {
				$taxonomy_thumbnail_id = 'author_thumbnail_id';
			}
			$thumbnail_id = absint( get_term_meta( $term->term_id, $taxonomy_thumbnail_id, true ) );
			$image = wp_get_attachment_image( $thumbnail_id );

			if ( ! empty( $image ) ) {
				$image = '<div class="razzi-product-taxonomy-infor__image"><a href="'. esc_url( get_term_link( $term->term_id, $atts['taxonomy'] ) ) .'">'. $image .'</a></div>';
			}
		}

		if ( $atts['show_title'] != 'no' ) {
			$title = '<h4 class="razzi-product-taxonomy-infor__title"><a href="'. esc_url( get_term_link( $term->term_id, $atts['taxonomy'] ) ) .'">'. $term->name .'</a></h4>';
		}

		if ( $atts['show_description'] != 'no' ) {
			$description = '<div class="razzi-product-taxonomy-infor__description">'. $term->description .'</div>';
		}

		return sprintf(
			'<div class="%s">
			%s
			<div class="razzi-product-taxonomy-infor__content">%s%s</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$image,
			$title,
			$description
		);
	}
}