<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack ;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Slides widget
 */
class Slides extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-slides';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Slides', 'razzi' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
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

	// Tab Content
	protected function section_content() {
		$this->section_content_slides();
		$this->section_content_option();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'razzi' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'razzi' ) ] );

		$repeater->add_control(
			'banner_type',
			[
				'label'       => esc_html__( 'Type', 'razzi' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'image' => esc_html__( 'Image', 'razzi' ),
					'video' => esc_html__( 'Video', 'razzi' ),
				],
				'default'     => 'image',
			]
		);

		$repeater->add_control(
			'banner_video_type',
			[
				'label' => __( 'Source', 'razzi' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => [
					'youtube' => __( 'YouTube', 'razzi' ),
					'self_hosted' => __( 'Self Hosted', 'razzi' ),
				],
				'condition' => [
					'banner_type' => 'video',
				],
			]
		);

		$repeater->add_control(
			'banner_youtube_url',
			[
				'label' => __( 'Link', 'razzi' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your URL', 'razzi' ) . ' (YouTube)',
				'default' => 'https://www.youtube.com/embed/XHOmBV4js_E',
				'label_block' => false,
				'condition' => [
					'banner_video_type' => 'youtube',
					'banner_type' => 'video',
				],
			]
		);

		$repeater->add_control(
			'video_external',
			[
				'label'   => esc_html__( 'External URL', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'razzi' ),
				'label_off'    => __( 'Off', 'razzi' ),
				'return_value' => 'on',
				'default'      => '',
				'condition' => [
					'banner_type' => 'video',
					'banner_video_type' => 'self_hosted',
				],
			]
		);

		$repeater->add_control(
			'video_external_url',
			[
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your URL', 'razzi' ). ' (MP4)',
				'default' => '',
				'label_block' => true,
				'condition' => [
					'banner_type' => 'video',
					'banner_video_type' => 'self_hosted',
					'video_external' => 'on',
				],
			]
		);

		$repeater->add_responsive_control(
			'banner_background_video',
			[
				'label'    => __( 'Video', 'razzi' ),
				'type' => Controls_Manager::MEDIA,
				'media_types' => ['video'],
				'condition'   => [
					'banner_type' => 'video',
					'banner_video_type' => 'self_hosted',
					'video_external' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'    => __( 'Background Image', 'razzi' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1920X600/cccccc?text=1920x600',
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}:not(.swiper-lazy)' => 'background-image: url("{{URL}}");',
				],
				'condition'   => [
					'banner_type' => 'image',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_size',
			[
				'label'     => esc_html__( 'Background Size', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'razzi' ),
					'contain' => esc_html__( 'Contain', 'razzi' ),
					'auto'    => esc_html__( 'Auto', 'razzi' ),
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
					'banner_type' => 'image',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position',
			[
				'label'     => esc_html__( 'Background Position', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => esc_html__( 'Default', 'razzi' ),
					'left top'      => esc_html__( 'Left Top', 'razzi' ),
					'left center'   => esc_html__( 'Left Center', 'razzi' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'razzi' ),
					'right top'     => esc_html__( 'Right Top', 'razzi' ),
					'right center'  => esc_html__( 'Right Center', 'razzi' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'razzi' ),
					'center top'    => esc_html__( 'Center Top', 'razzi' ),
					'center center' => esc_html__( 'Center Center', 'razzi' ),
					'center bottom' => esc_html__( 'Center Bottom', 'razzi' ),
					'initial' 		=> esc_html__( 'Custom', 'razzi' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
					'banner_type' => 'image',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy',
			[
				'label'              => esc_html__( 'Custom Background Position', 'razzi' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position' => [ 'initial' ],
					'banner_background_img[url]!' => '',
					'banner_type' => 'image',
				],
				'required' => true,
			]
		);

		$repeater->add_control(
			'background_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}.item-slider::before' => 'background-color: {{VALUE}}',
				],
				'condition'   => [
					'banner_type' => 'image',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'text_content', [ 'label' => esc_html__( 'Content', 'razzi' ) ] );

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide Heading', 'razzi' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'SubTitle', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'before_desc',
			[
				'label'       => esc_html__( 'Before Description', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide before desc', 'razzi' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'razzi' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am slide content. Click edit button to change this text. ', 'razzi' ),
			]
		);

		$repeater->add_control(
			'button_style',
			[
				'label'      => esc_html__( 'Button Style', 'razzi' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'style_1' => esc_html__( 'Style 1', 'razzi' ),
					'style_2'  => esc_html__( 'Style 2', 'razzi' ),
				],
				'default'    => 'style_1',
				'separator'    => 'before',
			]
		);

		$repeater->add_control(
			'show_default_icon',
			[
				'label'     => esc_html__( 'Show Default Icon', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'return_value' => 'yes',
				'default'   => 'yes',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'button_style',
							'operator' => '==',
							'value'    => 'style_1',
						],
					],
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
					'all'  => esc_html__( 'All slide', 'razzi' ),
				],
				'default' => 'only',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text 1', 'razzi' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'razzi' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link 1', 'razzi' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'razzi' ),
			]
		);

		$repeater->add_control(
			'button_text_2',
			[
				'label'   => esc_html__( 'Button Text 2', 'razzi' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$repeater->add_control(
			'link_2',
			[
				'label'       => esc_html__( 'Link 2', 'razzi' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'razzi' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'sale_setting', [ 'label' => esc_html__( 'Sale', 'razzi' ) ] );

		$repeater->add_control(
			'sale_be_text',
			[
				'label'       => esc_html__( 'Sale Before Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'razzi' ),
				'label_block' => true,
				'default'     => '',
				'separator'    => 'before',
			]
		);

		$repeater->add_control(
			'sale_text',
			[
				'label'       => esc_html__( 'Sale Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'razzi' ),
				'label_block' => true,
				'default'     => '',
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'razzi' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label'       => esc_html__( 'Custom', 'razzi' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'razzi' ),
			]
		);

		$repeater->add_responsive_control(
			'slide_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .razzi-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'razzi' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-content' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'razzi' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'razzi' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'razzi' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'razzi' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'razzi' ),
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
				'selectors'   => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'title_heading_name',
			[
				'label' => esc_html__( 'Title', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						]
					],
				]
			]
		);

		$repeater->add_control(
			'heading_custom_backgroundcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-heading' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'heading_custom_color',
			[
				'label'      => esc_html__( ' Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-heading' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_custom_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-heading',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'heading_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);


		$repeater->add_control(
			'subtitle_heading_name',
			[
				'label' => esc_html__( 'SubTitle', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'subtile_custom_color',
			[
				'label'      => esc_html__( ' Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-subtitle' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_custom_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-subtitle',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'subtitle_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_control(
			'before_desc_heading_name',
			[
				'label' => esc_html__( 'Before Description', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'beforedesc_custom_color',
			[
				'label'      => esc_html__( ' Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-before-desc' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'beforedesc_custom_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-before-desc',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'beforedesc_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-before-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_control(
			'desc_heading_name',
			[
				'label' => esc_html__( 'Description', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'content_custom_color',
			[
				'label'      => esc_html__( 'Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-description' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_custom_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-description',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'desc_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .slick-slide-inner .razzi-slide-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_control(
			'btn_heading_name',
			[
				'label' => esc_html__( 'Button', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'btn_custom_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor  {{CURRENT_ITEM}} .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						]
					],
				]
			]
		);

		$repeater->add_control(
			'btn_custom_color',
			[
				'label'      => esc_html__( 'Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .razzi-slide-button .button-text' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						]
					],
				]
			]
		);

		$repeater->add_control(
			'btn_custom_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .razzi-slide-button .button-text' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],[
							'name'     => 'button_style',
							'operator' => '==',
							'value'    => 'style_1',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'border_style',
			[
				'label'        => __( 'Border', 'razzi' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'razzi' ),
				'label_on'     => __( 'Custom', 'razzi' ),
				'return_value' => 'yes',
			]
		);
		$repeater->start_popover();

		$repeater->add_control(
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
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .button-text' => 'border-style: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
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
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .button-text' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'content_border_color',
			[
				'label'     => __( 'Border Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}} .button-text' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_popover();

		$repeater->add_control(
			'sale_heading_name',
			[
				'label' => esc_html__( 'Sale', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'sale_horizontal_position',
			[
				'label'      => esc_html__( 'Horizontal Position', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}  .razzi-slide__sale' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}  .razzi-slide-content' => 'position: static;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'sale_vertical_position',
			[
				'label'      => esc_html__( 'Vertical Position', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}  .razzi-slide__sale' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-slides-elementor {{CURRENT_ITEM}}  .razzi-slide-content' => 'position: static;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides', 'razzi' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'            => esc_html__( 'Slide 1 Heading', 'razzi' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'razzi' ),
						'button_text'      => esc_html__( 'Click Here', 'razzi' ),
					],
					[
						'title'          => esc_html__( 'Slide 2 Heading', 'razzi' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'razzi' ),
						'button_text'      => esc_html__( 'Click Here', 'razzi' ),
					],
					[
						'title'          => esc_html__( 'Slide 3 Heading', 'razzi' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'razzi' ),
						'button_text'      => esc_html__( 'Click Here', 'razzi' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'      => esc_html__( 'Height', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 530,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .item-slider' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'     => esc_html__( 'Show Lazyload', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'return_value' => 'yes',
				'default'   => '',
				'frontend_available' => true,
			]
		);


		$this->end_controls_section();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'razzi' ),
				'type'  => Controls_Manager::SECTION,
			]
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
				'prefix_class' => 'razzi-products-carousel__centeredslides-'
			]
		);

		$this->add_control(
			'effect',
			[
				'label'   => esc_html__( 'Effect', 'razzi' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'fade'   	 => esc_html__( 'Fade', 'razzi' ),
					'slide' 	 => esc_html__( 'Slide', 'razzi' ),
					'cube' 	 	 => esc_html__( 'Cube', 'razzi' ),
					'coverflow'	 => esc_html__( 'Coverflow', 'razzi' ),
				],
				'default' => 'fade',
				'toggle'  => false,
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

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'none'        => esc_html__( 'None', 'razzi' ),
					'arrows'      => esc_html__( 'Arrows', 'razzi' ),
					'dots' 	      => esc_html__( 'Dots', 'razzi' ),
					'dots-arrows' => esc_html__( 'Dots and Arrows', 'razzi' ),
				],
				'default' => 'arrows',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'razzi' ),
				'label_off'    => __( 'No', 'razzi' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
				'label_on'     => __( 'Yes', 'razzi' ),
				'label_off'    => __( 'No', 'razzi' ),
				'return_value' => 'yes',
				'default'      => '',
				'frontend_available' => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'centeredSlides',
							'operator' => '!=',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();

	}

	// Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_video();
		$this->section_style_sale();
		$this->section_style_carousel();
	}

	// Els
	protected function section_style_beforedesc() {

		$this->add_control(
			'heading_before_title',
			[
				'label'     => esc_html__( 'Before Description', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'beforedesc_color',
			[
				'label'      => esc_html__( 'Text Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-before-desc' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'beforedesc_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-before-desc',
			]
		);

		$this->add_responsive_control(
			'beforedesc_spacing',
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
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-before-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
	}

	protected function section_style_subtitle() {

		$this->add_control(
			'heading_subtitle',
			[
				'label'     => esc_html__( 'SubTitle', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'      => esc_html__( 'Text Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-subtitle',
			]
		);

		$this->add_responsive_control(
			'subtitle_spacing',
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
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
	}

	protected function section_style_title() {

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
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_backgroundcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-heading' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide-heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .razzi-slide-heading',
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
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

	}

	protected function section_style_desc() {
		// Description
		$this->add_control(
			'heading_description',
			[
				'label'     => esc_html__( 'Description', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide-description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .razzi-slide-description',
			]
		);

		$this->add_responsive_control(
			'description_spacing',
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
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner .razzi-slide-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
	}

	protected function section_style_button() {
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
					'{{WRAPPER}} .razzi-slides-elementor .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide-button .button-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'      => esc_html__( 'Color', 'razzi' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide-button .button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .razzi-slide-button .button-text',
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
					'{{WRAPPER}} .razzi-slides-elementor .button-text' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .button-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .button-text' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slides_horizontal_position',
			[
				'label'        => esc_html__( 'Horizontal Position', 'razzi' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'razzi--h-position-',
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'razzi' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'middle',
				'options'      => [
					'top'    => [
						'title' => esc_html__( 'Top', 'razzi' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'razzi' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'razzi' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'razzi--v-position-',
			]
		);

		$this->add_control(
			'slides_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'razzi' ),
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
				'default'     => 'left',
				'selectors'   => [
					'{{WRAPPER}} .razzi-slides-elementor .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide-content' => 'background-color: {{VALUE}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->section_style_title();

		$this->section_style_subtitle();

		$this->section_style_beforedesc();

		$this->section_style_desc();

		$this->section_style_button();

		$this->end_controls_section();

	}

	protected function section_style_video() {
		$this->start_controls_section(
			'section_style_video',
			[
				'label' => esc_html__( 'Video', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'video_play_on_mobile',
			[
				'label'   => esc_html__( 'Play On Mobile', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'video_loop',
			[
				'label'   => esc_html__( 'Loop', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'razzi' ),
				'label_off'    => __( 'Off', 'razzi' ),
				'return_value' => 'on',
				'default'      => 'on',
			]
		);

		$this->add_control(
			'video_sound',
			[
				'label'   => esc_html__( 'Sound', 'razzi' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'razzi' ),
				'label_off'    => __( 'Off', 'razzi' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => esc_html__( 'Aspect Ratio ( Youtube )', 'razzi' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'169' => '16:9',
					'219' => '21:9',
					'43' => '4:3',
					'32' => '3:2',
					'11' => '1:1',
					'916' => '9:16',
				],
				'default' => '169',
				'prefix_class' => 'razzi-slide-banner__ratio--',
				'frontend_available' => true
			]
		);

		$this->end_controls_section();

	}

	protected function section_style_sale() {
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => esc_html__( 'Sale', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'sale_display',
			[
				'label'     => esc_html__( 'Display', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'flex'   => esc_html__( 'Show', 'razzi' ),
					'none' 	  => esc_html__( 'Hidden', 'razzi' ),
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide__sale' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Before Text', 'razzi' ),
				'name'     => 'regular_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .sale-betext',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Text', 'razzi' ),
				'name'     => 'sale_price_typography',
				'selector' => '{{WRAPPER}} .razzi-slides-elementor .sale-text',
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide__sale' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'sale_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide__sale' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'sale_width',
			[
				'label'      => esc_html__( 'Width', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 96,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide__sale' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_height',
			[
				'label'      => esc_html__( 'Height', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 96,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .razzi-slide__sale' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

	}

	protected function section_style_carousel() {
		// Arrows
		$this->start_controls_section(
			'section_style_arrows',
			[
				'label' => esc_html__( 'Slider Options', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Arrows
		$this->add_control(
			'arrow_style_heading',
			[
				'label' => esc_html__( 'Arrows', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrow_style_layout',
			[
				'label'     => esc_html__( 'Style', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1'   	=> esc_html__( 'Style 1', 'razzi' ),
					'2' 	=> esc_html__( 'Style 2', 'razzi' ),
					'3' 	=> esc_html__( 'Style 3', 'razzi' ),
				],
				'prefix_class' => 'razzi-slides-elementor--arrow-style-',
			]
		);

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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-slides-elementor--arrow-style-2 .rz-swiper-button-next' => 'left: calc( {{SIZE}}{{UNIT}} + {{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}} + 15px );',
					'{{WRAPPER}}.razzi-slides-elementor--arrow-style-3 .rz-swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-slides-elementor--arrow-style-3 .rz-swiper-button' => 'left: auto; right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-slides-elementor--arrow-style-3 .rz-swiper-button.rz-swiper-button-prev' => 'right: calc( {{SIZE}}{{UNIT}} + {{sliders_arrows_width.SIZE}}px );',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_vertical',
			[
				'label'      => esc_html__( 'Vertical Position', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-slides-elementor--arrow-style-2 .rz-swiper-button-next, {{WRAPPER}}.razzi-slides-elementor--arrow-style-2 .rz-swiper-button-next' => 'bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-slides-elementor--arrow-style-3 .rz-swiper-button' => 'top: auto; bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->add_control(
			'sliders_arrow_border',
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
			'arrow_border_style',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_border_width',
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
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_content_border_color',
			[
				'label'     => __( 'Border Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-slides-elementor .rz-swiper-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_heading',
			[
				'label' => esc_html__( 'Dots', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dots_style_layout',
			[
				'label'     => esc_html__( 'Style', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1'   	=> esc_html__( 'Style 1', 'razzi' ),
					'2' 	=> esc_html__( 'Style 2', 'razzi' ),
				],
				'prefix_class' => 'razzi-slides-elementor--dots-style-',
			]
		);

		$this->add_control(
			'dots_container',
			[
				'label'   => esc_html__( 'Container', 'razzi' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''          => esc_html__( 'Full Width', 'razzi' ),
					'container' => esc_html__( 'Container', 'razzi' ),
				],
				'default' => 'container',
				'toggle'  => false,
				'conditions' => [
					'terms' => [
						[
							'name' => 'dots_style_layout',
							'operator' => '==',
							'value' => '1',
						],
					],
				],
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
			'sliders_dots_align',
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
				'selectors'   => [
					'{{WRAPPER}} .razzi-slides-elementor .swiper-pagination' => 'text-align: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'dots_style_layout',
							'operator' => '==',
							'value' => '1',
						],
					],
				],
			]
		);

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
					'{{WRAPPER}}.razzi-slides-elementor--dots-style-1 .razzi-slides-elementor .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.razzi-slides-elementor--dots-style-2 .razzi-slides-elementor .swiper-pagination-bullet' => 'margin: {{SIZE}}{{UNIT}} 0',
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
					'{{WRAPPER}} .razzi-slides-elementor .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
						'min' => -100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.razzi-slides-elementor--dots-style-1 .razzi-slides-elementor .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'dots_style_layout',
							'operator' => '==',
							'value' => '1',
						],
					],
				],
			]
		);
		$this->add_responsive_control(
			'sliders_dots_spacing_right',
			[
				'label'     => esc_html__( 'Spacing Right', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.razzi-slides-elementor--dots-style-2 .razzi-slides-elementor .swiper-pagination' => 'right: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'dots_style_layout',
							'operator' => '==',
							'value' => '2',
						],
					],
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
					'{{WRAPPER}} .razzi-slides-elementor .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-slides-elementor .swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-slides-elementor .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'razzi-slides-elementor',
			'razzi-swiper-carousel-elementor',
			'razzi-swiper-slider-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$slides      = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html       = '';
			$btn_attributes   = '';
			$slide_attributes = '';
			$slide_element    = 'div';
			$btn_element      = 'div';

			$slide_html .= '<div class="razzi-slide-content">';

			if ( $slide['title'] ) {
				$slide_html .= '<div class="razzi-slide-heading">' . $slide['title'] . '</div>';
			}

			if ( $slide['subtitle'] ) {
				$slide_html .= '<div class="razzi-slide-subtitle">' . $slide['subtitle'] . '</div>';
			}

			if ( $slide['before_desc'] ) {
				$slide_html .= '<div class="razzi-slide-before-desc">' . $slide['before_desc'] . '</div>';
			}

			if ( $slide['description'] ) {
				$slide_html .= '<div class="razzi-slide-description">' . $slide['description'] . '</div>';
			}

			// Sale
			$sale_betext = $slide['sale_be_text'] ? sprintf('<div class="sale-betext">%s</div>',$slide['sale_be_text']) : '';
			$sale_text = $slide['sale_text'] ? sprintf('<div class="sale-text">%s</div>',$slide['sale_text']) : '';

			$slide_html .=  $sale_betext == '' && $sale_text == '' ? '' : sprintf('<div class="razzi-slide__sale">%s %s</div>',$sale_betext, $sale_text);

			// Button
			$link_icon = $slide['button_style']== 'style_1' && $slide['show_default_icon'] ? \Razzi\Addons\Helper::get_svg('arrow-right', 'razzi-icon') : '';

			$button_class = $slide['button_style'] == 'style_2' ? 'razzi-button--underlined' : 'razzi-button';

			$button_text = $slide['button_text'] ? sprintf('<span class="button-text %s">%s %s</span>',esc_attr($button_class), $slide['button_text'], $link_icon) : '';
			$button_text_2 = $slide['button_text_2'] ? sprintf('<span class="button-text %s">%s %s</span>',esc_attr($button_class), $slide['button_text_2'], $link_icon) : '';

			$key_btn = 'btn_' . $slide_count;
			$key_btn_2 = 'btn2_' . $slide_count;

			$button_text = $slide['link']['url'] ? Helper::control_url( $key_btn, $slide['link'], $button_text, ['class' => 'button-link'] ) : $button_text;
			$button_text_2 = $slide['link_2']['url'] ? Helper::control_url( $key_btn_2, $slide['link_2'], $button_text_2, ['class' => 'button-link'] ) : $button_text_2;

			$slide_html .= '<div class="razzi-slide-button">';
			if ( $slide['button_text'] ) {
				$slide_html .= $button_text;
			}

			if ( $slide['button_text_2'] ) {
				$slide_html .= $button_text_2;
			}
			$slide_html .= '</div>';

			$slide_html .= '</div>';

			$slide_html = '<div class="slick-slide-inner container">' . $slide_html . '</div>';

			if( $slide['link_type'] == 'all' ) {
				$slide_html .= Helper::control_url( 'btn_all', $slide['link'], '', ['class' => 'button-link-all'] );
			}

			$video_html = '';

			if( $slide['banner_type'] == 'video' ) {
				if ( $slide['banner_video_type'] == 'youtube' ) {
					if( $slide['banner_youtube_url'] ) {
						preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $slide['banner_youtube_url'], $id_video );
						$loop = $settings['video_loop'] == 'on' ? '&playlist='.$id_video[1] : '';
						$autoplay = $slide_count == 0 ? '&autoplay=1' : '';
						$sound = $settings['video_sound'] == '' ? '&mute=1' : '';
						$video_html .= '<div class="razzi-slide-banner__video--ytb"><iframe id="razzi-slide-banner__video--'.$slide_count.'" class="razzi-slide-banner__video" data-type="'.$slide['banner_video_type'].'" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" width="100%" height="100%" src="' . $slide['banner_youtube_url'] . '?enablejsapi=1&playsinline=1&playerapiid=ytplayer&showinfo=0&fs=0&modestbranding=0&rel=0&loop=1'.$loop.'&controls=0&autohide=1&html5=1'.$sound.'&start=1'.$autoplay.'"></iframe>';
						if( $settings['video_play_on_mobile'] && $slide_count == 0 ) {
							$video_html .= sprintf( "<script type='text/javascript'>
							var tag = document.createElement('script');
							tag.src = 'https://www.youtube.com/iframe_api';
							var firstScriptTag = document.getElementsByTagName('script')[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
							var player;
							function onYouTubeIframeAPIReady() {
							player = new YT.Player('razzi-slide-banner__video--%d', {
								videoId: '%s',
								playerVars: { 'autoplay': 1, 'playsinline': 1 },
								events: {
									'onReady': onPlayerReady
								}
							});
							}
							function onPlayerReady(event) {
								event.target.playVideo();
							}
						</script>", $slide_count, $id_video[1] );
						}
					  $video_html .= '</div>';
					}
				} else {
					if( $slide['video_external'] == '' ) {
						$video_url = $slide['banner_background_video']['url'];
					} else {
						$video_url = $slide['video_external_url'];
					}

					if( $video_url ) {
						$loop = $settings['video_loop'] == 'on' ? 'loop="true"' : '';
						$sound = $settings['video_sound'] == '' ? 'muted="muted"' : '';
						$video_html .= '<video id="razzi-slide-banner__video--'.$slide_count.'" class="razzi-slide-banner__video" data-type="'.$slide['banner_video_type'].'" src="'.esc_url($video_url).'" '.$sound.' preload="auto" '.$loop.' playsinline></video>';
					}
				}
			}

			$data_lazy_url = $data_lazy_class = $data_lazy_loading = '';

			if ($settings['lazyload'] ) {

				$data_lazy_url = 'data-background="'.$slide['banner_background_img']['url'].'"';
				$data_lazy_loading =  '	<div class="swiper-lazy-preloader"></div>';
				$data_lazy_class = 'swiper-lazy';

			}

			$slides[]   = '<div '. $data_lazy_url .' class="elementor-repeater-item-' . $slide['_id'] . ' item-slider swiper-slide '.$data_lazy_class.'">'.$video_html.'' . $slide_html . $data_lazy_loading .'</div>';

			$slide_count ++;
		}

		if ($slide_count > 1) {
			$output_pagination	=  \Razzi\Addons\Helper::get_svg('chevron-left','rz-swiper-button-prev rz-swiper-button');
			$output_pagination .= \Razzi\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button');
			$output_pagination .= '<div class="swiper-pagination ' . esc_attr( $settings['dots_container'] ) . '"></div>';
		} else {
			$output_pagination = '';
		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				<div class="razzi-slides-elementor__wrapper swiper-container">
					<div class="razzi-slides-elementor__inner swiper-wrapper">%s</div>
				</div>
				%s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $slides ),
			$output_pagination
		);
	}
}