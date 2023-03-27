<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Listing extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-products-listing';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Products Listing', 'razzi' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
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

	// Tab Content
	protected function section_content() {
		$this->section_products_settings_controls();
		$this->section_carousel_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_content_style_controls();
		$this->section_carousel_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'razzi' ) ]
		);

		$this->add_control(
			'heading',
			[
				'label'     => esc_html__( 'Title', 'razzi' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'razzi' ),
					'featured'     => esc_html__( 'Featured', 'razzi' ),
					'best_selling' => esc_html__( 'Best Selling', 'razzi' ),
					'top_rated'    => esc_html__( 'Top Rated', 'razzi' ),
					'sale'         => esc_html__( 'On Sale', 'razzi' ),
					'custom'         => esc_html__( 'Custom', 'razzi' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
			]
		);

		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Products', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'condition'   => [
					'products' => 'custom',
				],
			]
		);

		$this->add_control(
			'product_cats',
			[
				'label'       => esc_html__( 'Product Categories', 'razzi' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_tags',
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
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
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
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		if ( taxonomy_exists( 'product_author' ) ) {
			$this->add_control(
				'product_authors',
				[
					'label'       => esc_html__( 'Products Authors', 'razzi' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'razzi' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => true,
					'source'      => 'product_author',
					'sortable'    => true,
					'conditions' => [
						'terms' => [
							[
								'name' => 'products',
								'operator' => '!=',
								'value' => 'custom',
							],
						],
					],
				]
			);
		}

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'razzi' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'razzi' ),
					'date'       => esc_html__( 'Date', 'razzi' ),
					'title'      => esc_html__( 'Title', 'razzi' ),
					'menu_order' => esc_html__( 'Menu Order', 'razzi' ),
					'rand'       => esc_html__( 'Random', 'razzi' ),
				],
				'default'   => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!in',
							'value' => [ 'best_selling', 'custom' ],
						],
					],
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'razzi' ),
					'asc'  => esc_html__( 'Ascending', 'razzi' ),
					'desc' => esc_html__( 'Descending', 'razzi' ),
				],
				'default'   => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!in',
							'value' => [ 'best_selling', 'custom' ],
						],
					],
				],
			]
		);

		$this->add_control(
			'product_outofstock',
			[
				'label'        => esc_html__( 'Show Out Of Stock Products', 'razzi' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'razzi' ),
				'label_off'    => esc_html__( 'Hide', 'razzi' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'razzi' ) ]
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
			'slidesRows',
			[
				'label'           => esc_html__( 'Rows', 'razzi' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 50,
				'default' 		=> 1,
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
					'arrows' => esc_html__( 'Arrows', 'razzi' ),
					'dots' => esc_html__( 'Dots', 'razzi' ),
				],
				'default'   => 'arrows',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'default'   => '',
				'frontend_available' => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'slidesRows',
							'operator' => '==',
							'value' => '1',
						],
					],
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi' ),
				'label_on'  => __( 'On', 'razzi' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Speed', 'razzi' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 800,
				'min'         => 100,
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'razzi' ),
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_style_controls() {
		// Content Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_style_divider',
			[
				'label' => __( 'Product', 'razzi' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'product_hide_box_shadow',
			[
				'label'        => esc_html__( 'Hide Box Shadow', 'razzi' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'razzi' ),
				'label_on'     => __( 'On', 'razzi' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'razzi-products-listing-hide-box-shadow-'
			]
		);

		$this->add_responsive_control(
			'product_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing__item-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_style_divider',
			[
				'label' => __( 'Title', 'razzi' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-products-listing__heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => __( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 350,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'navigation',
							'operator' => '!=',
							'value' => 'arrows',
						],
					],
				]

			]
		);

		$this->add_responsive_control(
			'heading_arrows_spacing',
			[
				'label'     => __( 'Spacing', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 350,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__heading' => 'margin-bottom: 0;',
					'{{WRAPPER}} .razzi-products-listing__heading--arrows' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'navigation',
							'value' => 'arrows',
						],
					],
				],
			]
		);

		$this->add_control(
			'image_style_divider',
			[
				'label' => __( 'Image', 'razzi' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_style_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'carousel_divider',
			[
				'label' => __( 'Arrows', 'razzi' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'arrows_font_size',
			[
				'label'     => __( 'Size', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_horizontal',
			[
				'label'      => __( 'Horizontal Position', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 200,
						'max' => 300,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-listing__heading--arrows .razzi-products-listing__arrows' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_button',
			[
				'label'      => __( 'Spacing Button', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -50,
						'max' => 300,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing__heading--arrows .razzi-products-listing__arrows .rz-swiper-button-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'razzi' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-listing .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'carousel_style_divider_2',
			[
				'label' => __( 'Dots', 'razzi' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dots_font_size',
			[
				'label'     => __( 'Size', 'razzi' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing .swiper-pagination .swiper-pagination-bullet::before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__( 'Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dots_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'razzi' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-products-listing .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing_item',
			[
				'label'      => __( 'Item Space', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'      => __( 'Space', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
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

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'razzi-products-listing razzi-swiper-carousel-elementor woocommerce razzi-swiper-slider-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$title = $settings['heading'] ? sprintf('<div class="razzi-products-listing__heading">%s</div>', $settings['heading'] ) : '';

		$settings['columns'] = intval( $settings['slidesToShow'] );
		$products            = sprintf( '<ul class="razzi-products-listing__items products">%s</ul>', $this->get_categories_content( $settings ) );

		$arrows = sprintf( '%s%s',
			\Razzi\Addons\Helper::get_svg('chevron-left', 'rz-swiper-button-prev rz-swiper-button'),
			\Razzi\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button')
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php printf( '<div class="razzi-products-listing__heading--arrows">%s<div class="razzi-products-listing__arrows">%s</div></div>%s', $title, $arrows, $products ); ?>
		</div>
		<?php
	}

	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {
		$output = [];

		$attr = [
			'products' 			=> $settings['products'],
			'orderby'  			=> $settings['orderby'],
			'order'    			=> $settings['order'],
			'category'    		=> $settings['product_cats'],
			'tag'    			=> $settings['product_tags'],
			'product_brands'    => $settings['product_brands'],
			'limit'    			=> $settings['per_page'],
			'product_ids'   	=> explode(',', $settings['ids']),
			'paginate'			=> true,
		];

		if ( taxonomy_exists( 'product_author' ) ) {
			$attr['product_authors'] = $settings['product_authors'];
		}

		if ( isset( $settings['product_outofstock'] ) && empty( $settings['product_outofstock'] ) ) {
			$attr['product_outofstock'] = $settings['product_outofstock'];
		}

		$product_ids = Helper::products_shortcode( $attr );

		$product_ids = ! empty($product_ids) ? $product_ids['ids'] : 0;


		foreach ( $product_ids as $product_id ) {
			$_product = wc_get_product( $product_id );
			$price = wp_kses_post( $_product->get_price_html() );
			$image_id = get_post_thumbnail_id( $product_id );
			$image = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image', $settings );
			$title = esc_html( get_the_title( $product_id ) );

			$output[] = '<li class="razzi-products-listing__item product">';
			$output[] = '<a class="razzi-products-listing__item-box" href="'.get_permalink($product_id).'">';
			if( $image ) {
				$output[] = sprintf( '<img src="%s" alt="%s" class="razzi-products-listing__image">', $image, $title );
			}
			$output[] = '<span class="razzi-products-listing__content">';
			$output[] = sprintf( '<span class="razzi-products-listing__title">%s</span>', $title );
			$output[] = sprintf( '<span class="razzi-products-listing__price price">%s</span>', $price );
			$output[] = '</span>';
			$output[] = '</a>';
			$output[] = '</li>';
		}


		return implode( '', $output );
	}


}