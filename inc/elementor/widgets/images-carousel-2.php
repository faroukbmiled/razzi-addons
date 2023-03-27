<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Images Carousel widget
 */
class Images_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-images-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Images Carousel', 'razzi' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-carousel';
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
		$this->section_style();
	}


	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->content_settings_controls();
		$this->carousel_settings_controls();
	}

	protected function content_settings_controls() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'razzi' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'razzi' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'razzi' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button text', 'razzi' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$repeater->add_control(
			'link', [
				'label'         => esc_html__( 'Link', 'razzi' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'razzi' ),
				'description'   => esc_html__( 'Just works if the value of Lightbox is No', 'razzi' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$repeater->add_control(
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

		$repeater->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Sale', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$repeater->add_control(
			'sale_be_text',
			[
				'label'       => esc_html__( 'Before Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'razzi' ),
				'label_block' => true,
				'default'     => '',

			]
		);

		$repeater->add_control(
			'sale_text',
			[
				'label'       => esc_html__( 'Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'razzi' ),
				'label_block' => true,
				'default'     => '',
			]
		);

		$repeater->add_responsive_control(
			'price_box_position_top',
			[
				'label'      => esc_html__( 'Position X', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-content__sale' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_responsive_control(
			'price_box_position_right',
			[
				'label'      => esc_html__( 'Position Y', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-content__sale' => 'right: {{SIZE}}{{UNIT}}',
				],
			]
		);



		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Images', 'razzi' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],

				],
				'prevent_empty' => false
			]
		);

		$this->end_controls_section();
	}

	protected function carousel_settings_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'razzi' ) ]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'razzi' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'desktop_default' => 5,
				'tablet_default' => 4,
				'mobile_default' => 3,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'razzi' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'desktop_default' => 5,
				'tablet_default' => 4,
				'mobile_default' => 3,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'razzi' ),
					'arrows' => esc_html__( 'Arrows', 'razzi' ),
					'dots' 	 => esc_html__( 'Dots', 'razzi' ),
				],
				'default' => 'arrows',
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'return_value' => 'yes',
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'return_value' => 'yes',
				'default'   => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'   => __( 'Autoplay Speed (in ms)', 'razzi' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000,
				'min'     => 100,
				'step'    => 100,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section(); // End Carousel Settings
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
		$this->section_style_sale();
		$this->section_carousel_style();
	}

	protected function section_content_style(){
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-images-carousel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label'     => esc_html__( 'Title', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'heading_title_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-images-carousel-content .razzi-images-carousel__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_backgroundcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-images-carousel-content .razzi-images-carousel__title' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-images-carousel__title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel-2 .razzi-images-carousel__title',
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-images-carousel-content .razzi-images-carousel__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_buton',
			[
				'label'     => esc_html__( 'Button', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .button-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'      => esc_html__( 'Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel-2 .button-text',
			]
		);

		$this->add_control(
			'border_style',
			[
				'label'        => __( 'Border', 'razzi' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'razzi' ),
				'label_on'     => __( 'Custom', 'razzi' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'content_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'razzi' ),
					'dashed' => esc_html__( 'Dashed', 'razzi' ),
					'solid'  => esc_html__( 'Solid', 'razzi' ),
					'none'   => esc_html__( 'None', 'razzi' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .button-text' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_width',
			[
				'label'     => __( 'Border Width', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .button-text' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => __( 'Border Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .button-text' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();
	}

	protected function section_style_sale() {
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => __( 'Sale', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Before Text', 'razzi' ),
				'name'     => 'regular_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel-content__sale-betext',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Text', 'razzi' ),
				'name'     => 'sale_price_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel-content__sale-text',
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-content__sale' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-content__sale' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'price_box_width',
			[
				'label'      => esc_html__( 'Width (px)', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-content__sale' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'price_box_height',
			[
				'label'      => esc_html__( 'Height (px)', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-content__sale' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_style() {
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// Arrows
		$this->add_control(
			'arrows_style',
			[
				'label'        => __( 'Options', 'razzi' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'razzi' ),
				'label_on'     => __( 'Custom', 'razzi' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_width',
			[
				'label'     => __( 'Width', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_height',
			[
				'label'     => __( 'Height', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[
				'label'      => esc_html__( 'Horizontal Position', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button-container' => 'right: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_vertical_position',
			[
				'label'      => esc_html__( 'Vertical Position', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button-container' => 'bottom: {{SIZE}}{{UNIT}};transform:none;',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'razzi' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'razzi' ) ] );

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .razzi-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_divider',
			[
				'label' => esc_html__( 'Dots', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'razzi' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'razzi' ),
				'label_on'     => __( 'Custom', 'razzi' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_dots_gap',
			[
				'label'     => __( 'Gap', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_size',
			[
				'label'     => __( 'Size', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_offset_ver',
			[
				'label'     => esc_html__( 'Spacing Top', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_dots_normal_settings' );

		$this->start_controls_tab( 'sliders_dots_normal', [ 'label' => esc_html__( 'Normal', 'razzi' ) ] );

		$this->add_control(
			'sliders_dots_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_dots_active', [ 'label' => esc_html__( 'Active', 'razzi' ) ] );

		$this->add_control(
			'sliders_dots_ac_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel-2 .swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-images-carousel-2 .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'razzi-images-carousel-2',
			'razzi-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$output =  array();

		$els = $settings['elements'];
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="swiper-container">
				<div class="razzi-images-carousel-2__inner swiper-wrapper">
		<?php
				if ( ! empty ( $els ) ) {
					foreach ( $els as $index => $item ) {

						$settings['image'] = $item['image'];


						$image = esc_url($item['image']['url']);

						$image = $image ? sprintf('<div class="content-img"><img src="%s"></div>',$image) : '';

						$title = $item['title'] ? sprintf( '<div class="razzi-images-carousel__title">%s</div>', $item['title'] ) : '';

						//button
						$key_btn = 'btn_';
						$key_img = 'image_' . $index;

						$link_icon = \Razzi\Addons\Helper::get_svg( 'arrow-right', 'razzi-icon' ) ;

						$button_class = ' button-text razzi-button';

						$button_text = $item['button_text'] ? sprintf('%s%s',$item['button_text'], $link_icon) : '';

						if ( $item['link']['url'] ) :
							$btn_full = $item['link_type'] == 'all' ? Helper::control_url( $key_img, $item['link'], '', [ 'class' => 'full-box-button' ] ) : '';

							$button_text = $item['link']['url'] ? Helper::control_url( $key_btn, $item['link'], $button_text, ['class' => $button_class] ) : $button_text;

						endif;

						//sale
						$sale_betext = $item['sale_be_text'] ? sprintf('<div class="razzi-images-carousel-content__sale-betext">%s</div>',$item['sale_be_text']) : '';
						$sale_text = $item['sale_text'] ? sprintf('<div class="razzi-images-carousel-content__sale-text">%s</div>',$item['sale_text']) : '';

						$html_sale =  $sale_betext == '' && $sale_text == '' ? '' : sprintf('<div class="razzi-images-carousel-content__sale">%s %s</div>',$sale_betext, $sale_text);

						$key_img = 'image_' . $index;

						// $btn_full = $item['link']['url'] ? Helper::control_url( $key_img, $item['link'], '', [ 'class' => 'full-box-button' ] ) : '';


						$output_content  = $image;
						$output_content .= '<div class="razzi-images-carousel-content">';
						$output_content  .= $title;
						$output_content  .= $button_text;
						$output_content .= $html_sale;
						$output_content .= '</div>';

						$output_content .= $btn_full;

						echo '<div class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . ' image-item swiper-slide">';
							printf( '%s', $output_content );

						echo '</div>';
					}
				}

		?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<?php
				echo '<div class="razzi-swiper-button-container">';
				echo \Razzi\Addons\Helper::get_svg('chevron-left','razzi-swiper-button-prev razzi-swiper-button');
				echo \Razzi\Addons\Helper::get_svg('chevron-right', 'razzi-swiper-button-next razzi-swiper-button');
				echo '</div>'
			?>
		</div>
		<?php
	}
}