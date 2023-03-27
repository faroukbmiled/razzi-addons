<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Products Carousel With Thumbnails widget
 */
class Products_Carousel_With_Thumbnails extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-products-carousel-with-thumbnails';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Products Carousel With Thumbnails', 'razzi' );
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
		$scripts = [
			'razzi-product-shortcode'
		];

		return $scripts;
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
			'source',
			[
				'label'       => esc_html__( 'Source', 'razzi' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'razzi' ),
					'custom'  => esc_html__( 'Custom', 'razzi' ),
				],
				'default'     => 'default',
				'label_block' => true,
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'razzi' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 2,
				'max'     => 38,
				'step'    => 1,
				'condition'   => [
					'source' => 'default',
				],
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
					'source' => 'custom',
				],
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
				],
				'default'   => 'recent',
				'toggle'    => false,
				'condition'   => [
					'source' => 'default',
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
							'name'  => 'source',
							'value' => 'default',
						],
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'best_selling',
						],
					]
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
							'name'  => 'source',
							'value' => 'default',
						],
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'best_selling',
						],
					]
				],
			]
		);

		$this->add_control(
			'product_category',
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
				'condition'   => [
					'source' => 'default',
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
				'condition'   => [
					'source' => 'default',
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
				'condition'   => [
					'source' => 'default',
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
					'condition'   => [
						'source' => 'default',
					],
				]
			);
		}

		$this->add_control(
			'product_outofstock',
			[
				'label'        => esc_html__( 'Show Out Of Stock Products', 'razzi' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'razzi' ),
				'label_off'    => esc_html__( 'Hide', 'razzi' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'attributes_divider',
			[
				'label' => esc_html__( 'Attributes', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_quickview',
			[
				'label'     => esc_html__( 'Quick View', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi' ),
				'label_on'  => __( 'Show', 'razzi' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_addtocart',
			[
				'label'     => esc_html__( 'Add To Cart', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi' ),
				'label_on'  => __( 'Show', 'razzi' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_wishlist',
			[
				'label'     => esc_html__( 'Wishlist', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi' ),
				'label_on'  => __( 'Show', 'razzi' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_featured_icons_mobile',
			[
				'label'     => esc_html__( 'Show Featured Icons Mobile', 'razzi' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi' ),
				'label_on'  => __( 'Show', 'razzi' ),
				'return_value' => 'show',
				'default'   => 'show',
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
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'razzi' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'     => esc_html__( 'None', 'razzi' ),
					'arrows' => esc_html__( 'Arrows', 'razzi' ),
					'dots' => esc_html__( 'Dots', 'razzi' ),
					'dots-arrows' => esc_html__( 'Dots and Arrows', 'razzi' ),
				],
				'default'   => 'dots',
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

	// Content Settings
	protected function section_content_style_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Settings', 'razzi' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_large_name',
			[
				'label' => esc_html__( 'Image Large', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'image_large_width',
			[
				'label'      => esc_html__( 'Container Width', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .products-carousel-with-thumbnails__image-box .product-thumbnail__image' => 'flex: 1 1 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_large',
				'default'   => 'full',
			]
		);

		$this->add_control(
			'image_small_name',
			[
				'label' => esc_html__( 'Image Gallery', 'razzi' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_small_width',
			[
				'label'      => esc_html__( 'Container Width', 'razzi' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .products-carousel-with-thumbnails__image-box .product-thumbnail__gallery' => 'flex: 1 1 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_small',
				'default'   => 'full',
			]
		);

		$this->end_controls_section();
	}

	// Carousel Settings
	protected function section_carousel_style_controls() {
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
				'separator' => 'before',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-products-carousel-with-thumbnails .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-carousel-with-thumbnails .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			'razzi-products-carousel-with-thumbnails razzi-swiper-carousel-elementor woocommerce razzi-swiper-slider-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
			$settings['show_quickview'] != '' ? 'show-quickview' : '',
			$settings['show_addtocart'] != '' ? 'show-addtocart' : '',
			$settings['show_wishlist'] != '' ? 'show-wishlist' : '',
			$settings['show_quickview'] == '' && $settings['show_addtocart'] == '' && $settings['show_wishlist'] == '' ? 'btn-hidden' : ''
		];

		$this->add_render_attribute( 'wrapper', [
			'class' 			=> $classes,
			'data-nonce' 		=> wp_create_nonce( 'razzi_get_products' )
		] );

		if( $settings['source'] == 'default' ) {
			$attr = [
				'products' 			=> $settings['products'],
				'orderby'  			=> $settings['orderby'],
				'order'    			=> $settings['order'],
				'category'    		=> $settings['product_category'],
				'tag'    			=> $settings['product_tag'],
				'product_brands'    => $settings['product_brands'],
				'limit'    			=> $settings['limit'],
				'paginate'			=> true,
			];

			if ( taxonomy_exists( 'product_author' ) ) {
				$attr['product_authors'] = $settings['product_authors'];
			}

			if ( isset( $settings['product_outofstock'] ) && empty( $settings['product_outofstock'] ) ) {
				$attr['product_outofstock'] = $settings['product_outofstock'];
			}

			$results = Helper::products_shortcode( $attr );
			if ( ! $results ) {
				return;
			}

			$product_ids = $results['ids'];
		} else {
			$product_ids = explode( ",",$settings['ids'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php

			update_meta_cache( 'post', $product_ids );
			update_object_term_cache( $product_ids, 'product' );
			$original_post = $GLOBALS['post'];

			$class_mobile = 'mobile-show-atc';

			if ( $settings['show_featured_icons_mobile'] == 'show' ) {
				$class_mobile .= ' mobile-show-featured-icons';
			}

			if( class_exists('\Razzi\Helper') && method_exists('\Razzi\Helper', 'get_option') ) {
				if ( $mobile_pl_col = intval( \Razzi\Helper::get_option( 'mobile_landscape_product_columns' ) ) ) {
					$class_mobile .= ' mobile-pl-col-' . $mobile_pl_col;
				}

				if ( $mobile_pp_col = intval( \Razzi\Helper::get_option( 'mobile_portrait_product_columns' ) ) ) {
					$class_mobile .= ' mobile-pp-col-' . $mobile_pp_col;
				}
			}

			echo '<ul class="products product-loop-layout-8 razzi-products-carousel-with-thumbnails__content '. esc_attr( $class_mobile ) .'">';

			$output = array();
			foreach ( $product_ids as $product_id ) {
				global $product;

				$product = wc_get_product( $product_id );
				$title = get_the_title( $product_id );
				$image_id = get_post_thumbnail_id( $product_id );
				$image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_large', [
					'image_large_size' => $settings['image_large_size'],
					'image_large_custom_dimension' => $settings['image_large_custom_dimension'],
				] );

				$gallery_src = '';
				$gallery_html = array();

				if( class_exists('\Razzi\Helper') && method_exists('\Razzi\Helper', 'get_option') ) {
					$featured_icons = (array) \Razzi\Helper::get_option( 'product_loop_featured_icons' );
				}

				if( class_exists('\Razzi\WooCommerce\Helper') && method_exists('\Razzi\WooCommerce\Helper', 'quick_view_button') ) {
					ob_start();
					$quickview = in_array( 'qview', $featured_icons ) ? \Razzi\WooCommerce\Helper::quick_view_button() : '';
					$quickview = ob_get_clean();
				}

				if( class_exists('\Razzi\WooCommerce\Helper') && method_exists('\Razzi\WooCommerce\Helper', 'wishlist_button') ) {
					ob_start();
					$wishlist = in_array( 'wlist', $featured_icons ) ? \Razzi\WooCommerce\Helper::wishlist_button() : '';
					$wishlist = ob_get_clean();
				}

				if( class_exists('\Razzi\WooCommerce\Helper') && method_exists('\Razzi\WooCommerce\Helper', 'product_taxonomy') ) {
					ob_start();
					$taxonomy = \Razzi\WooCommerce\Helper::product_taxonomy();
					$taxonomy = ob_get_clean();
				}

				if( class_exists('\Razzi\WooCommerce\Helper') && method_exists('\Razzi\WooCommerce\Helper', 'product_loop_title') ) {
					ob_start();
					$loop_title = \Razzi\WooCommerce\Helper::product_loop_title();
					$loop_title = ob_get_clean();
				}

				ob_start();
				$price = woocommerce_template_loop_price();
				$price = ob_get_clean();

				ob_start();
				$atc_button = woocommerce_template_loop_add_to_cart();
				$atc_button = ob_get_clean();

				for( $i=0; $i<3; $i++ ) {
					$image_ids = $product->get_gallery_image_ids();

					if( ! empty( $image_ids[$i] ) ) {
						$gallery_src = Group_Control_Image_Size::get_attachment_image_src( $image_ids[$i], 'image_small', [
							'image_small_size' => $settings['image_small_size'],
							'image_small_custom_dimension' => $settings['image_small_custom_dimension'],
						] );

						$gallery_html[] = '<img alt="'. esc_html( $title ) .'" src="'. esc_url( $gallery_src ) .'"/>';
					}
				}

				$output[] = sprintf(
					'<li class="layout-v1 product">
						<div class="product-inner">
							<div class="product-thumbnail">
								<a class="woocommerce-LoopProduct-link woocommerce-loop-product__link products-carousel-with-thumbnails__image-box" href="%s">
									<span class="product-thumbnail__image">
										<img alt="%s" src="%s"/>
									</span>
									<span class="product-thumbnail__gallery">%s</span>
								</a>
								<div class="product-loop-inner__buttons">%s%s</div>
							</div>
							<div class="product-summary">
								<div class="product-loop__top">
									<div class="product-loop__cat-title">
									%s
									<h2 class="woocommerce-loop-product__title">
										<a href="%s" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">%s</a>
									</h2>
									</div>
									%s
								</div>
								<div class="product-loop__buttons">%s%s%s</div>
							</div>
						</div>
					</li>',
					esc_url( get_permalink($product_id) ),
					esc_html( $title ),
					$image_src,
					implode( '', $gallery_html ),
					$quickview,
					$wishlist,
					$taxonomy,
					esc_url( get_permalink( $product_id ) ),
					$title,
					$price,
					$atc_button,
					$quickview,
					$wishlist
				);

			}

			echo implode( '', $output );

			$GLOBALS['post'] = $original_post; // WPCS: override ok.

			echo '</ul>';

			wp_reset_postdata();

			?>
		</div>
		<?php
	}
}