<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Images Carousel widget
 */
class Images_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-images-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Images Box Carousel', 'razzi' );
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

		$this->add_control(
			'heading',
			[
				'label'     => esc_html__( 'Heading', 'razzi' ),
				'type'      => Controls_Manager::TEXT,
				'separator' => 'after',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'type',
			[
				'label'     => esc_html__( 'Type', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'image'     	=> esc_html__( 'Image', 'razzi' ),
					'text' 	 		=> esc_html__( 'Text', 'razzi' ),
				],
				'default'   => 'image',
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'razzi' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
				],
				'condition'   => [
					'type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '#Text', 'razzi' ),
				'condition'   => [
					'type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'text_color',
			[
				'label'      => esc_html__( 'Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel {{CURRENT_ITEM}} .content-text' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'text_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel {{CURRENT_ITEM}} .content-text' => 'background-color: {{VALUE}}',
				],
				'condition'   => [
					'type' => 'text',
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
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'razzi' ),
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
			'icon_status',
			[
				'label'        => __( 'Icon', 'razzi' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'razzi' ),
				'label_off'    => __( 'Hide', 'razzi' ),
				'return_value' => 'show',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'razzi' ),
				'type' => Controls_Manager::SELECT,

				'options' => [
					'top' => esc_html__( 'Top', 'razzi' ),
					'left' 	=> esc_html__( 'Left', 'razzi' ),
				],
				'default' => 'top',
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'icon_type',
			[
				'label' => esc_html__( 'Icon type', 'razzi' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__( 'Image', 'razzi' ),
					'icon' 	=> esc_html__( 'Icon', 'razzi' ),
					'external' 	=> esc_html__( 'External', 'razzi' ),
				],
				'default' => 'icon',
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'razzi' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'icon',
						],
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'icon_image',
			[
				'label' => esc_html__( 'Choose Image', 'razzi' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'image',
						],
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);


		$repeater->add_control(
			'external_url',
			[
				'label' => esc_html__( 'External URL', 'razzi' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'external',
						],
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
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
						'title' => esc_html__( 'This is the title', 'razzi' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],

				],
				'title_field'   => '{{{ title }}}',
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

		$this->add_control(
			'slidesPerViewAuto',
			[
				'label'     => __( 'Slides per view auto', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'razzi-images-carousel__slidesperviewauto-'
			]
		);

		$this->add_responsive_control(
			'slide_spacing_right',
			[
				'label'     => __( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
				],
				'desktop_default' => [
					'size' => 501,
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
					'{{WRAPPER}}.razzi-images-carousel__slidesperviewauto-yes .razzi-images-carousel' => 'margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-images-carousel__slidesperviewauto-yes ul.products li.swiper-item-empty' => 'width: {{SIZE}}{{UNIT}} !important;',
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
					'none'      => esc_html__( 'None', 'razzi' ),
					'arrows'    => esc_html__( 'Arrows', 'razzi' ),
					'dots' 	    => esc_html__( 'Dots', 'razzi' ),
					'scrollbar' => esc_html__( 'Scrollbar', 'razzi' ),
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
		$this->section_general_style();
		$this->section_content_style();
		$this->section_carousel_style();
	}

	protected function section_general_style() {
		// Content
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __( 'General', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_tabs_general'
		);

		$this->start_controls_tab(
			'content_img',
			[
				'label' => __( 'Image', 'razzi' ),
			]
		);

		$this->add_control(
			'hover_image',
			[
				'label'        => __( 'Hover Image Animation', 'razzi' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'razzi' ),
				'label_off'    => __( 'Off', 'razzi' ),
				'return_value' => 'on',
				'default'      => 'on',
				'prefix_class' => 'hover-image-',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);

		$this->add_responsive_control(
			'img_border_ra',
			[
				'label'     => esc_html__( 'Border Radius', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-img img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'content_style_text',
			[
				'label' => __( 'Text Box', 'razzi' ),
			]
		);

		$this->add_responsive_control(
			'text_border_ra',
			[
				'label'     => esc_html__( 'Border Radius', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-text' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_text_width',
			[
				'label'     => esc_html__( 'Width', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-text' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_text_height',
			[
				'label'     => esc_html__( 'Height', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-text' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'text_color_ge',
			[
				'label'      => esc_html__( 'Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel .content-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'text_bgcolor_ge',
			[
				'label'      => esc_html__( 'Background Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel .content-text' => 'background-color: {{VALUE}}',
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
		$this->add_control(
			'heading_divider',
			[
				'label' => __( 'Heading', 'razzi' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel .razzi-images-carousel__heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .razzi-images-carousel__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .razzi-images-carousel__heading' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_skew',
			[
				'label'     => __( 'Skew', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'razzi-images-carousel__skew--',
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'image_background_color',
			[
				'label'     => __( 'Background Color Image', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.razzi-images-carousel__skew--yes .razzi-images-carousel .content-img' => 'background-color: {{VALUE}};',
				],
				'condition'   => [
					'content_skew' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color Content', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-summary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label'     => esc_html__( 'Spacing Top', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-summary' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs_content'
		);

		$this->start_controls_tab(
			'style_tabs_sub',
			[
				'label' => __( 'Subtitle', 'razzi' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel .content-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_spacing',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-subtitle' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		// Title
		$this->start_controls_tab(
			'content_style_title',
			[
				'label' => __( 'Title', 'razzi' ),
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-images-carousel .content-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .razzi-images-carousel .content-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .content-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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

		$this->add_responsive_control(
			'scrollbar_align',
			[
				'label'       => esc_html__( 'Alignment', 'razzi' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'       => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'default'     => '',
				'selectors_dictionary' => [
					'left' 		=> 'margin-left: 15px; margin-right: 0;',
					'center'   	=> 'margin-left: auto; margin-right: auto;',
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-images-carousel .swiper-scrollbar' => '{{VALUE}}',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-scrollbar' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-scrollbar' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'        => esc_html__( 'Position', 'razzi' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
					'top'   => [
						'title' => esc_html__( 'Top', 'razzi' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi' ),
						'icon'  => 'eicon-v-align-middle',
					],
				],
				'prefix_class' => 'razzi--v-position-',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel              .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi--v-position-top .razzi-images-carousel .razzi-images-carousel__group--arrows' => 'right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button' => 'top: {{SIZE}}{{UNIT}};transform:none;',
					'{{WRAPPER}}.razzi--v-position-top .razzi-images-carousel .razzi-images-carousel__group--arrows' => 'top: {{SIZE}}{{UNIT}};transform:none;',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-images-carousel .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-images-carousel .swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-images-carousel .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
			'razzi-images-carousel',
			'razzi-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'icon', 'class', 'razzi-products-slider__icon' );

		$output =  array();

		$heading = $settings['heading'] ? sprintf('<div class="razzi-images-carousel__heading">%s</div>', $settings['heading'] ) : '';

		$els = $settings['elements'];
		$class_cols = $settings['slidesPerViewAuto'] == 'yes' ? 'col-flex-xs-'.intval(12/$settings['slidesToShow']) : '';
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo $heading ?>
			<div class="swiper-container">
				<div class="razzi-images-carousel__inner swiper-wrapper">
		<?php
				if ( ! empty ( $els ) ) {
					foreach ( $els as $index => $item ) {

						if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
							$settings['icon'] = 'fa fa-star';
						}

						$has_icon = ! empty( $settings['icon'] );

						if ( $has_icon ) {
							$this->add_render_attribute( 'i', 'class', $settings['icon'] );
							$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
						}

						if ( ! $has_icon && ! empty( $item['selected_icon']['value'] ) ) {
							$has_icon = true;
						}

						$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
						$is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

						$icon  = '';

						if ( $has_icon || ! empty( $item['icon_image']['url'] ) || ! empty( $item['external_url'] ) ) {

							if ( $item['icon_type'] === 'image' ) {
								if ( $item['icon_image']['url'] ) {
									$icon =  sprintf( '<span class="razzi-products-slider__icon razzi-svg-image"><img alt="%s" src="%s"></span>', esc_attr( $item['title'] ), esc_url( $item['icon_image']['url'] ) );
								}
							} else if ( $item['icon_type'] === 'external' ) {
								if ( $item['external_url'] ) {
									$icon = '<span class="razzi-products-slider__icon razzi-svg-image"><img src="' . $item['external_url'] . '" alt="' . esc_attr( $item['title'] ) . '" /></span>';
								}
							} else {
								if ( $is_new || $migrated ) {
									ob_start();
									Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );

									$icon = '<span class="razzi-products-slider__icon razzi-svg-icon">' . ob_get_clean() . '</span>';
								} elseif ( ! empty( $settings['icon'] ) ) {
									$icon = '<span class="razzi-products-slider__icon"><i ' . $this->print_render_attribute_string( 'i' ) . '></i></span>';
								}
							}
						}

						$settings['image']      	= $item['image'];

						$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
						$image = $image ? sprintf('<div class="content-img">%s</div>',$image) : '';

						$key_img = 'image_' . $index;

						$btn_full = $item['link']['url'] ? Helper::control_url( $key_img, $item['link'], '', [ 'class' => 'full-box-button' ] ) : '';

						$subtitle = $item['subtitle'] ? sprintf('<div class="content-subtitle">%s</div>',$item['subtitle']) : '';

						if( $item['icon_position'] == 'left' ) {
							$title = $item['title'] ? sprintf('<div class="content-title">%s%s</div>', $icon, $item['title']) : '';
						} else {
						$title = $item['title'] ? sprintf('<div class="content-title">%s</div>',$item['title']) : '';

						}
						$box_text = $item['text'] ? sprintf('<div class="content-text">%s</div>',$item['text']) : '';

						$output_content  = $item['type'] == 'image' ? $image : $box_text;
						$output_content .= '<div class="content-summary">';
						$output_content .= $subtitle;
						$output_content .= $title;
						$output_content .= '</div>';
						$output_content .= $btn_full;



						echo '<div class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . ' image-item swiper-slide ' . esc_attr( $class_cols ) . ' razzi-images-carousel-icon-position-' . esc_attr( $item['icon_position'] ) . '">';

							if( $item['icon_position'] == 'top' ) {
								printf( '%s %s', $output_content, $icon );
							} else {
								printf( '%s', $output_content );
							}

						echo '</div>';
					}

					if ( $settings['slidesPerViewAuto'] == 'yes' && empty( $settings['infinite'] ) ) {
						if ( $settings['slidesToShow'] != 1 || $settings['slidesToScroll'] != 1 ) {
							echo '<div class="swiper-item-empty swiper-slide ' . esc_attr( $class_cols ) . '"></div>';
						}
					}
				}

		?>
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-scrollbar"></div>
			</div>
			<?php
				echo '<div class="razzi-images-carousel__group--arrows">';
				echo \Razzi\Addons\Helper::get_svg('chevron-left','rz-swiper-button-prev rz-swiper-button');
				echo \Razzi\Addons\Helper::get_svg('chevron-right', 'rz-swiper-button-next rz-swiper-button');
				echo '</div>';
			?>
		</div>
		<?php
	}
}