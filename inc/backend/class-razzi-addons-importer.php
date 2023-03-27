<?php
/**
 * Hooks for importer
 *
 * @package Razzi
 */

namespace Razzi\Addons;


/**
 * Class Importter
 */
class Importer {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'soo_demo_packages', array( $this, 'importer' ), 20 );
		add_action( 'soodi_after_setup_pages', array( $this, 'setup_pages' ) );
		add_action( 'soodi_before_import_content', array( $this,'import_product_attributes') );
		add_action( 'soodi_after_download_file',  array( $this, 'setup_options' ));

	}

	/**
	 * Importer the demo content
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function importer() {
		return array(
			array(
				'name'       => 'Home v1 - Minimal',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev1-minimal/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev1-minimal/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev1-minimal/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev1-minimal/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 1',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v2 - Classic',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev2-classic/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev2-classic/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev2-classic/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev2-classic/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 2',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v3 - Fashion',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev3-fashion/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev3-fashion/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev3-fashion/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev3-fashion/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 3',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v4 - Boxes',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev4-boxes/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev4-boxes/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev4-boxes/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev4-boxes/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 4',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v5 - Simple',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev5-simple/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev5-simple/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev5-simple/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev5-simple/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 5',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v6 - Asymmetric',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev6-asymmetric/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev6-asymmetric/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev6-asymmetric/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev6-asymmetric/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 6',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v7 - Masonry',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev7-masonry/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev7-masonry/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev7-masonry/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev7-masonry/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 7',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v8 - Landing',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev8-landing/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev8-landing/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev8-landing/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev8-landing/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 8',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v9 - Fashion',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev9-fashion/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev9-fashion/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev9-fashion/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev9-fashion/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 10',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v10 - Cases',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev10-cases/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev10-cases/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev10-cases/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev10-cases/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 11',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v11 - Furniture',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev11-furniture/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev11-furniture/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev11-furniture/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev11-furniture/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 1',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v12 - Furniture',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev12-furniture/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev12-furniture/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev12-furniture/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev12-furniture/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 12',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v13 - Furniture',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev13-furniture/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev13-furniture/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev13-furniture/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev13-furniture/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 13',
					'blog'       => 'Blog',
					'shop'       => 'Home 13',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v14 - Furniture',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev14-furniture/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev14-furniture/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev14-furniture/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev14-furniture/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 2',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v15 - Furniture',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev15-furniture/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev15-furniture/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev15-furniture/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev15-furniture/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 3',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v16 Instagram',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev16-instagram/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev16-instagram/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev16-instagram/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev16-instagram/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Instagram',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v17 - Interior Decor',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev17-interior/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev17-interior/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev17-interior/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev17-interior/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 17',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu-home-v17',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu-home-v17',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu-home-v17',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v18 - Food',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev18-food/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev18-food/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev18-food/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev18-food/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 18',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v19 - Electronic',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev19-electronic/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev19-electronic/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev19-electronic/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev19-electronic/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 19',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v20 - Parallax',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev20-parallax/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev20-parallax/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev20-parallax/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev20-parallax/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home 20',
					'blog'       => 'Blog',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v21 - Cosmetic',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev21-cosmetic/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev21-cosmetic/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev21-cosmetic/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev21-cosmetic/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Cosmetics',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v22 - Full Width',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev22-fullwidth/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev22-fullwidth/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev22-fullwidth/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev22-fullwidth/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Fashion',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v23 - Jewelry',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev23-jewelry/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev23-jewelry/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev23-jewelry/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev23-jewelry/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Jewelry',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v24 - Baby',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev24-baby/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev24-baby/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev24-baby/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev24-baby/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Baby',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'secondary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v25 - Furniture',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev25-furniture/preview.png',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev25-furniture/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev25-furniture/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev25-furniture/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Furniture',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'mobile-categoies',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v26 - Pharmacy',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev26-pharmacy/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev26-pharmacy/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev26-pharmacy/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev26-pharmacy/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Pharmacy',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v27 - Tools',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev27-tools/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev27-tools/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev27-tools/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev27-tools/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Tools',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v28 - Nails',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev28-nails/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev28-nails/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev28-nails/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev28-nails/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Nails',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'department' 	=> 'mobile-categoies',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v29 - Fashion Sport',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev29-fashion/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev29-fashion/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev29-fashion/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev29-fashion/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Fashion Sport',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v30 - Books',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev30-books/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev30-books/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev30-books/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev30-books/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Books',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'hamburger' 	=> 'primary-menu',
					'socials' 		=> 'social-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v31 - Grocery',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev31-grocery/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev31-grocery/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev31-grocery/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev31-grocery/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Grocery',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v32 - Shoes',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev32-shoes/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev32-shoes/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev32-shoes/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev32-shoes/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Shoes',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v33 - Watches',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev33-watches/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev33-watches/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev33-watches/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev33-watches/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Watches',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v34 - Handmade',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev34-handmade/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev34-handmade/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev34-handmade/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev34-handmade/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Handmade',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v35 - Glasses',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev35-glasses/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev35-glasses/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev35-glasses/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev35-glasses/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Glasses',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v36 - Decor',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev36-decor/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev36-decor/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev36-decor/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev36-decor/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Decor',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v37 - Black Friday',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev37-black-friday/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev37-black-friday/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev37-black-friday/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev37-black-friday/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Black Friday',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v38 - Bags',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev38-bags/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev38-bags/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev38-bags/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev38-bags/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Bags',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v39 - Accessories',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev39-accessories/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev39-accessories/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev39-accessories/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev39-accessories/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Accessories',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v40 - Coffee',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev40-coffee/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev40-coffee/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev40-coffee/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev40-coffee/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Coffee',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
			array(
				'name'       => 'Home v41 - Video Banner',
				'preview'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev41-video-slider/preview.jpg',
				'content'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev41-video-slider/demo-content.xml',
				'customizer' => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev41-video-slider/customizer.dat',
				'widgets'    => 'https://drfuri-demo-images.s3.us-west-1.amazonaws.com/razzi/homev41-video-slider/widgets.wie',
				'pages'      => array(
					'front_page' => 'Home Fashion Video Slider',
					'blog'       => 'Our Blogs',
					'shop'       => 'Shop',
					'cart'       => 'Cart',
					'checkout'   => 'Checkout',
					'my_account' => 'My Account',
				),
				'menus'      => array(
					'primary' 		=> 'primary-menu',
					'secondary' 	=> 'footer-extra',
					'socials' 		=> 'social-menu',
					'department' 	=> 'department-menu',
					'mobile' 		=> 'primary-menu',
				),
				'options'    => array(
					'shop_catalog_image_size'   => array(
						'width'  => 370,
						'height' => 370,
						'crop'   => 1,
					),
					'shop_single_image_size'    => array(
						'width'  => 670,
						'height' => 670,
						'crop'   => 1,
					),
					'shop_thumbnail_image_size' => array(
						'width'  => 70,
						'height' => 70,
						'crop'   => 1,
					),
				),
			),
		);
	}

	function setup_pages($demo) {
		// WooCommerce Pages
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		if ( isset( $demo['shop'] ) && $demo['shop'] == 'Home 13' ) {
			$shop = get_page_by_title( $demo['shop'] );

			if ( $shop ) {
				update_option( 'woocommerce_shop_page_id', $shop->ID );
			}
		}

	}

	function setup_options($demo) {
		if ( isset( $demo['front_page'] ) && $demo['front_page'] == 'Home Nails' ) {
			update_option( 'razzi_product_tab', 'yes' );
		} elseif ( isset( $demo['front_page'] ) && $demo['front_page'] == 'Home Books' ) {
			update_option( 'product_author_slug', true );
			update_option( 'product_brand_slug', true );
			update_option( 'razzi_product_tab', 'yes' );
		} elseif ( isset( $demo['front_page'] ) && $demo['front_page'] == 'Home Fashion Sport' ) {
			update_option( 'razzi_product_tab', 'yes' );
		}

	}

	/**
	 * Prepare product attributes before import demo content
	 *
	 * @param $file
	 */
	function import_product_attributes( $file ) {
		global $wpdb;

		if ( ! class_exists( 'WXR_Parser' ) ) {
			if ( ! file_exists( WP_PLUGIN_DIR . '/soo-demo-importer/includes/parsers.php' ) ) {
				return;
			}

			require_once WP_PLUGIN_DIR . '/soo-demo-importer/includes/parsers.php';
		}

		$parser      = new \WXR_Parser();
		$import_data = $parser->parse( $file );

		if ( empty( $import_data ) || is_wp_error( $import_data ) ) {
			return;
		}

		if ( isset( $import_data['posts'] ) ) {
			$posts = $import_data['posts'];

			if ( $posts && sizeof( $posts ) > 0 ) {
				foreach ( $posts as $post ) {
					if ( 'product' === $post['post_type'] ) {
						if ( ! empty( $post['terms'] ) ) {
							foreach ( $post['terms'] as $term ) {
								if ( strstr( $term['domain'], 'pa_' ) ) {
									if ( ! taxonomy_exists( $term['domain'] ) ) {
										$attribute_name = wc_sanitize_taxonomy_name( str_replace( 'pa_', '', $term['domain'] ) );

										// Create the taxonomy
										if ( ! in_array( $attribute_name, wc_get_attribute_taxonomies() ) ) {
											$attribute = array(
												'attribute_label'   => $attribute_name,
												'attribute_name'    => $attribute_name,
												'attribute_type'    => 'select',
												'attribute_orderby' => 'menu_order',
												'attribute_public'  => 0
											);
											$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
											delete_transient( 'wc_attribute_taxonomies' );
										}

										// Register the taxonomy now so that the import works!
										register_taxonomy(
											$term['domain'],
											apply_filters( 'woocommerce_taxonomy_objects_' . $term['domain'], array( 'product' ) ),
											apply_filters( 'woocommerce_taxonomy_args_' . $term['domain'], array(
												'hierarchical' => true,
												'show_ui'      => false,
												'query_var'    => true,
												'rewrite'      => false,
											) )
										);
									}
								}
							}
						}
					}
				}
			}
		}
	}
}