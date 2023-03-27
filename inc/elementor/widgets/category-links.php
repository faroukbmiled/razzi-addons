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
 * Icons Box Carousel widget
 */
class Category_Links extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-category-links';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Category Links', 'razzi' );
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
	}

	protected function content_settings_controls() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Category Links', 'razzi' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'razzi' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link Url', 'razzi' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'razzi' ),
			]
		);

		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Icons Lists', 'razzi' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					], [
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					],[
						'title' => esc_html__( 'This is the title', 'razzi' ),
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_categories();
	}

	protected function section_content_categories() {
		// Content
		$this->start_controls_section(
			'section_category_links',
			[
				'label' => __( 'Category Links', 'razzi' ),
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
					'{{WRAPPER}} .razzi-category-links li:not(:first-child), .razzi-category-links li:not(:last-child)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .razzi-category-links li:first-child' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .razzi-category-links li:last-child' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .razzi-category-links .category-item__title',
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-category-links' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-category-links .category-item__title' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'content_line_color',
			[
				'label'     => __( 'Line Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-category-links li:not(:last-child):after' => 'background-color: {{VALUE}};',
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
			'razzi-category-links',
			'razzi-swiper-carousel-elementor',
		];

		$output =  array();

		$els = $settings['elements'];

		if ( ! empty ( $els ) ) {
			foreach ( $els as $index => $item ) {

				$title = $item['title'] ? sprintf('<div class="category-item__title">%s</div>',$item['title']) : '';

				$links ='';
				if ( ! empty( $item['link']['url'] ) ) {
					$this->add_link_attributes( 'link-'. $index, $item['link'] );

					$links = '<a ' . $this->get_render_attribute_string( 'link-'. $index ) . ' class="category-item__link"> ' . $title . '</a>';
				} else {
					$links = $title;
				}


				$output_content = $links;

				$output[] = sprintf( '<li class="category-item">%s</li>', $output_content );
			}

		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				<div class="razzi-category-links__wrapper">
					<ul class="razzi-category-links__inner">%s</ul>
				</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode('', $output)
		);
	}
}