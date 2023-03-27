<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner Medium widget
 */
class Promo_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-promo-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Promo Box', 'razzi' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-banner';
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
			'razzi-elementor'
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

	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Promo Box', 'razzi' ) ]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'razzi' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1170X600/cccccc?text=Image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);


		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'razzi' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is title', 'razzi' ),
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => esc_html__( 'Description', 'razzi' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your description', 'razzi' ),
				'separator' => 'none',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Button Text', 'razzi' ),
			]
		);

		$this->add_control(
			'show_default_icon',
			[
				'label'     => esc_html__( 'Show Button Icon', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'return_value' => 'yes',
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'link', [
				'label'         => esc_html__( 'Button Link', 'razzi' ),
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

		$this->add_control(
			'regular_price',
			[
				'label'       => esc_html__( 'Before Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'razzi' ),
				'label_block' => true,
				'default'     => __( '$99.00', 'razzi' ),
			]
		);

		$this->add_control(
			'sale_price',
			[
				'label'       => esc_html__( 'Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'razzi' ),
				'label_block' => true,
				'default'     => __( '$59.00', 'razzi' ),
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'        => esc_html__( 'Position Content', 'razzi' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'bottom',
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-h-align-left',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'razzi' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'razzi-promo-box__content-position--',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'price_box_position',
			[
				'label'     => esc_html__( 'Position Sale', 'razzi' ),
				'type'         => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'razzi-promo-box__price-position--',
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'razzi' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only'   => esc_html__( 'Only button text', 'razzi' ),
					'all' 	 => esc_html__( 'All banner', 'razzi' ),
				],
				'default' => 'only',
				'toggle'  => false,

			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style(){
		$this->section_style_banner();
		$this->section_style_content();
		$this->section_style_sale();
	}

	protected function section_style_banner(){
		// Banner
		$this->start_controls_section(
			'section_style_banner',
			[
				'label' => esc_html__( 'Promo Box', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'badge_min_width',
			[
				'label'     => esc_html__( 'Width (%)', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box' => 'width: {{SIZE}}%',
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Margin', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-promo-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_content() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'banner_text_align',
			[
				'label'       => esc_html__( 'Vertical Align', 'razzi' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'razzi' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'razzi' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'banner_content_align',
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_top',
			[
				'label'     => esc_html__( 'Spacing Top', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'top: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'left',
						],
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'right',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_bottom',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_left',
			[
				'label'     => esc_html__( 'Spacing Left', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'left: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'left',
						],
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'bottom',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_right',
			[
				'label'     => esc_html__( 'Spacing Right', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__content' => 'right: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'bottom',
						],
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'right',
						],
					],
				],
			]
		);

		// Title
		$this->add_control(
			'heading_content_style_title',
			[
				'label' => esc_html__( 'Title', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .razzi-promo-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .razzi-promo-box__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box .razzi-promo-box__title' => 'color: {{VALUE}};',
				],
			]
		);

		// Description
		$this->add_control(
			'heading_description',
			[
				'label' => esc_html__( 'Description', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .razzi-promo-box__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .razzi-promo-box__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box .razzi-promo-box__description' => 'color: {{VALUE}};',
				],
			]
		);

		// btn
		$this->add_control(
			'heading_content_btn_style',
			[
				'label' => esc_html__( 'Button', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'note_typography',
				'selector' => '{{WRAPPER}} .razzi-promo-box__button',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_style_sale(){
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => esc_html__( 'Sale', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Before Text', 'razzi' ),
				'name'     => 'regular_typography',
				'selector' => '{{WRAPPER}} .razzi-promo-box__sale .regular-price',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Text', 'razzi' ),
				'name'     => 'sale_price_typography',
				'selector' => '{{WRAPPER}} .razzi-promo-box__sale .sale-price',
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__sale' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .razzi-promo-box__sale' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_top',
			[
				'label'     => esc_html__( 'Spacing Top', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__sale' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_left',
			[
				'label'     => esc_html__( 'Spacing Left', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__sale' => 'left: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'terms' => [
						[
						'name' => 'price_box_position',
						'value' => 'left',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_right',
			[
				'label'     => esc_html__( 'Spacing Right', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__sale' => 'right: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'terms' => [
						[
						'name' => 'price_box_position',
						'value' => 'right',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'price_box_width',
			[
				'label'     => esc_html__( 'Width (px)', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__sale' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'price_box_height',
			[
				'label'     => esc_html__( 'Height (px)', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-promo-box__sale' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}



	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'razzi-promo-box',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$link_icon = $settings['show_default_icon'] ? \Razzi\Addons\Helper::get_svg('arrow-right', 'razzi-icon') : '';

		$button_text = $settings['button_text'] ? sprintf('%s%s',$settings['button_text'], $link_icon) : '';

		$btn_full ='';
		if ( $settings['link']['url'] ) :
			$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( 'btn_full', $settings['link'], '', [ 'class' => 'razzi-promo-box__link' ] ) : '';
			$button_text = Helper::control_url( 'btn', $settings['link'], $button_text, ['class' => 'razzi-promo-box__button razzi-button button-normal'] );
		endif;

		$title = $settings['title'] ? sprintf('<h3 class="razzi-promo-box__title">%s</h3>',$settings['title']) : '';

		$description = $settings['description_text'] ? sprintf('<p class="razzi-promo-box__description">%s</p>',$settings['description_text']) : '';

		// Sale
		$regular_price = $settings['regular_price'] ? sprintf('<div class="regular-price">%s</div>',$settings['regular_price']) : '';
		$sale_price = $settings['sale_price'] ? sprintf('<div class="sale-price">%s</div>',$settings['sale_price']) : '';

		$html_sale =  $regular_price == '' && $sale_price == '' ? '' : sprintf('<div class="razzi-promo-box__sale">%s %s</div>',$regular_price,$sale_price);

		$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
		$image = $image ? sprintf('<div class="razzi-promo-box__image image-zoom">%s</div>',$image) : '';

		$output  = $image;
		$output .= '<div class="razzi-promo-box__content">';
		$output .= $title;
		$output .= $description;
		$output .= $button_text;
		$output .= '</div>';
		$output .= $html_sale;
		$output .= $btn_full;

		echo sprintf(
			'<div %s> %s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$output
		);
	}
}