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
 * Testimonials Carousel widget
 */
class Testimonials_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-testimonials-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Testimonials Carousel 2', 'razzi' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
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

		$repeater->start_controls_tabs( 'banner_content_settings' );

		$repeater->start_controls_tab( 'content_other', [ 'label' => esc_html__( 'Content', 'razzi' ) ] );

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'razzi' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/80x80/f5f5f5?text=80x80',
				],
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is subtitle', 'razzi' ),
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is title', 'razzi' ),
			]
		);

		$repeater->add_control(
			'rate',
			[
				'label' => __( 'Rate', 'razzi' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5,
				'step' => 1,
				'default' => 5,
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Description', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is desc', 'razzi' ),
			]
		);

		$repeater->add_control(
			'customer',
			[
				'label'       => esc_html__( 'Customer', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Customer Name', 'razzi' ),
			]
		);

		$repeater->add_control(
			'date',
			[
				'label'       => esc_html__( 'Date', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is Date', 'razzi' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'content_text', [ 'label' => esc_html__( 'Author', 'razzi' ) ] );

		$repeater->add_control(
			'image_author',
			[
				'label'   => esc_html__( 'Image', 'razzi' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$repeater->add_control(
			'author_title',
			[
				'label'       => esc_html__( 'Title', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
			]
		);

		$repeater->add_control(
			'author_name',
			[
				'label'       => esc_html__( 'Name', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Testimonials List', 'razzi' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false
			]
		);

		$this->add_control(
			'title_size',
			[
				'label'   => __( 'Title HTML Tag', 'razzi' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h6',
				'separator' => 'before',
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

		$this->add_control(
			'centeredSlides',
			[
				'label'     => __( 'Center Mode', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'razzi-testimonials-carousel-2__centeredslides-',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slidesPerViewAuto',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'slidesPerViewAuto',
			[
				'label'     => __( 'Slides per view auto', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'razzi-testimonials-carousel-2__slidesperviewauto-',
				'conditions' => [
					'terms' => [
						[
							'name' => 'centeredSlides',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'slide_spacing_right',
			[
				'label'     => __( 'Spacing Right', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
				],
				'desktop_default' => [
					'size' => 443,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}}.razzi-testimonials-carousel-2__slidesperviewauto-yes .razzi-testimonials-carousel-2' => 'margin-right: -{{SIZE}}{{UNIT}};',

				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slidesPerViewAuto',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'razzi' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'desktop_default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
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
				'desktop_default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
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
					'dots' 	 => esc_html__( 'Dots', 'razzi' ),
					'scrollbar'  => esc_html__( 'Scrollbar', 'razzi' ),
				],
				'default' => 'dots',
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
				'conditions' => [
					'terms' => [
						[
							'name'     => 'centeredSlides',
							'operator' => '!=',
							'value'    => 'yes',
						],
					],
				]
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
		$this->section_items_style();
		$this->section_content_style();
		$this->section_author_style();
		$this->section_carousel_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Title
	 */
	protected function section_items_style() {
		// Content
		$this->start_controls_section(
			'section_items_style',
			[
				'label' => __( 'Items', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .testimonials-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .author-group:after' => 'height: calc(100% + {{TOP}}{{UNIT}} + {{BOTTOM}}{{UNIT}} ) ; top: calc(0px - {{TOP}}{{UNIT}} ) ;',
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .author-group:before' => 'width: calc(100% + {{TOP}}{{UNIT}} + {{BOTTOM}}{{UNIT}} ) ; right: calc(0px - {{TOP}}{{UNIT}} ) ;',
				],
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label'     => __( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .testimonials-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_border_color',
			[
				'label'     => __( 'Border Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .testimonials-item' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_spacing',
			[
				'label'     => esc_html__( 'Header Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Element in Tab Style by Content
	 *
	 * Title
	 */
	protected function section_content_style() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Image
		$this->add_control(
			'content_image_divider',
			[
				'label' => __( 'Image', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'img_boder_radius',
			[
				'label'     => __( 'Border Radius', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .testi-image' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .testi-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'img_spacing',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .testi-image' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Sub Title
		$this->add_control(
			'content_sub_title_divider',
			[
				'label' => __( 'Sub Title', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .razzi-testimonials-carousel-2__header .subtitle',
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_spacing',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Title
		$this->add_control(
			'content_title_divider',
			[
				'label' => __( 'Title', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .razzi-testimonials-carousel-2__header .testi-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .testi-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .testi-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Image
		$this->add_control(
			'content_rating_divider',
			[
				'label' => __( 'Rating', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rating_position',
			[
				'label'     => esc_html__( 'Position', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'top'   => esc_html__( 'Top', 'razzi' ),
					'bottom' 	 => esc_html__( 'Bottom', 'razzi' ),
					'right' 	 => esc_html__( 'Right', 'razzi' ),
				],
				'default' => 'bottom',
				'prefix_class' => 'razzi-testimonials-carousel-2__rating_position-'
			]
		);

		$this->add_control(
			'staring_font',
			[
				'label'     => esc_html__( 'Font Size', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .razzi-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'staring_color',
			[
				'label'     => __( 'Normal Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .razzi-svg-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'staring_color_ac',
			[
				'label'     => __( 'Active Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__header .razzi-svg-icon.rate-active' => 'color: {{VALUE}};',
				],
			]
		);

		// Description
		$this->add_control(
			'content_description_divider',
			[
				'label' => __( 'Description', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .razzi-testimonials-carousel-2__footer .testi-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__footer .testi-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2__footer .testi-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Meta
		$this->add_control(
			'content_meta_divider',
			[
				'label' => __( 'Meta', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .razzi-testimonials-carousel-2__footer .testi-meta',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2__footer .testi-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Element in Tab Style by Author
	 *
	 * Title
	 */
	protected function section_author_style() {
		// Content
		$this->start_controls_section(
			'section_author_style',
			[
				'label' => __( 'Author', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Title
		$this->add_control(
			'author_heading_divider',
			[
				'label' => __( 'Title', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_title_typography',
				'selector' => '{{WRAPPER}} .razzi-testimonials-carousel-2 .testi-author-title',
			]
		);

		$this->add_control(
			'author_title_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .testi-author-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'author_title_spacing',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .testi-author-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'author_name_divider',
			[
				'label' => __( 'Name', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_name_typography',
				'selector' => '{{WRAPPER}} .razzi-testimonials-carousel-2 .testi-author-name',
			]
		);

		$this->add_control(
			'author_name_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .testi-author-name' => 'color: {{VALUE}};',
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
			'carousel_style_divider',
			[
				'label' => __( 'Scrollbar', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'scrollbar_align',
			[
				'label'       => esc_html__( 'Align', 'razzi' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'selectors'   => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-scrollbar' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left' => '',
					'center'   => 'margin-left:auto; margin-right:auto;',
					'right'   => 'margin-left:auto; margin-right:0;',
				],
			]
		);

		$this->add_responsive_control(
			'scrollbar_max_width',
			[
				'label'     => __( 'Max Width', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
					'%' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-scrollbar' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'scrollbar_spacing',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-scrollbar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_style_divider',
			[
				'label' => esc_html__( 'Dots', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// Arrows
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'razzi' ) ] );

		$this->add_control(
			'sliders_dots_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-testimonials-carousel-2 .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
			'razzi-testimonials-carousel-2 swiper-container',
			'razzi-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$swiper_settings = [
			'slidesToShow'					=> $settings['slidesToShow'],
			'slidesToScroll' 				=> $settings['slidesToScroll'],
			'loop' 							=> $settings['infinite'],
			'autoplay' 						=> $settings['autoplay'],
			'speed' 						=> $settings['autoplay_speed'],
		];

		if (isset($settings['slidesToShow_tablet']) && $settings['slidesToShow_tablet']) {
			$swiper_settings['slidesToShow_tablet'] = absint( $settings['slidesToShow_tablet'] );
		}

		if (isset($settings['slidesToScroll_tablet']) && $settings['slidesToScroll_tablet']) {
			$swiper_settings['slidesToScroll_tablet'] = absint( $settings['slidesToScroll_tablet'] );
		}

		if (isset($settings['slidesToShow_mobile']) && $settings['slidesToShow_mobile']) {
			$swiper_settings['slidesToShow_mobile'] = absint( $settings['slidesToShow_mobile'] );
		}

		if (isset($settings['slidesToScroll_mobile']) && $settings['slidesToScroll_mobile']) {
			$swiper_settings['slidesToScroll_mobile'] = absint( $settings['slidesToScroll_mobile'] );
		}

		$this->add_render_attribute( 'wrapper', 'data-swiper', wp_json_encode( $swiper_settings ) );

		$output =  array();

		$els = $settings['elements'];
		$item_lenght = 0;

		$class_cols = $settings['slidesPerViewAuto'] == 'yes' ? 'col-flex-xs-'.intval(12/$settings['slidesToShow']) : '';

		if ( ! empty ( $els ) ) {
			foreach ( $els as $index => $item ) {

				$settings['image']      = $item['image'];
				$settings['image_size'] = 'thumbnail';

				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				$image = $image ? sprintf('<div class="testi-image">%s</div>',$image) : '';

				$subtitle = $item['subtitle'] ? sprintf('<span class="subtitle">%s</span>',$item['subtitle']) : '';
				$title = $item['title'] ? sprintf('<%2$s class="testi-title">%1$s</%2$s>',$item['title'], $settings['title_size']) : '';
				$desc = $item['desc'] ? sprintf('<div class="testi-desc">%s</div>',$item['desc']) : '';

				$customer = $item['customer'] ? sprintf('<span class="testi-customer">%s</span>',$item['customer']) : '';
				$date = $item['date'] ? sprintf('<span class="testi-date">%s</span>',$item['date']) : '';
				$meta_html = $customer == '' && $date == '' ? '' : sprintf('<div class="testi-meta">%s %s</div>',$customer,$date );

				//author
				$settings['image']      = $item['image_author'];
				$settings['image_size'] = 'full';
				$image_author = Group_Control_Image_Size::get_attachment_image_html( $settings );
				$image_author = $image_author ? sprintf('<div class="testi-author-image">%s</div>',$image_author) : '';

				$author_title = $item['author_title'] ? sprintf('<div class="testi-author-title">%s</div>',$item['author_title']) : '';
				$author_name = $item['author_name'] ? sprintf('<div class="testi-author-name">%s</div>',$item['author_name']) : '';
				$author_html = $image_author == '' ? '' : sprintf('<div class="author-group">%s <div class="testi-author-content">%s %s</div></div>',$image_author,$author_title,$author_name );


				// rate
				$rate_content = [];

				$rate_content[] = '<div class="testi-rate">';
				for ($i=0; $i < 5 ; $i++) {
					if( $i < intval($item['rate'])){
						$rate_content[] = \Razzi\Addons\Helper::get_svg('staring', 'rate-active', 'widget');
					} else {
						$rate_content[] = \Razzi\Addons\Helper::get_svg('staring', '', 'widget');
					}
				}
				$rate_content[] = '</div>';

				$output_content = [];
				$output_content[] = $author_html;
				$output_content[] = $image_author == '' ? '' : '<div class="razzi-testimonials-carousel-2__gr">';
				$output_content[] = '<div class="razzi-testimonials-carousel-2__header">';
				$output_content[] = $image;
				$output_content[] = '<div class="header-content">';
				$output_content[] = $settings['rating_position'] == 'top' ? implode('', $rate_content) : '';
				$output_content[] = '<div class="header-content-group">';
				$output_content[] = $subtitle;
				$output_content[] = $title;
				$output_content[] = '</div>';
				$output_content[] = $settings['rating_position'] == 'bottom' ? implode('', $rate_content) : '';
				$output_content[] = $settings['rating_position'] == 'right' ? implode('', $rate_content) : '';
				$output_content[] = '</div>';
				$output_content[] = '</div>';
				$output_content[] = '<div class="razzi-testimonials-carousel-2__footer">';
				$output_content[] = $desc;
				$output_content[] = $meta_html;
				$output_content[] = '</div>';
				$output_content[] = $image_author == '' ? '' : '</div>';

				$class_author = $image_author == '' ? '' : 'testimonials-item__author-box';

				$output[] = sprintf( '<div class="testimonials-item swiper-slide %s %s">%s</div>', esc_attr( $class_cols ), esc_attr( $class_author ), implode('', $output_content) );

				$item_lenght++;
			}
		}

		if ( $settings['slidesPerViewAuto'] == 'yes' ) {
			if ( $settings['slidesToShow'] != 1 || $settings['slidesToScroll'] != 1 ) {
				$output[] = sprintf( '<div class="testimonials-item-empty swiper-slide %s"></div>', esc_attr( $class_cols ), implode('', $output_content) );
			}
		}

		if ( $settings['slidesPerViewAuto'] == 'yes' ) {
			if ( $settings['slidesToShow'] != 1 || $settings['slidesToScroll'] != 1 ) {
				$output[] = sprintf( '<div class="testimonials-item-empty swiper-slide %s"></div>', esc_attr($class_cols), implode('', $output_content) );

			}
		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s><div class="razzi-testimonials-carousel-2__inner swiper-wrapper"> %s</div><div class="swiper-pagination"></div><div class="swiper-scrollbar"></div></div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode('', $output)
		);
	}
}