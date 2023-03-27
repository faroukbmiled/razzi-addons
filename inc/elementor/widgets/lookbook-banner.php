<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Lookbook Banner widget
 */
class Lookbook_Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-lookbook-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Lookbook Banner', 'razzi' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-hotspot';
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
			'razzi-frontend'
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
		$this->section_style_lookbook();
	}

	// Tab Content
	protected function section_content() {
		$this->section_content_option();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Content', 'razzi' ),
			]
		);

		$this->add_responsive_control(
			'image',
			[
				'label'     => __( 'Image', 'razzi' ),
				'type'      => Controls_Manager::MEDIA,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);

		$control = apply_filters( 'razzi_banner_section_product_number', 2 );
		for ( $i = 1; $i <= $control; $i ++ ) {

			$this->add_control(
				'product_lookbooks_hr_' . $i,
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);

			$this->add_control(
				'product_lookbooks_heading_' . $i,
				[
					'type'  => Controls_Manager::HEADING,
					'label' => esc_html__( 'Lookbook', 'razzi' ) . ' ' . $i,
				]
			);

			$this->add_control(
				'product_lookbooks_ids_' . $i,
				[
					'label'       => esc_html__( 'Product', 'razzi' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => false,
					'source'      => 'product',
					'sortable'    => true,
				]
			);


			$this->add_responsive_control(
				'product_lookbooks_position_x_' . $i,
				[
					'label'      => esc_html__( 'Point Position X', 'razzi' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-banner .razzi-lookbook-item.item-' . $i . '' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'product_lookbooks_position_y_' . $i,
				[
					'label'      => esc_html__( 'Point Position Y', 'razzi' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-banner .razzi-lookbook-item.item-' . $i . ' ' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);


			$this->add_responsive_control(
				'product_content_lookbooks_position_x_' . $i,
				[
					'label'      => esc_html__( 'Product Position X', 'razzi' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-banner .razzi-lookbook-item.item-' . $i . ' .product-item' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'product_content_lookbooks_position_y_' . $i,
				[
					'label'      => esc_html__( 'Product Position Y', 'razzi' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-banner .razzi-lookbook-item.item-' . $i . ' .product-item' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);
		}

		$this->end_controls_section();
	}

	protected function section_style_lookbook() {

		// Arrows
		$this->start_controls_section(
			'section_style_lookbook',
			[
				'label' => esc_html__( 'LookBook', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lookbook_bgcolor',
			[
				'label'     => esc_html__( 'Dot Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-banner .razzi-lookbook-item' => ' --rz-lookbook-color-primary: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_title_heading',
			[
				'label'     => esc_html__( 'Title', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lookbook_title_typography',
				'selector' => '{{WRAPPER}} .razzi-lookbook-banner .product-item .product-name',
			]
		);

		$this->add_control(
			'lookbook_title_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-banner .product-item .product-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_price_heading',
			[
				'label'     => esc_html__( 'Price', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lookbook_price_typography',
				'selector' => '{{WRAPPER}} .razzi-lookbook-banner .product-item .product-price',
			]
		);

		$this->add_control(
			'lookbook_price_color',
			[
				'label'     => esc_html__( 'Regular Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-banner .product-item .product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_price_color_1',
			[
				'label'     => esc_html__( 'Sale Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-banner .product-item .product-price ins' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'razzi-lookbook-banner',
		];

		$content_html      = [];
		$banner_html       = '';

		$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

		if( $settings['image']['url'] ) {
			$content_html[] = $image;
		}

		$control = apply_filters( 'razzi_banner_section_product_number', 2 );

		for ( $i = 1; $i <= $control; $i ++ ) {

			$product = '';

			$products_html = [];
			$product_id    = $settings["product_lookbooks_ids_$i"];
			$product       = wc_get_product( $product_id );

			if ( empty( $product ) ) {
				continue;
			}

			if ( $product_id ) {
				$products_html[] = sprintf(
					'<div class="product-item">
						<div class="product-image">%s</div>
						<div class="product-summary">
							<h6 class="product-name">%s</h6>
							<div class="product-price">%s</div>
						</div>
						<a class="razzi-slide-button" href="%s"></a>
					</div>',
					$product->get_image( 'thumbnail' ),
					$product->get_name(),
					$product->get_price_html(),
					get_permalink( $product_id )
				);
			}

			$banner_html .= $product_id ? sprintf(
				'<div class="razzi-lookbook-item item-%s">%s</div>',
				esc_attr( $i ),
				implode( '', $products_html )
			) : '';
		}

		$content_html[] = '<div class="razzi-lookbook-banner__item">' . $banner_html . '</div>';

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				%s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $content_html )
		);
	}
}