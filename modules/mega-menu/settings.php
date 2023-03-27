<?php

namespace Razzi\Addons\Modules\Mega_Menu;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings {

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

	private $option = 'rz_mega_menu';

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'settings_api_init' ) );

		if ( get_option( 'rz_mega_menu' ) == '1' ) {
			return;
		}

		$this->load();
		$this->init();
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'add_settings_link' ) );
	}

	/**
	 * Load files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function load() {
		if ( is_admin() ) {
			require_once RAZZI_ADDONS_DIR . 'modules/mega-menu/edit.php';
		}
	}

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	private function init() {
		if ( is_admin() ) {
			return \Razzi\Addons\Modules\Mega_Menu\Edit::instance();
		}
	}


		/**
	 * Add the mega menu settings link to the menu item.
	 *
	 * @since 2.0.0
	 * @param int $item_id
	 */
	public function add_settings_link( $item_id ) {
		$item_type_icon  		= get_post_meta( $item_id, 'tamm_menu_item_icon_type', true );
		$item_icon_svg   		= get_post_meta( $item_id, 'tamm_menu_item_icon_svg', true );
		$item_icon_image 		= get_post_meta( $item_id, 'tamm_menu_item_icon_image', true );
		$item_icon_color 		= get_post_meta( $item_id, 'tamm_menu_item_icon_color', true );
		$item_badges_text 		= get_post_meta( $item_id, 'tamm_menu_item_badges_text', true );
		$item_badges_bg_color 	= get_post_meta( $item_id, 'tamm_menu_item_badges_bg_color', true );
		$item_badges_color 		= get_post_meta( $item_id, 'tamm_menu_item_badges_color', true );
		$item_hide_text  		= get_post_meta( $item_id, 'tamm_menu_item_hide_text', true );
		$item_is_label   		= get_post_meta( $item_id, 'tamm_menu_item_is_label', true );
		$item_content    		= get_post_meta( $item_id, 'tamm_menu_item_content', true );
		$item_mega       		= get_post_meta( $item_id, 'tamm_menu_item_mega', true );
		$item_mega_align 		= get_post_meta( $item_id, 'tamm_menu_item_mega_align', true );
		$mega_width      		= get_post_meta( $item_id, 'tamm_menu_item_mega_width', true );

		$item_mega_background = wp_parse_args(
			get_post_meta( $item_id, 'tamm_menu_item_background', true ),
			array(
				'image'      => '',
				'color'      => '',
				'attachment' => 'scroll',
				'size'       => '',
				'repeat'     => 'no-repeat',
				'position'   => array(
					'x'      => 'left',
					'y'      => 'top',
					'custom' => array(
						'x' => '',
						'y' => '',
					)
				)
			)
		);

		$mega_data = sprintf('data-mega="%s"', intval( $item_mega ));
		$mega_data .= sprintf(' data-mega_align="%s"', esc_attr( $item_mega_align ));
		$mega_data .= sprintf(' data-mega_width="%s"', esc_attr( $mega_width ));
		$mega_data .= sprintf(' data-icon_image="%s"', esc_attr( $item_icon_image ));
		$mega_data .= sprintf(' data-icon_type="%s"', esc_attr( $item_type_icon ));
		$mega_data .= sprintf(' data-icon_color="%s"', esc_attr( $item_icon_color ));
		$mega_data .= sprintf(' data-badges_text="%s"', esc_attr( $item_badges_text ));
		$mega_data .= sprintf(' data-badges_bg_color="%s"', esc_attr( $item_badges_bg_color ));
		$mega_data .= sprintf(' data-badges_color="%s"', esc_attr( $item_badges_color ));
		$mega_data .= sprintf(' data-hide-text="%s"', intval( $item_hide_text ));
		$mega_data .= sprintf(' data-is-label="%s"', intval( $item_is_label ));
		$mega_data .= sprintf(' data-background=%s', json_encode( $item_mega_background ));
		?>
		<fieldset class="field-menu-settings hide-if-no-js description-wide">
			<span class="field-move-visual-label" aria-hidden="true"><?php esc_html_e( 'Mega Menu', 'razzi' ) ?></span>
			<span class="hidden tamm-data" <?php echo $mega_data; ?> aria-hidden="true"><?php echo trim( $item_content ); ?></span>
			<span class="hidden tamm-data-icons"><?php echo \Razzi\Icon::sanitize_svg( $item_icon_svg ); ?></span>
			<button type="button" class="item-config-mega opensettings button-link hide-if-no-js"><?php esc_html_e( 'Open Settings', 'razzi' ) ?></button>
		</fieldset>
		<?php
	}

	/**
	 * Add  field in 'Settings' > 'Writing'
	 * for enabling CPT functionality.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function settings_api_init() {
		add_settings_section(
			'razzi_mega_menu_section',
			'<span id="mega-menu-options">' . esc_html__( 'Mega Menu', 'razzi' ) . '</span>',
			array( $this, 'writing_section_html' ),
			'writing'
		);

		add_settings_field(
			$this->option,
			'<span class="mega-menu-options">' . esc_html__( 'Mega Menu', 'razzi' ) . '</span>',
			array( $this, 'disable_field_html' ),
			'writing',
			'razzi_mega_menu_section'
		);
		register_setting(
			'writing',
			$this->option,
			'intval'
		);
	}

	/**
	 * Add writing setting section
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function writing_section_html() {
		?>
        <p>
			<?php esc_html_e( 'Use these settings to disable mega menu of navigation on your site', 'razzi' ); ?>
        </p>
		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Services CPT setting.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function disable_field_html() {
		?>

        <label for="<?php echo esc_attr( $this->option ); ?>">
            <input name="<?php echo esc_attr( $this->option ); ?>"
                   id="<?php echo esc_attr( $this->option ); ?>" <?php checked( get_option( $this->option ), true ); ?>
                   type="checkbox" value="1"/>
			<?php esc_html_e( 'Disable Mega Menu for this site.', 'razzi' ); ?>
        </label>

		<?php
	}

}