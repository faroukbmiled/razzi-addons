<?php
namespace Razzi\Addons\Elementor\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Base\Module;
use Elementor\Controls_Manager;

class Column_Settings extends Module {

	/**
	 * Get module name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'column-settings';
	}


	/**
	 * Module constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/column/section_advanced/before_section_end', [ $this, 'register_controls' ], 10, 2 );
	}

	/**
	 * @param $element    Controls_Stack
	 */
	public function register_controls( $element ) {

		$element->add_responsive_control(
			'column_order',
			[
				'label' => esc_html__( 'Order', 'razzi' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'selectors' => [
					'{{WRAPPER}}' => 'order: {{VALUE}};',
				],
			]
		);
	}
}
