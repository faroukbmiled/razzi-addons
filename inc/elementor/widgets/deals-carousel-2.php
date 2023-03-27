<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Deals_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-deals-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Deals Carousel 2', 'razzi' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-countdown';
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
			'razzi-coundown',
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

	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->section_content_settings();
		$this->section_carousel_settings();
	}

	protected function section_content_settings() {
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
					'url' => 'https://via.placeholder.com/270x210/f1f1f1?text=Image',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);

		$repeater->add_control(
			'due_date',
			[
				'label'   => esc_html__( 'Date', 'razzi' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'deal',
			[
				'label'       => esc_html__( 'Deal', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is title', 'razzi' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'button_link', [
				'label'         => esc_html__( 'Button Link', 'razzi' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'razzi' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'countdown_slider',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'        => esc_html__( 'This is title', 'razzi' ),
						'due_date' => '',
						'button_text' => esc_html__( 'Shop Now', 'razzi' )
					],
					[
						'title'        => esc_html__( 'This is title', 'razzi' ),
						'due_date' => '',
						'button_text' => esc_html__( 'Shop Now', 'razzi' )
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_settings() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Carousel Settings', 'razzi' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'razzi' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' 		=> 3,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'razzi' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' 		=> 3,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'     => esc_html__( 'None', 'razzi' ),
					'arrows'  => esc_html__( 'Arrows', 'razzi' ),
					'dots'  => esc_html__( 'Dots', 'razzi' ),
				],
				'default'   => 'dots',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'delay',
			[
				'label'     => esc_html__( 'Delay', 'razzi' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3000,
				'description' => esc_html__('Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'razzi'),
				'conditions' => [
					'terms' => [
						[
							'name'  => 'autoplay',
							'value' => 'yes',
						]
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'razzi' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1000,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'   => esc_html__( 'Infinite Loop', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
		$this->section_countdown_style();
		$this->section_button_style();
		$this->section_carousel_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Title
	 */
	protected function section_content_style() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'deal_style',
			[
				'label' => esc_html__( 'Deal', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_style_deal',
				'selector' => '{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__deal',
			]
		);
		$this->add_control(
			'heading_style_deal_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__deal' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'deal_style_spacing',
			[
				'label'     => __( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__deal' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_style_title',
				'selector' => '{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__title',
			]
		);
		$this->add_control(
			'heading_style_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_style_spacing',
			[
				'label'     => __( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Countdown
	 */
	protected function section_countdown_style() {
		$this->start_controls_section(
			'section_countdown_style',
			[
				'label' => __( 'Countdown', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_countdown_spacing',
			[
				'label'     => __( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .countdown-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'section_countdown_settings' );

		$this->start_controls_tab( 'countdown_style_digits', [ 'label' => esc_html__( 'Number', 'razzi' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'digit_typography',
				'selector' => '{{WRAPPER}} .razzi-deals-carousel-2 .timer .digits',
			]
		);

		$this->add_control(
			'digit_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .timer .digits' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'digit_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 30,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .timer .digits' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'countdown_style_text', [ 'label' => esc_html__( 'Text', 'razzi' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .razzi-deals-carousel-2 .timer .text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .timer .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Button
	 */
	protected function section_button_style() {
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__button a',
			]
		);

		$this->add_responsive_control(
			'button_height',
			[
				'label'     => __( 'Height', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 60,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__button a' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__button a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-deals-carousel-2 .deals-carousel-2__button a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Carousel
	 */
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'arrows_horizontal_position',
				[
					'label'      => esc_html__( 'Horizontal Position', 'razzi' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 100,
							'max' => 200,
						],
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button' => 'top: {{SIZE}}{{UNIT}};transform:none;',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button' => 'background-color: {{VALUE}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
					],
				]
			);


			$this->end_controls_tab();

			$this->end_controls_tabs();

			// Dots
			$this->add_control(
				'dots_style_divider',
				[
					'label'     => esc_html__( 'Dots', 'razzi' ),
					'type'      => Controls_Manager::HEADING,
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
							'max' => 200,
							'min' => 0,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .razzi-deals-carousel-2 .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
						'{{WRAPPER}} .razzi-deals-carousel-2 .swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-deals-carousel-2 .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$this->add_render_attribute(
			'wrapper', 'class', [
				'razzi-deals-carousel-2 razzi-swiper-carousel-elementor swiper-container ',
				'razzi-swiper-carousel-elementor ',
				'navigation-' . $nav,
				'navigation-tablet-' . $nav_tablet,
				'navigation-mobile-' . $nav_mobile,
			]
		);

		$content = array();
		$countdown_sliders = $settings['countdown_slider'];

		$dataText = $this->get_countdown_texts();

		$this->add_render_attribute( 'countdown-slider', 'data-text', wp_json_encode( $dataText ) );
		$current  = strtotime( current_time( 'Y/m/d H:i:s' ) );

		foreach ( $countdown_sliders as $index => $item ) {
			$image = Group_Control_Image_Size::get_attachment_image_html( $item );
			$time = $button = '';
			$link_key = 'link_' . $index;

			$expired = ! empty($item['due_date']) ? strtotime( $item['due_date'] ) : 0;
			$expired = $expired > $current ? $expired - $current : 0;
			$expired = apply_filters( 'razzi_countdown_shortcode_second', $expired );

			if ( $expired > 0 ) {
				$time = sprintf(
					'<div class="countdown-content razzi-countdown" data-expire="%s" %s></div>',
					$expired,
					$this->get_render_attribute_string( 'countdown-slider' )
				);
			}

			if ( $item['button_text'] ) {
				$text = $item['button_text'] . \Razzi\Addons\Helper::get_svg('arrow-right');
				$button = Helper::control_url( $link_key, $item['button_link'], $text, [ 'class' => 'razzi-button' ] );
			}

			$content[] = sprintf(
							'<div class="elementor-repeater-item-%s deals-carousel-2__slider swiper-slide">
								<div class="deals-carousel-2__thumbnail">%s%s%s</div>
								<div class="deals-carousel-2__item">
									%s
									<div class="deals-carousel-2__content">
										<div class="deals-carousel-2__deal">%s</div>
										<div class="deals-carousel-2__title">%s%s%s</div>
									</div>
								</div>
								<div class="deals-carousel-2__button">%s</div>
							</div>',
							$item['_id'],
							$item['button_link']['url'] ? '<a href="' . esc_url( $item['button_link']['url'] ) . '">' : '',
							$image,
							$item['button_link']['url'] ? '</a>' : '',
							$time,
							esc_html( $item['deal'] ),
							$item['button_link']['url'] ? '<a href="' . esc_url( $item['button_link']['url'] ) . '">' : '',
							esc_html( $item['title'] ),
							$item['button_link']['url'] ? '</a>' : '',
							$button
						);
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="linked-deals-carousel">
				<div class="razzi-deals-carousel-2__inner swiper-wrapper">
					<?php echo implode( '',  $content ); ?>
				</div>
			</div>
        </div>
		<?php
	}

	protected static function get_countdown_texts() {
		return array(
			'days'    => esc_html__( 'Days', 'razzi' ),
			'hours'   => esc_html__( 'Hours', 'razzi' ),
			'minutes' => esc_html__( 'Min', 'razzi' ),
			'seconds' => esc_html__( 'Seconds', 'razzi' )
		);
	}
}