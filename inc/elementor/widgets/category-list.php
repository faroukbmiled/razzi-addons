<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Category List widget
 */
class Category_List extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-category-list';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Category List', 'razzi' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-editor-list-ol';
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
			[ 'label' => esc_html__( 'Category List', 'razzi' ) ]
		);

		$this->add_control(
			'type_list',
			[
				'label'       => esc_html__( 'Type', 'razzi' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'category'       => esc_html__( 'Categories', 'razzi' ),
					'tag'            => esc_html__( 'Tags', 'razzi' ),
					'product_cat'    => esc_html__( 'Product Categories', 'razzi' ),
					'product_tag'    => esc_html__( 'Product Tags', 'razzi' ),
					'product_brands' => esc_html__( 'Product Brands', 'razzi' ),
				],
				'default'     => 'product_cat',
				'label_block' => true,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Categories', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'category',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'type_list',
							'value' => 'category',
						],
					],
				],
			]
		);

		$this->add_control(
			'tag',
			[
				'label'       => esc_html__( 'Tags', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'tag',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'type_list',
							'value' => 'tag',
						],
					],
				],
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
				'conditions' => [
					'terms' => [
						[
							'name' => 'type_list',
							'value' => 'product_cat',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_tag',
			[
				'label'       => esc_html__( 'Products Tags', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'type_list',
							'value' => 'product_tag',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_brands',
			[
				'label'       => esc_html__( 'Products Brands', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'type_list',
							'value' => 'product_brand',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->start_controls_section(
			'section_category_links',
			[
				'label' => __( 'Category List', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-category-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'razzi' ),
				'selector' => '{{WRAPPER}} .razzi-category-list',
			]
		);

		$this->add_control(
			'item',
			[
				'label'     => esc_html__( 'Items', 'razzi' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-category-list__item a' => 'color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-category-list__item a:hover' => 'color: {{VALUE}};',
				],
				'default'   => '',
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

		$type = $settings[ 'type_list' ];

		$lists = explode( ',', $settings[$type]);
		?>
		<div class="razzi-category-list">
			<?php foreach( $lists as $key => $slug ) : ?>
			<?php
				$term = get_term_by( 'slug', $slug, $type );

				if( ! empty( $term ) ) :
			?>
					<div class="razzi-category-list__item">
						<a href="<?php echo get_term_link( $term->term_id ); ?>">
						<?php echo $term->name; ?>
						<span class="razzi-category-list__count">(<?php echo $term->count; ?>)</span>
					</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php
	}
}