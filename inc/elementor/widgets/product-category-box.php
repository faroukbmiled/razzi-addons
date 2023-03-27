<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

use Elementor\Controls_Stack;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Of Category widget
 */
class Product_Category_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-product-category-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Product Category Box', 'razzi' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-categories';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'razzi' ];
	}

	public function get_script_depends() {
		return [
			'razzi-product-shortcode'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_products_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_product_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'razzi' ) ]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'razzi' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'razzi' ),
					'custom'  => esc_html__( 'Custom', 'razzi' ),
				],
				'default'     => 'default',
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_cat',
			[
				'label'       => esc_html__( 'Product Categories', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition'   => [
					'source' => 'custom',
				],
			]
		);

		$this->add_control(
			'number',
			[
				'label'           => esc_html__( 'Limit', 'razzi' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 50,
				'default' 		=> '6',
				'frontend_available' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'razzi' ),
					'date'       => esc_html__( 'Date', 'razzi' ),
					'title'      => esc_html__( 'Title', 'razzi' ),
					'count'      => esc_html__( 'Count', 'razzi' ),
					'menu_order' => esc_html__( 'Menu Order', 'razzi' ),
				],
				'default'   => '',
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'razzi' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only button text', 'razzi' ),
					'all'  => esc_html__( 'All banner', 'razzi' ),
				],
				'default' => 'all',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_product_style_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Product', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_content_style',
			[
				'label' => __( 'Content', 'razzi' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-product-category-box .razzi-product-category-box__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'razzi-product-category-box',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$category_box = sprintf( '<div class="razzi-product-category-box__items">%s</div>', $this->get_categories_content( $settings ) );

		echo sprintf(
			'<div %s>
				<div class="razzi-product-category-box__inner ">%s</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$category_box
		);

	}


	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {

		$link_icon =  \Razzi\Addons\Helper::get_svg( 'arrow-right', 'razzi-icon' ) ;


		$output = [];

		if ( $settings['product_cat'] ) {
			$cats = explode(',', $settings['product_cat']);
			$output[] = '';

			foreach ( $cats as $tab ) {
				$term = get_term_by( 'slug', $tab, 'product_cat' );

				if( is_wp_error( $term ) || empty( $term ) ) {
					continue;
				}

				$btn_full = $settings['link_type'] == 'all' ? sprintf( '<a href="%s" class="razzi-product-category-box__button-link"></a>',esc_url( get_term_link( $term->term_id, 'product_cat' ) ) ) : '';

				$button_text = sprintf( '<a href="%s" class="button-text razzi-button">%s %s</a>',esc_url( get_term_link( $term->term_id, 'product_cat' ) ), esc_html__('Shop Now', 'razzi'), $link_icon ) ;

				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				$image = $image ? '<div class="razzi-product-category-box__image"> '.$image.'</div>' : '';

				$cat_html = '<div class="razzi-product-category-box__cat-count">';
				$count = (int) $term->count;
				$product_text = $count > 1 ? esc_html__('products', 'razzi')  : esc_html__('product', 'razzi');
				$cat_html .= sprintf( '%s %s', $count, $product_text );
				$cat_html .= '</div>';

				$output[] = sprintf(
					'<div class="razzi-product-category-box__item">
						<div class="razzi-product-category-box__item-box">
							<div class="razzi-product-category-box__content">
								<a href="%s" class="razzi-product-category-box__cat-name">%s %s</a>
								%s %s
							</div>
							%s
							%s
						</div>
					</div>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					esc_html( $term->name ),
					$link_icon,
					$cat_html,
					$button_text,
					$image,
					$btn_full
				);

			}

		} else{

			$term_args = [
				'taxonomy' => 'product_cat',
				'orderby'  => $settings['orderby'],
			];

			if( $settings['number'] ) {
				$term_args['number'] = intval( $settings['number'] );
			}

			$terms = get_terms( $term_args );
			foreach ( $terms as $term ) {

				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				$image = $image ? '<div class="razzi-product-category-box__image"> '.$image.'</div>' : '';

				$btn_full = $settings['link_type'] == 'all' ? sprintf( '<a href="%s" class="razzi-product-category-box__button-link"></a>',esc_url( get_term_link( $term->term_id, 'product_cat' ) ) ) : '';

				$button_text = sprintf( '<a href="%s" class="button-text razzi-button">%s %s</a>',esc_url( get_term_link( $term->term_id, 'product_cat' ) ), esc_html__('Shop Now', 'razzi'), $link_icon ) ;


				$cat_html = '<div class="razzi-product-category-box__cat-count">';
				$count = (int) $term->count;
				$product_text = $count > 1 ? esc_html__('products', 'razzi')  : esc_html__('product', 'razzi');
				$cat_html .= sprintf( '%s %s', $count, $product_text );
				$cat_html .= '</div>';

				$output[] = sprintf(
					'<div class="razzi-product-category-box__item">
						<div class="razzi-product-category-box__item-box">
							<div class="razzi-product-category-box__content">
								<a href="%s" class="razzi-product-category-box__cat-name">%s %s</a>
								%s %s
							</div>
							%s
							%s
						</div>
					</div>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					esc_html( $term->name ),
					$link_icon,
					$cat_html,
					$button_text,
					$image,
					$btn_full
				);
			}

		}

		return implode( '', $output );
	}

}