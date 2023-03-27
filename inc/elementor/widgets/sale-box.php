<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow ;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Sale Box widget
 */
class Sale_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-sale-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Sale Box', 'razzi' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-counter';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'razzi' ];
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
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'razzi' ) ]
		);

		$this->add_control(
			'content_text',
			[
				'label'       => esc_html__( 'Text', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Text', 'razzi' ),
			]
		);

		$this->add_control(
			'content_number',
			[
				'label'       => esc_html__( 'Number', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 30,
			]
		);

		$this->add_control(
			'content_unit',
			[
				'label'       => esc_html__( 'Unit', 'razzi' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '%',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->start_controls_section(
			'style_general',
			[
				'label' => __( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-sale-box__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_bg',
			[
				'label'        => esc_html__( 'Background Color', 'razzi' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-sale-box__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_text_heading',
			[
				'label' => esc_html__( 'Text', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_text_color',
			[
				'label'        => esc_html__( 'Color', 'razzi' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-sale-box__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_text_typo',
				'selector' => '{{WRAPPER}} .razzi-sale-box__text',
			]
		);

		$this->add_responsive_control(
			'content_text_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-sale-box__text' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_count_heading',
			[
				'label' => esc_html__( 'Count', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_count_color',
			[
				'label'        => esc_html__( 'Color', 'razzi' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-sale-box__count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_count_typo',
				'selector' => '{{WRAPPER}} .razzi-sale-box__count',
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
			'razzi-sale-box'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="razzi-sale-box__content">
				<div class="razzi-sale-box__text"><?php echo $settings['content_text'] ?></div>
				<div class="razzi-sale-box__count">
					<div class="razzi-sale-box__number"><?php echo $settings['content_number'] ?></div>
					<div class="razzi-sale-box__unit"><?php echo $settings['content_unit'] ?></div>
				</div>
			</div>
		</div>
		<?php
	}
}